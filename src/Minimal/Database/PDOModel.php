<?php namespace Maduser\Minimal\Database;

use Maduser\Minimal\Collections\Collection;
use Maduser\Minimal\Database\Exceptions\DatabaseException;
use Maduser\Minimal\Database\Exceptions\UndefinedColumnException;
use Maduser\Minimal\Database\Exceptions\ProtectedColumnException;

use Maduser\Minimal\Database\ORM\ORM;
use \PDO;
use PDOException;

/**
 * Class PDOModel
 */
abstract class PDOModel
{
    /**
     * Database table to use
     *
     * @var
     */
    protected $table;

    /**
     * Prefix database table name
     *
     * @var
     */
    protected $prefix;

    /**
     * Default order of the results
     *
     * @var string
     */
    protected $defaultOrderBy;

    /**
     * Default ID column
     *
     * @var string
     */
    protected $rowIdentifier = 'id';

    /**
     * Whether to use automatic timestamps
     *
     * @var bool
     */
    protected $timestamps = false;

    /**
     * Column name for 'created at" timestamp
     *
     * @var string
     */
    protected $timestampCreatedAt = 'created';

    /**
     * Column name for 'updated at" timestamp
     *
     * @var string
     */
    protected $timestampUpdatedAt = 'updated';

    /**
     * Column name for manual sorting
     *
     * @var string
     */
    protected $manualSort = null;

    /**
     * Default date format
     *
     * @var string
     */
    protected $dateFormat = "d.m.Y";

    /**
     * Default datetime format
     *
     * @var string
     */
    protected $dateTimeFormat = "d.m.Y - H:i";

    /**
     * Default time format
     *
     * @var string
     */
    protected $timeFormat = "H:i";

    /**
     * Placeholder for empty and null values
     *
     * @var string
     */
    protected $emptyColumnPlaceholder = '-';

    /**
     * Database connection
     *
     * @var
     */
    protected $db;

    /**
     * @var array
     */
    protected $idData = [];

    /**
     * @var array
     */
    protected $id;

    /**
     * @var null
     */
    protected $limit;

    /**
     * @var
     */
    protected $select;

    /**
     * @var
     */
    protected $where;

    /**
     * @var array
     */
    protected $wheres = [];

    /**
     * @var
     */
    protected $queryString;

    /**
     * @var null
     */
    protected $orderBy;

    /**
     * @var
     */
    protected $lastQuery;

    /**
     * @var
     */
    private $result;

    /**
     * @var
     */
    protected $state;

    /**
     * @return mixed
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @param mixed $queryString
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;
    }

    /**
     * @return array
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param array $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getLimit()
    {
        if (empty($this->limit)) {
            return null;
        }

        return " LIMIT " . intval($this->limit);
    }

    /**
     * @param null $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * 
     */
    public function clearLimit()
    {
        $this->limit = null;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->setLimit($limit);

        return $this;
    }

    /**
     * @param $select
     */
    public function setSelect($select)
    {
        $this->select = $select;
    }

    /**
     * @return string
     */
    public function getSelect()
    {
        return !empty($this->select) ?
            $this->select : "*";
    }

    public function clearSelect()
    {
        $this->select = "*";
    }

    /**
     * @param $select
     *
     * @return $this
     */
    public function select($select)
    {
        $this->setSelect($select);

        return $this;
    }

    /**
     * @param $string
     */
    public function setWhere($string)
    {
        $this->setWhere($string);
    }

    /**
     * @param $strOrArray
     */
    public function addWheres($strOrArray)
    {
        $this->wheres[] = $strOrArray;
    }

    /**
     * @return array
     */
    public function getWheres()
    {
        return $this->wheres;
    }

    /**
     *
     */
    public function clearWhere()
    {
        $this->where = '';
    }

    /**
     *
     */
    public function clearWheres()
    {
        $this->wheres = [];
    }

    /**
     * @param $param
     * @return array
     */
    protected function getCondition($param)
    {
        $key = null;
        $cond = "=";
        $value = null;
        $and = "AND";

        if (is_array($param)) {

            $count = count($param);

            if ($count > 1) {
                $key = $param[0];
                $value = $param[1];
            }

            if ($count > 2) {
                $key = $param[0];
                $cond = $param[1];
                $value = $param[2];
            }

            if ($count > 3) {
                $key = $param[0];
                $cond = $param[1];
                $value = $param[2];
                $and = $param[3];
            }
        }

        if (is_null($value) && $cond == "=") {
            return [
                "ISNULL(" . $key . ")",
                null,
                null,
                " " . trim($and) . " "
            ];
        }

        return [
            str_replace('``', '', "`" . $key . "`"),
            " " . trim($cond) . " ",
            is_null($value) ? "NULL" : $this->db->quote($value),
            " " . trim($and) . " "
        ];
    }

    /**
     * @return null|string
     */
    public function getWhere()
    {
        $condition = '';
        foreach ($this->getWheres() as $where) {
            list($key, $con, $val, $and) = $this->getCondition($where);
            $condition .= empty($condition) ? '' : $and;
            $condition .= $key . $con . $val;
        }

        return !empty($condition) ?
            " WHERE (" . $condition . ")" : null;
    }

    /**
     * @param $strOrArray
     *
     * @return $this
     */
    public function where($strOrArray)
    {
        foreach (func_get_args() as $arg) {
            $this->addWheres($arg);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @param string $dateFormat
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }

    /**
     * @return string
     */
    public function getDateTimeFormat()
    {
        return $this->dateTimeFormat;
    }

    /**
     * @param string $dateTimeFormat
     */
    public function setDateTimeFormat($dateTimeFormat)
    {
        $this->dateTimeFormat = $dateTimeFormat;
    }

    /**
     * @param $value
     * @return false|string
     */
    public function getFormatedDate($value)
    {
        return ($value == '0000-00-00') ? $this->getEmptyColumnPlaceholder() : date($this->getDateFormat(), strtotime($value));
    }

    /**
     * @param $value
     *
     * @return false|string
     */
    public function getFormatedDateTime($value)
    {
        return (is_null($value) || $value == '0000-00-00 00:00:00') ? $this->getEmptyColumnPlaceholder() : date($this->getDateTimeFormat(),
            strtotime($value));
    }

    /**
     * @param $value
     *
     * @return false|string
     */
    public function getFormatedTime($value)
    {
        return (is_null($value) || $value == '00:00:00') ? $this->getEmptyColumnPlaceholder() : date($this->getTimeFormat(),
            strtotime($value));
    }

    /**
     * @param $value
     * @param $format
     * @param string $placeholder
     * @return string
     */
    public function formatDatetime($value, $format, $placeholder = '-')
    {
        return (is_null($value) || $value == '0000-00-00 00:00:00') ?
            $placeholder : date($format, strtotime($value));
    }

    /**
     * @param $string
     */
    public function setDefaultOrderBy($string)
    {
        $this->defaultOrderBy = $string;
    }

    /**
     * @return null
     */
    public function getDefaultOrderBy()
    {
        $orderBy = $this->defaultOrderBy ?
            $this->defaultOrderBy : $this->getRowIdentifier();
        return $orderBy;
    }

    /**
     * @return string
     */
    public function getEmptyColumnPlaceholder()
    {
        return $this->emptyColumnPlaceholder;
    }

    /**
     * @param string $columnPlaceholder
     */
    public function setEmptyColumnPlaceholder($columnPlaceholder)
    {
        $this->emptyColumnPlaceholder = $columnPlaceholder;
    }

    /**
     * @param null $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @param $string
     * @param null $params
     */
    protected function setLastQuery($string, $params = null)
    {
        $this->lastQuery = [$string, $params];
    }

    /**
     * @return mixed
     */
    public function getLastQuery()
    {
        return $this->lastQuery;
    }

    /**
     * @return null
     */
    public function getOrderBy()
    {
        $orderBy = !empty($this->orderBy) ?
            $this->orderBy : null;

        $orderBy = $orderBy ?
            $orderBy : $this->getDefaultOrderBy();

        $direction = 'ASC';

        if (preg_match('/\sASC/i', $orderBy)) {
            $orderBy = trim(str_ireplace(' ASC', '', $orderBy));
        }

        if (preg_match('/\sDESC/i', $orderBy)) {
            $direction = 'DESC';
            $orderBy = trim(str_ireplace(' DESC', '', $orderBy));
        }

        $e = explode('.', $orderBy);

        if (count($e) > 1) {
            $this->addOtherTable($e[0]);
            $orderBy = " ORDER BY `" . $e[0] . "`.`" . $e[1] . "` " . $direction;
        } else {
            if ($orderBy == 'RAND()') {
                $orderBy = " ORDER BY RAND()";
            } else {
                $orderBy = " ORDER BY `" . $orderBy . "` " . $direction;
            }
        }

        return $orderBy;
    }

    /**
     * @param $str
     *
     * @return $this
     */
    public function orderBy($str)
    {
        $this->setOrderBy($str);
        return $this;
    }

    /**
     * @return string
     */
    public function getRowIdentifier()
    {
        return $this->rowIdentifier;
    }

    /**
     * @param string $rowIdentifier
     * @return PDOModel
     */
    public function setRowIdentifier($rowIdentifier)
    {
        $this->rowIdentifier = $rowIdentifier;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTimestamps()
    {
        return $this->timestamps;
    }

    /**
     * @param bool $timestamps
     * @return PDOModel
     */
    public function setTimestamps($timestamps)
    {
        $this->timestamps = $timestamps;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimestampCreatedAt()
    {
        return $this->timestampCreatedAt;
    }

    /**
     * @param string $timestampCreatedAt
     * @return PDOModel
     */
    public function setTimestampCreatedAt($timestampCreatedAt)
    {
        $this->timestampCreatedAt = $timestampCreatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimestampUpdatedAt()
    {
        return $this->timestampUpdatedAt;
    }

    /**
     * @param string $timestampUpdatedAt
     * @return PDOModel
     */
    public function setTimestampUpdatedAt($timestampUpdatedAt)
    {
        $this->timestampUpdatedAt = $timestampUpdatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getManualSort()
    {
        return $this->manualSort;
    }

    /**
     * @param string $manualSort
     * @return PDOModel
     */
    public function setManualSort($manualSort)
    {
        $this->manualSort = $manualSort;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimeFormat()
    {
        return $this->timeFormat;
    }

    /**
     * @param string $timeFormat
     * @return PDOModel
     */
    public function setTimeFormat($timeFormat)
    {
        $this->timeFormat = $timeFormat;
        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        global $pdo;
        $this->db = \Maduser\Minimal\Database\PDO::connection();
    }

    /**
     * @param mixed $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    public function getBasename()
    {
        return strtolower(str_replace('.php', '', basename(str_replace('\\', '/', get_class($this)))));

    }

    /**
     * @param bool $withPrefix
     * @return mixed
     */
    public function getTable($withPrefix = true)
    {
        if (is_null($this->table)) {
            $classBasename = (new \ReflectionClass($this))->getShortName();
            $this->setTable(strtolower($classBasename));
        }

        if ($withPrefix) {
            return $this->getPrefix() . $this->table;
        }

        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param mixed $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @var string
     */
    private $otherTables = '';

    /**
     * @return string
     */
    public function getOtherTables()
    {
        return $this->otherTables;
    }

    /**
     * @param $otherTable
     */
    public function addOtherTable($otherTable)
    {
        $this->otherTables .= ', ' . $otherTable;
    }

    /**
     * @param null $columnsSet
     *
     * @return array
     */
    public function getColumns($columnsSet = null)
    {
        $columnsSet = !is_null($columnsSet) ? $columnsSet : 'default';

        $columnsSets = $this->columns();

        if ($columnsSet == 'allColumnSets') {
            return $columnsSets;
        }

        $columns = $columnsSets[$columnsSet];

        return $this->populate($columns);
    }

    /**
     * @param null $fieldsetsSet
     * @return array
     */
    public function getFieldsets($fieldsetsSet = null)
    {
        $fieldsetsSet = !is_null($fieldsetsSet) ? $fieldsetsSet : 'default';

        $fieldsetsSets = $this->fieldsets();

        if ($fieldsetsSet == 'allFieldsetSets') {
            return $fieldsetsSets;
        }

        $fieldsets = $fieldsetsSets[$fieldsetsSet];

        return $fieldsets;
    }

    /**
     * @return array
     */
    public function getIdData()
    {
        return $this->idData;
    }

    /**
     * @param array $idData
     */
    public function setIdData($idData)
    {
        $this->idData = $idData;
    }


    protected function setState(array $state)
    {
        $this->state = $state;
    }

    /**
     * @return $this
     * @throws DatabaseException
     */
    public function query()
    {
        $sqlWhere = '';
        if (!empty($this->getWhere())) {
            $sqlWhere = $this->getWhere();
        }

        $sqlLimit = '';
        if (!empty($this->getLimit())) {
            $sqlLimit = $this->getLimit();
        }

        $sqlOrder = '';
        $orderBy = $this->getOrderBy();
        if (!empty($orderBy)) {
            $sqlOrder = $orderBy;
        }

        $sqlSelect = "SELECT " . $this->getSelect();
        $sqlFrom = " FROM " . $this->getTable() . $this->getOtherTables();

        $sql = $sqlSelect . $sqlFrom . $sqlWhere . $sqlOrder . $sqlLimit;

        $this->setLastQuery($sql);

        try {
            $results = $this->db->query($sql);
        } catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage() .'<br>'.$this->getLastQuery()[0]);
        }

        $this->setResult($results);

        $this->clearSelect();
        $this->clearWhere();
        $this->clearWheres();
        $this->clearLimit();

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * Return all the rows of this table
     *
     * @param null $sql Optional query string
     *
     * @return array|null
     * @throws DatabaseException
     */
    public function getAll($sql = null)
    {
        if ($sql) {
            $this->setLastQuery($sql);

            try {
                $results = $this->db->query($sql);
            } catch (\PDOException $e) {
                throw new DatabaseException($e->getMessage() . '<br>' . $this->getLastQuery()[0]);
            }

            return $this->fetchAssoc($results);
        }

        try {
            $results = $this->query();
        } catch (\PDOException $e) {

            throw new DatabaseException($e->getMessage() . '<br>' . $this->getLastQuery()[0]);
        }

        //return $results->fetchAssoc();
        return $results->fetchToCollection();
    }

    /**
     * Return the first the matching row
     *
     * @param null $sql Optional query string
     *
     * @return array|null
     * @throws DatabaseException
     */
    public function getFirst($sql = null)
    {
        if ($sql) {
            $this->setLastQuery($sql);

            try {
                $result = $this->db->query($sql);
            } catch (\PDOException $e) {
                throw new DatabaseException($e->getMessage() . '<br>' . $this->getLastQuery()[0]);
            }

            $this->fetchAssoc($result);
            if (isset($data[0])) {
                return $data[0];
            }
            return null;
        }

        $row = $this->limit(1)->query()->fetchAssoc();


        if (isset($row[0])) {
            //return $data[0];
            $class = get_class($this);
            $obj = new $class();
            $obj->setState($row[0]);

            return $obj;
        }

        return null;
    }

    /**
     * Select a row by id from this table
     *
     * @param $id
     *
     * @return array|null
     * @throws DatabaseException
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM " . $this->getTable() . " WHERE " . $this->getRowIdentifier() . " = " . intval($id) . ";";

        try {
            $result = $this->db->query($sql);
        } catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage() . '<br>' . $sql);
        }

        $data = $this->fetchAssoc($result);

        $this->setIdData($data);


        if (isset($data[0])) {
            //return $data[0];
            $class = get_class($this);
            $obj = new $class();
            $obj->setState($data[0]);
            return $obj;
        }
        return null;
    }

    /**
     * Count rows
     *
     * @return int|null
     * @throws DatabaseException
     */
    public function count()
    {
        $this->select("COUNT(".$this->getRowIdentifier().") as count");

        try {
            $results = $this->query();
        } catch (\PDOException $e) {

            throw new DatabaseException($e->getMessage() . '<br>' . $this->getLastQuery()[0]);
        }

        $results = $results->fetchAssoc();

        return $results[0]['count'];
    }

    public function truncate()
    {
        $sql = 'TRUNCATE TABLE `'.$this->getTable(true).'`;';
        try {
            $results = $this->db->query($sql);
        } catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage() . '<br>' . $sql);
        }
        return true;
    }

    /**
     * Mysql result fetch
     *
     * @param $result
     *
     * @return array|null
     */
    protected function fetchAssoc($result = null)
    {
        $result = $result ? $result : $this->getResult();

        $rows = [];

        if ($result->rowCount() > 0) {
            $results = $result->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $key => $value) {
                $rows[$key] = $value;
            }
        }

        return $rows;
    }

    /**
     * Mysql result fetch
     *
     * @param $result
     *
     * @return Collection|null
     */
    protected function fetchToCollection($result = null)
    {
        $result = $result ? $result : $this->getResult();

        if ($result->rowCount() > 0) {
            $results = $result->fetchAll(PDO::FETCH_ASSOC);
            $collection = new Collection();
            foreach ($results as $key => $value) {
                $class = get_class($this);
                $obj = new $class();
                $obj->setState($value);
                $collection->add($obj);
            }

            return $collection;
        }

        return null;
    }

    protected function isDefinedColumn($name)
    {
        $columns = $this->getColumns();

        foreach ($columns as $column) {
            if ($name == $column['name']) {
                return true;
            }
        }

        return false;
    }

    protected function isWritableColumn($name)
    {
        $columns = $this->getColumns();

        foreach ($columns as $column) {
            if ($name == $column['name']) {
                if (isset($column['writable']) && !$column['writable']) {
                    return false;
                } else {
                    return true;
                }
            }
        }

        return true;
    }


    public function getColumnDefinition($name, $columnSet = null)
    {
        $columns = $this->getColumns($columnSet);
        foreach ($columns as $column) {
            if ($name == $column['name']) {
                return $column;
            }
        }
        return null;
    }

    /**
     * @param $inserts
     * @return null
     * @throws DatabaseException
     */
    public function insert($inserts)
    {
        $strCols = "";
        $strValues = "";

        $params = [];
        $setStr = "";

        foreach ($inserts as $key => $value) {
            if ($key != $this->getRowIdentifier()) {

                $column = $this->getColumnDefinition($key);

                // The column name must be defined in the model
                if (is_null($column)) {
                    throw new UndefinedColumnException("Undefined column '" . $key."'");
                }

                if (!isset($column['belongsToMany'])) {

                    $setStr .= "`" . str_replace("`", "``", $key) . "` = :" . $key . ",";

                    $value = $this->getValue($value, $column);
                    $value = is_array($value) ? json_encode($value) : $value;

                    $params[':' . $key] = $value;
                }
            }
        }

        if ($this->timestamps && !is_null($this->timestampCreatedAt)) {
            $params[':' . $this->timestampCreatedAt] = date('Y-m-d H:i:s');
            $setStr .= "`" . str_replace("`", "``", $this->timestampCreatedAt) .
                "` = :" . $this->timestampCreatedAt . ",";
        }

        $paramStr = implode("`".',', array_keys($params));
        $colStr = str_replace(':', "`", $paramStr) . "`";
        $paramStr = str_replace("`", "", $paramStr);

        $sql = "INSERT INTO " . $this->getTable() .
            " (" . $colStr . ") VALUES (" . $paramStr . ")";

        try {
            $stmt = $this->db->prepare($sql);
            $this->setLastQuery($stmt->queryString, $params);
            $stmt->execute($params);
        } catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage() . '<br> ' . show([$sql, $params], null, false), $this);
        }

        $insertId = $this->getInsertId($this->getTable());

        if ($this->manualSort) {
            $this->updateOrder($insertId);
        }

        $this->handleRelations($insertId, $inserts);

        return $insertId;
    }

    public function handleRelations($id, $inserts)
    {
        // Because multiselects with no selection aren't posted,
        // we have to loop over the known columns

        $columns = $this->getColumns();
        foreach ($columns as $column) {
            if (isset($column['belongsToMany'])) {

                $relatedModel = new $column['belongsToMany']['model'];

                $joinTable = isset($column['belongsToMany']['table']) ?
                    $column['belongsToMany']['table'] : null;

                $identifier = isset($column['belongsToMany']['identifier']) ?
                    $column['belongsToMany']['identifier'] : null;

                // Find what is already attached
                if ($selectedOptions = $this->getRelated($relatedModel, $id)) {

                    // Find attached entities that were not in post
                    $detachableIds = [];
                    foreach ($selectedOptions as $selected) {
                        if (isset($inserts[$column['name']])) {
                            if (!in_array($selected['id'], $inserts[$column['name']])) {
                                $detachableIds[] = $selected['id'];
                            }
                        } else {
                            $detachableIds[] = $selected['id'];
                        }
                    }

                    // Detach related entities that were not in post
                    $this->detach($relatedModel, $detachableIds, $id, $joinTable, $identifier);
                }

                // Attach entities that were in post
                if (isset($inserts[$column['name']])) {
                    $this->attach($relatedModel, $inserts[$column['name']], $id, $joinTable, $identifier);
                }

            }
        }

    }

    public function getRelated(
        $relatedModel,
        $id,
        $joinTable = null,
        $relatedIdentifier = null,
        $localIdentifier = null
    )
    {
        $columns = $this->getColumns();

        $foundRelationship = false;

        foreach ($columns as $column) {

            if (isset($column['belongsToMany'])
                && $column['name'] == $relatedModel->getBasename() . '_id'
            ) {

                $foundRelationship = true;

                $joinTable = is_null($joinTable) && isset($column['belongsToMany']['table']) ?
                    $column['belongsToMany']['table'] : null;

                $joinTable = $joinTable ? $joinTable : $this->makeJoinTableName($relatedModel);
                $relatedIdentifier = $relatedIdentifier ? $relatedIdentifier : $relatedModel->getTable(false) . '_id';
                $localIdentifier = $localIdentifier ? $localIdentifier : $this->getTable(false) . '_id';
            }
        }

        if (!$foundRelationship) {
            throw new DatabaseException("Undefined relationship " . get_class($relatedModel));
        }

        $sql = "SELECT " . $relatedModel->getTable() . ".*
				FROM " . $relatedModel->getTable() . " 
				INNER JOIN " . $joinTable . " 
				ON " . $joinTable . "." . $relatedIdentifier . " = " . $relatedModel->getTable() . ".".$relatedModel->getRowIdentifier()."
				WHERE " . $joinTable . "." . $localIdentifier . " = '" . $id . "'";

        $this->setLastQuery($sql);
        $result = $this->db->query($sql);

        return $this->fetchAssoc($result);
    }

    /**
     * @return mixed
     */
    public function getInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * @param $insertId
     */
    public function updateOrder($insertId)
    {
        $sql_order = "UPDATE " . $this->getTable() . " 
				SET ".$this->getManualSort()." = '" . intval($insertId) . "' 
				WHERE ".$this->getRowIdentifier()." = '" . intval($insertId) . "';";

        $this->db->query($sql_order);
    }

    /**
     * @param $id
     * @param $inserts
     * @return null
     * @throws DatabaseException
     */
    public function update($id, $inserts)
    {
        $params = [];
        $setStr = "";

        // This has to be in order to populate $column['value'],
        // which is required for handling uploads
        $this->getById($id);

        foreach ($inserts as $key => $value) {
            if ($key != $this->getRowIdentifier()) {

                $column = $this->getColumnDefinition($key);

                // The column name must be defined in the model
                if (is_null($column)) {
                    throw new UndefinedColumnException("Undefined column '" . $key . "'");
                }

                if (!isset($column['belongsToMany'])) {

                    $setStr .= "`" . str_replace("`", "``", $key) . "` = :" . $key . ",";

                    $value = $this->getValue($value, $column);
                    $value = is_array($value) ? json_encode($value) : $value;

                    $params[':' . $key] = $value;
                }
            }
        }

        if ($this->timestamps && !is_null($this->timestampUpdatedAt)) {
            $params[':' . $this->timestampUpdatedAt] = date('Y-m-d H:i:s');
            $setStr .= "`" . str_replace("`", "``", $this->timestampUpdatedAt) .
                "` = :" . $this->timestampUpdatedAt . ",";
        }

        $params[':id'] = $id;

        $sql = "UPDATE " . $this->getTable() . " SET " . rtrim($setStr, ',') .
            " WHERE " . $this->getRowIdentifier() . " = :id";

        try {
            $stmt = $this->db->prepare($sql);
            $this->setLastQuery($stmt->queryString, $params);

            $stmt->execute($params);
        } catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage() . '<br> ' . $this->getLastQuery(),
                $this);
        }

        $this->handleRelations($id, $inserts);

        return $stmt->rowCount();
    }


    public function makeJoinTableName($relatedModel)
    {
        $tableNames = [$this->getTable(false), $relatedModel->getTable(false)];
        sort($tableNames);
        return $this->getPrefix() . $tableNames[0] . "_has_" . $tableNames[1];
    }


    /**
     * @param $relatedModel
     * @param array $ids
     * @param $id
     * @param null $joinTable
     * @param null $relatedIdentifier
     * @param null $localIdentifier
     */
    public function attach(
        $relatedModel,
        Array $ids,
        $id,
        $joinTable = null,
        $relatedIdentifier = null,
        $localIdentifier = null
    ) {
        $relatedIds = [];

        $joinTable = $joinTable ? $joinTable : $this->makeJoinTableName($relatedModel);
        $relatedIdentifier = $relatedIdentifier ? $relatedIdentifier : $relatedModel->getTable(false) . '_id';
        $localIdentifier = $localIdentifier ? $localIdentifier : $this->getTable(false) . '_id';

        foreach ($ids as $relatedId) {

            $sql = "SELECT id FROM " . $joinTable . " 
				WHERE " . $localIdentifier . " = '" . $id . "' AND " . $relatedIdentifier . " = '" . intval($relatedId) . "'";

            $result = $this->db->query($sql);

            if (count($this->fetchAssoc($result)) == 0) {
                $sqlInsert = "INSERT INTO " . $joinTable . " 
					(" . $localIdentifier . ", " . $relatedIdentifier . ") 
					VALUES ('" . $id . "', '" . intval($relatedId) . "')";
                $this->db->query($sqlInsert);
            }
        }
    }


    /**
     * @param $relatedModel
     * @param array $ids
     * @param $id
     * @param null $joinTable
     * @param null $relatedIdentifier
     * @param null $localIdentifier
     */
    public function detach(
        $relatedModel,
        Array $ids,
        $id,
        $joinTable = null,
        $relatedIdentifier = null,
        $localIdentifier = null
    ) {

        $joinTable = $joinTable ? $joinTable : $this->makeJoinTableName($relatedModel);
        $relatedIdentifier = $relatedIdentifier ? $relatedIdentifier : $relatedModel->getTable(false) . '_id';
        $localIdentifier = $localIdentifier ? $localIdentifier : $this->getTable(false) . '_id';

        foreach ($ids as $relatedId) {
            $sql = "DELETE FROM " . $joinTable . "
				WHERE " . $localIdentifier . " = '" . $id . "' AND " . $relatedIdentifier . " = '" . intval($relatedId) . "'";
            $this->db->query($sql);
        }
    }

    /**
     * @param $id
     */
    public function change_order_up($id)
    {
        $id_previous = 0;
        $order_old = 0;
        $order_new = 0;

        $i = 1;
        $id_1 = '';
        $order_1 = '';
        $id_2 = '';
        $order_2 = '';
        $found = false;

        // SQL: String wird erstellt.
        $sql = "SELECT * FROM " . $this->getTable() . " " .
            "ORDER by " . $this->getManualSort() . " ASC";

        $result = $this->db->query($sql); // SQL: SQL-String wird ausgeführt.

        // SQL-LOOP: Daten werden ausgelesen.
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if (!$found) {
                if ($i) {
                    $id_1 = $row[$this->getRowIdentifier()];
                    $order_1 = $row[$this->getManualSort()];
                } else {
                    $id_2 = $row[$this->getRowIdentifier()];
                    $order_2 = $row[$this->getManualSort()];
                }

                $i ^= 1;

                if ($row[$this->getRowIdentifier()] == $id) {
                    $found = true;
                }
            }
        }


        if ($id_1 == $id) {
            $id_previous = $id_2;
            $order_old = $order_1;
            $order_new = $order_2;
        } else {
            $id_previous = $id_1;
            $order_old = $order_2;
            $order_new = $order_1;
        }


        // SQL: String wird erstellt.
        $sql_update_new = "UPDATE " . $this->getTable() . " " .
            "SET ". $this->getManualSort()." = '" . intval($order_new) . "' " .
            "WHERE " . $this->getRowIdentifier() . " = '" . intval($id) . "';";

        $this->db->query($sql_update_new); // SQL: Abfragen wird ausgeführt.

        // SQL: String wird erstellt.
        $sql_update_previous = "UPDATE " . $this->getTable() . " " .
            "SET ". $this->getManualSort()." = '" . intval($order_old) . "' " .
            "WHERE ". $this->getRowIdentifier()." = '" . intval($id_previous) . "';";

        $this->db->query($sql_update_previous); // SQL: Abfragen wird ausgeführt.
    }

    /**
     * @param $id
     */
    public function change_order_down($id)
    {
        $id_previous = 0;
        $order_old = 0;
        $order_new = 0;

        $i = 1;
        $id_1 = '';
        $order_1 = '';
        $id_2 = '';
        $order_2 = '';
        $found = false;
        $next = false;


        // SQL: String wird erstellt.
        $sql = "SELECT * FROM " . $this->getTable() . " " .
            "ORDER by ". $this->getManualSort()." ASC";
        $result = $this->db->query($sql); // SQL: String wird ausgeführt.

        // SQL-LOOP: Daten werden ausgelesen.
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            if (!$next) {
                if ($i) {
                    $id_1 = $row[$this->getRowIdentifier()];
                    $order_1 = $row[$this->getManualSort()];
                } else {
                    $id_2 = $row[$this->getRowIdentifier()];
                    $order_2 = $row[$this->getManualSort()];
                }

                $i ^= 1;

                if ($found) {
                    $next = true;
                }

                if ($row[$this->getRowIdentifier()] == $id) {
                    $found = true;
                }
            }
        }

        if ($id_1 == $id) {
            $id_previous = $id_2;
            $order_old = $order_1;
            $order_new = $order_2;
        } else {
            $id_previous = $id_1;
            $order_old = $order_2;
            $order_new = $order_1;
        }


        // SQL: String wird erstellt.
        $sql_update_new = "UPDATE " . $this->getTable() . " " .
            "SET " . $this->getManualSort() . " = '" . intval($order_new) . "' " .
            "WHERE ".$this->getRowIdentifier()." = '" . intval($id) . "';";
        $this->db->query($sql_update_new); // SQL: Abfrage wird ausgeführt.


        // SQL: String wird erstellt.
        $sql_update_previous = "UPDATE " . $this->getTable() . " " .
            "SET ".$this->getManualSort()." = '" . intval($order_old) . "' " .
            "WHERE " . $this->getRowIdentifier() . " = '" . intval($id_previous) . "';";
        $this->db->query($sql_update_previous);    // SQL: Abfrage wird ausgeführt.

    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        $delete = "DELETE FROM " . $this->getTable() . " " .
            "WHERE ".$this->getRowIdentifier()." = '" . intval($id) . "' LIMIT 1 ;";

        return $this->db->query($delete);
    }

    /**
     * @param $value
     * @param $column
     * @return string
     * @internal param $data
     */
    //public function getValue($data, $column)
    public function getValue($value, $column)
    {
        // Nothing to do here if $value is not a array
        if (!is_array($value)) {
            return $value;
        }

        // We need a special handling for multiselect input types
        if ($column['inputType'] == 'multiselect') {
            $array = [];
            foreach ($value as $v) {
                $array[] = $v;
            }
            return json_encode($array);
        }

        // We need special handling for uploaded files
        if ($column['inputType'] == 'fileUpload') {
            if (isset($value['delete'])) {
                $this->handleFileDeletion($column);
                $column['value'] = '';
            }
            return $this->handleImageUpload($value, $column);
        }

        // We need special handling for uploaded files
        if ($column['inputType'] == 'imageUpload') {
            if (isset($value['delete'])) {
                $this->handleFileDeletion($column);
                $column['value'] = '';
            }
            return $this->handleFileUpload($value, $column);
        }

        return '';
    }

    /**
     * @param $data
     * @param $column
     * @return string
     */
    public function _getValue($data, $column)
    {
        if (!is_array($data[$column['name']])) {
            return $data[$column['name']];
        }

        // We need a special handling for multiselect input types
        if ($column['inputType'] == 'multiselect') {
            $values = $data[$column['name']];
            $array = [];
            foreach ($values as $value) {
                $array[] = $value;
            }
            return json_encode($array);
        }

        // We need special handling for uploaded files
        if ($column['inputType'] == 'fileUpload') {
            if (isset($data[$column['name']]['delete'])) {
                $this->handleFileDeletion($column);
                $column['value'] = '';
            }
            return $this->handleImageUpload($data[$column['name']], $column);
        }

        // We need special handling for uploaded files
        if ($column['inputType'] == 'imageUpload') {
            if (isset($data[$column['name']]['delete'])) {
                $this->handleFileDeletion($column);
                $column['value'] = '';
            }
            return $this->handleFileUpload($data[$column['name']], $column);
        }

        return '';
    }

    /**
     * @param $data
     * @param $column
     * @return string
     */
    public function handleFileUpload($data, $column)
    {
        if (!empty($data['name'])) {

            // Delete the old file
            $this->handleFileDeletion($column);

            // Save the new file
            if ($filename = $this->saveFileToStorage($data,
                realpath(ROOT . $column['uploadDir']) . '/')) {
                return $filename;
            } else {
                die('Could not handle image upload');
            }
        }

        // Keep as is
        return isset($column['value']) ? $column['value'] : null;
    }

    /**
     * @param $data
     * @param $column
     * @return string
     */
    public function handleImageUpload($data, $column)
    {
        if (!empty($data['name'])) {

            // Delete the old file
            $this->handleFileDeletion($column);

            // Save the new file
            if ($filename = $this->saveFileToStorage($data,
                realpath(ROOT . $column['uploadDir']) . '/')) {
                return $filename;
            } else {
                die('Could not handle image upload');
            }
        }
        // Keep as is
        return $column['value'];
    }

    /**
     * @param $column
     * @return bool
     */
    public function handleFileDeletion($column)
    {
        if (isset($column['value'])) {
            if ($this->deleteFileFromStorage($column['value'],
                ROOT . $column['uploadDir'])
            ) {
                return true;
            }

            return false;
        }
        return null;
    }

    /**
     * @param $file
     * @param $target
     * @return string
     */
    public function saveFileToStorage($file, $target)
    {
        $filename = substr($file['name'], 0, -4);
        $fileExt = str_replace($filename, '', $file['name']);

        $form = new \Form('basis');
        $filename = time() . '-' . strtolower($form->replace_chars($filename));

        move_uploaded_file($file['tmp_name'], $target . $filename . $fileExt);
        return $filename . $fileExt;
    }

    /**
     * @param $file
     * @param $target
     * @return bool
     */
    public function deleteFileFromStorage($file, $target)
    {
        if (!empty($file)) {
            return unlink($target . $file);
        }
    }

    /**
     * @param $files
     * @return array
     */
    public function normalizedFilesArray($files)
    {
        $keys = [];
        foreach ($files['name'] as $key => $value) {
            $keys[] = $key;
        };

        $newFilesArray = [];
        $i = 0;
        foreach ($keys as $key) {
            $newFilesArray[$key] = [
                'name' => $files['name'][$key],
                'type' => $files['type'][$key],
                'tmp_name' => $files['tmp_name'][$key],
                'error' => $files['error'][$key],
                'size' => $files['size'][$key]
            ];
            $i++;
        }
        return $newFilesArray;
    }

    /**
     * @return array
     */
    public function getInputs()
    {
        if (isset($_POST[$this->getBasename()])) {
            $post = $_POST[$this->getBasename()];
        } else {
            $post = [];
        }

        // include $_FILES
        $files = isset($_FILES[$this->getBasename()]) ? $this->normalizedFilesArray($_FILES[$this->getBasename()]) : [];

        // include checkboxes that are not hidden and unchecked
        $checkboxes = $this->findUncheckedButVisibleCheckboxes();

        $unsubmitedVisibleCheckboxes = [];
        foreach ($checkboxes as $checkbox) {
            $unsubmitedVisibleCheckboxes[$checkbox] = '0';
        }

        $fields = array_merge_recursive($post, $files);

        if (count($unsubmitedVisibleCheckboxes) > 0) {
            $fields = array_merge($fields, $unsubmitedVisibleCheckboxes);
        }

        return $fields;
    }

    public function findUncheckedButVisibleCheckboxes()
    {
        $checkboxes = [];
        $columns = $this->getColumns();
        foreach ($columns as $column) {
            if ($column['inputType'] == 'checkbox' && $column['hideInForm'] !== true) {
                if (!isset($_POST[$this->getBasename()][$column['name']])) {
                    $checkboxes[] = $column['name'];
                }
            }
        }
        return $checkboxes;
    }


    /**
     * @return array
     */
    public function populate($columns)
    {
        if (count($this->idData) == 0) {
            // nothing to populate with
            return $columns;
        } else {
            // For each row (there is always and only one because of fetchAssoc)
            foreach ($this->idData as $row) {
                // For each column of the row
                foreach ($row as $key => $value) {
                    // Find a matching name in the columns array
                    foreach ($columns as &$column) {

                        if (isset($column['modelName'])) {
                            // Query related model

                        } else {
                            // Populate a matching column
                            if ($column['name'] == $key) {
                                $column['value'] = $value;
                            }
                        }
                    }
                }
            }
        }
        return $columns;
    }

    /**
     * @param        $rows
     * @param        $useKeyAsId
     * @param        $useValueAsName
     * @param string $firstItem
     *
     * @return array
     */
    public function multiselect($rows, $useKeyAsId, $useValueAsName, $firstItem = 'Please select')
    {
        $array = [];
        if (count($rows) > 0) {
            foreach ($rows as $item) {
                $array[$item[$useKeyAsId]] = $item[$useValueAsName];
            }

            if ($firstItem) {
                $array = ['0' => __($firstItem)] + $array;
            }
        }
        return $array;
    }

    /**
     * @param $value
     * @param $column
     * @return string
     */
    public function getSelectBoxValue($value, $column)
    {
        if (!empty($value)) {
            $inputOptions = $column['inputOptions']();
            return isset($inputOptions[$value]) ? $inputOptions[$value] : $this->getEmptyColumnPlaceholder();
        }
        return $this->getEmptyColumnPlaceholder();
    }

    /**
     * @param $value
     * @param $column
     * @return string
     */
    public function getMultiselectValue($value, $column)
    {
        if (!empty($value)) {
            $inputOptions = $column['inputOptions']();
            $values = json_decode($value);
            $output = '';
            foreach ($values as $value) {
                $output = empty($output) ? $output : $output . ', ';
                $output .= isset($inputOptions[$value]) ? $inputOptions[$value] : '';
            }
            return $output;
        }
        return $this->getEmptyColumnPlaceholder();
    }

    /**
     * @param $value
     * @param $column
     * @return array|null
     */
    public function getMultiselectSelection($value, $column)
    {
        if (!empty($value)) {
            $values = json_decode($value);
            $inputOptions = $column['inputOptions']();
            $array = [];
            foreach ($values as $value) {
                if (isset($inputOptions[$value])) {
                    $array[$inputOptions[$value]] = $value;
                }
            }
            return $array;
        }
        return null;
    }

    /**
     * @param $from
     * @param $to
     * @return array
     */
    public function selectOptionsFromRange($from, $to)
    {
        $values = range($from, $to);
        $items = [];
        foreach ($values as $key => $value) {
            $items[] = [
                'key' => $key,
                'value' => $value
            ];
        }
        return $items;
    }

    public function tableExists()
    {
        $sql = "SELECT * 
            FROM information_schema.tables
            WHERE table_schema = '" . MYSQL_DATABASE . "' 
                AND table_name = '" . $this->getTable() . "'
            LIMIT 1;";

        $result = $this->db->query($sql);

        return count($this->fetchAssoc($result)) > 0;
    }

    public function createTable()
    {
        if (!$this->tableExists()) {

            $sql = "CREATE TABLE `".$this->getTable()."` (";

            $str = '';
            foreach ($this->getColumns() as $column) {

                if ($column['type']) {
                    $str = empty($str) ? $str : $str . ", ";

                    if ($this->getRowIdentifier() == $column['name']) {
                        $str .= "`".$column['name']. "` " . strtolower($column['type']);
                    } else {
                        $str .= "`" . $column['name'] . "` " . strtolower($column['type']);
                    }
                }

            }

            $sql .= $str . ");";


            try {
                $this->setLastQuery($sql);
                $this->db->exec($sql);
                return $sql;
            } catch (PDOException $e) {
                return $e->getMessage() .': '. $sql;
            }
        }

        return true;
    }



    public function toArray()
    {
        return $this->state;
    }

    public function __get($name)
    {
        return $this->{'get' . ucfirst($name)}();
    }

    public function __call($name, $arguments)
    {
        $prefix = 'get';

        if (substr($name, 0, strlen($prefix)) == $prefix) {
            $name = lcfirst(substr($name, strlen($prefix)));
            if (array_key_exists($name, $this->state)) {
                return $this->state[$name];
            }
        }

        throw new MinimalException('Key ' . $name . ' does not exist.');
    }

}