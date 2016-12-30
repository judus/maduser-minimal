<?php

namespace Maduser\Minimal\Libraries;

/**
 * TODO: Complete overhaul
 * I dragged and dropped this from another project, it has not been adapted yet.
 */

/**
 * Example of usage:
 */
/*
require "../libraries/Database.php";
require "../libraries/DbModel.php";

$databaseConnections = [
    'default' => [
        'server' => 'localhost',
        'database' => 'database',
        'username' => 'username',
        'password' => 'password'
    ]
];

$database = new Maduser\Minimal\Libraries\Database();
$db = $database->connect();

$model = new \Maduser\Minimal\Libraries\DbModel($db);
$model->setTable('artisans');
show($model->select('*')->where(
    ['name', 'LIKE', '%Kylie%'],
    ['bodyratings', '>', '6'],
    ['artisanratings', '>=', '8']
)->getAll());
show($model->getLastQuery());
die();
*/


/**
 * Class BaseModel
 */
class DbModel
{
    /**
     * Database connection
     *
     * @var
     */
    protected $db;

    /**
     * Database table to use
     *
     * @var
     */
    protected $table;

    /**
     * @var null
     */
    protected $defaultOrderBy = 'id';

    /**
     * @var string
     */
    protected $dateFormat = "d.m.Y";

    /**
     * @var string
     */
    protected $dateTimeFormat = "d.m.Y - H:i";

    /**
     * @var string
     */
    protected $emptyColumnPlaceholder = '-';

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
     * @param $limit
     *
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
     *
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

        return [
            $key,
            " " . trim($cond) . " ",
            "" . $this->db->quote($value) . "",
            " " . $and . " "
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
     *
     * @return false|string
     */
    public function getFormatedDate($value)
    {
        return ($value == '0000-00-00') ? '-' : date($this->getDateFormat(),
            strtotime($value));
    }

    /**
     * @param $value
     *
     * @return false|string
     */
    public function getFormatedDateTime($value)
    {
        return ($value == '0000-00-00 00:00:00') ? '-' : date($this->getDateTimeFormat(),
            strtotime($value));
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
        return $this->defaultOrderBy;
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
     * @var null
     */
    protected $orderBy = null;

    /**
     * @param null $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @var
     */
    protected $lastQuery;

    /**
     * @param $string
     */
    protected function setLastQuery($string)
    {
        $this->lastQuery = $string;
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

        $orderBy = $orderBy ?
            " ORDER BY " . $this->db->quote($orderBy) : null;

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
     * PollModel constructor
     *
     * @param      $db
     * @param null $table
     */
    public function __construct($db = null, $table = null)
    {
        $this->db = $db ? $db : $this->db;
        $this->table = $table ? $table : $this->table;
    }

    /**
     * @param mixed $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
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

    /**
     * @return $this
     */
    public function query()
    {
        $sql = "SELECT " . $this->getSelect();
        $sql .= " FROM " . $this->getTable();

        if (!empty($this->getWhere())) {
            $sql .= $this->getWhere();
        }

        if (!empty($this->getLimit())) {
            $sql .= $this->getLimit();
        }

        if (!empty($this->getOrderBy())) {
            $sql .= $this->getOrderBy();
        }

        $this->setLastQuery($sql);
        $this->setResult($this->db->query($sql));

        $this->clearWhere();
        $this->clearWheres();

        return $this;
    }

    /**
     * @var
     */
    private $result;

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
     * @return array|null
     */
    public function getAll()
    {
        return $this->query()->fetchAssoc();
    }

    /**
     * Select a row by id from this table
     *
     * @param $id
     *
     * @return array|null
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id	= " . intval($id) . ";";
        $result = $this->db->query($sql);
        $data = $this->fetchAssoc($result);
        $this->setIdData($data);

        return $data[0];
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
        if ($result) {
            while ($row = $result->fetchAll(\PDO::FETCH_ASSOC)) {
                $rowData = [];
                foreach ($row as $key => $value) {
                    $rowData[$key] = $value;
                }
                $rows = $rowData;
            }
        }

        return $rows;
    }

    /**
     * @param $data
     *
     * @return null
     */
    public function insert($data)
    {
        $strCols = "";
        $strValues = "";

        foreach ($this->getColumns() as $column) {
            if ($column['name'] != 'id' && isset($data[$column['name']])) {
                $strCols = empty($strCols) ? $strCols : $strCols . ", ";
                $strCols .= $column['name'];
                $strValues = empty($strValues) ? $strValues : $strValues . ", ";
                $value = $this->getValue($data, $column);
                $value = is_array($value) ? json_encode($value) : $value;
                $strValues .= "'" . $this->db->quote($value) . "'";
            }
        }

        $sql_insert = "INSERT INTO " . $this->table .
            " (" . $strCols . ") VALUES (" . $strValues . ")";

        if ($this->db->query($sql_insert)) {
            $insertId = $this->getInsertId($this->table);
            $this->updateOrder($insertId);

            return $insertId;
        }

        return null;
    }

    /**
     * @param $table
     *
     * @return mixed
     */
    public function getInsertId($table)
    {
        return $this->db->getOne("SELECT LAST_INSERT_ID() FROM " . $table);
    }

    /**
     * @param $insertId
     */
    public function updateOrder($insertId)
    {
        $sql_order = "UPDATE " . $this->table . " 
				SET reihenfolge = '" . intval($insertId) . "' 
				WHERE id = '" . intval($insertId) . "';";

        $this->db->query($sql_order);
    }

    /**
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function update($id, $data)
    {
        $this->getById($id);

        $strSet = "";
        foreach ($this->getColumns() as $column) {
            $value = null;

            if ($column['inputType'] == 'checkbox' && !isset($data[$column['name']])) {
                $data[$column['name']] = '0';
            }
            if ($column['inputType'] == 'multiselect' && !isset($data[$column['name']])) {
                $data[$column['name']] = '';
            }

            if (isset($data[$column['name']])) {
                $strSet = empty($strSet) ? $strSet : $strSet . ", ";
                $value = $this->getValue($data, $column);
                $value = is_array($value) ? json_encode($value) : $value;
                $strSet .= $column['name'] . " = '" . $this->db->quote($value) . "'";
            }
        }

        $sql = "UPDATE " . $this->table . " SET " . $strSet;
        $sql .= " WHERE id = '" . intval($id) . "' LIMIT 1;";

        return $this->db->query($sql);
    }

    /**
     * @param       $model
     * @param array $ids
     * @param       $id
     */
    public function attach($model, Array $ids, $id)
    {
        $relatedIds = [];

        foreach ($ids as $relatedId) {
            $sql = "SELECT id FROM " . $this->table . "_has_" . $model->getTable() . " 
				WHERE " . $this->table . "_id = '" . $id . "' AND " . $model->getTable() . "_id = '" . intval($relatedId) . "'";

            $result = $this->db->query($sql);

            if (count($this->fetchAssoc($result)) == 0) {
                $sqlInsert = "INSERT INTO " . $this->table . "_has_" . $model->getTable() . " 
					(" . $this->table . "_id, " . $model->getTable() . "_id) 
					VALUES ('" . $id . "', '" . intval($relatedId) . "')";
                $this->db->query($sqlInsert);
            }
        }
    }

    /**
     * @param       $model
     * @param array $ids
     * @param       $id
     */
    public function detach($model, Array $ids, $id)
    {
        foreach ($ids as $relatedId) {
            $sql = "DELETE FROM " . $this->table . "_has_" . $model->getTable() . "
				WHERE " . $this->table . "_id = '" . $id . "' AND " . $model->getTable() . "_id = '" . intval($relatedId) . "'";
            $this->db->query($sql);
        }
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        $delete = "DELETE FROM " . $this->table . " " .
            "WHERE id = '" . intval($id) . "' LIMIT 1 ;";

        return $this->db->query($delete);
    }

    /**
     * @param $data
     * @param $column
     *
     * @return string
     */
    public function getValue($data, $column)
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

    public function handleFileUpload($data, $column)
    {
        if (!empty($data['name'])) {

            // Delete the old file
            $this->handleFileDeletion($column);

            // Save the new file
            if ($filename = $this->saveFileToStorage($data,
                $column['uploadDir'])
            ) {
                return $filename;
            } else {
                die('Could not handle image upload');
            }
        }

        // Keep as is
        return $column['value'];
    }

    public function handleImageUpload($data, $column)
    {
        if (!empty($data['name'])) {

            // Delete the old file
            $this->handleFileDeletion($column);

            // Save the new file
            if ($filename = $this->saveFileToStorage($data,
                $column['uploadDir'])
            ) {
                return $filename;
            } else {
                die('Could not handle image upload');
            }
        }

        // Keep as is
        return $column['value'];
    }

    public function handleFileDeletion($column)
    {
        if ($this->deleteFileFromStorage($column['value'],
            $column['uploadDir'])
        ) {
            return true;
        }

        return false;
    }

    public function saveFileToStorage($file, $target)
    {
        $filename = substr($file['name'], 0, -4);
        $fileExt = str_replace($filename, '', $file['name']);

        $form = new \Form('basis');
        $filename = time() . '-' . strtolower($form->replace_chars($filename));

        move_uploaded_file($file['tmp_name'], $target . $filename . $fileExt);

        return $filename . $fileExt;
    }

    public function deleteFileFromStorage($file, $target)
    {
        if (!empty($file)) {
            return unlink($target . $file);
        }
    }

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

    public function getInputs()
    {
        $post = $_POST[get_class($this)];
        $files = isset($_FILES[get_class($this)]) ? $this->normalizedFilesArray($_FILES[get_class($this)]) : [];

        return array_merge_recursive($post, $files);
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
    public function multiselect(
        $rows,
        $useKeyAsId,
        $useValueAsName,
        $firstItem = 'Please select'
    ) {
        $array = [];
        if (count($rows) > 0) {
            foreach ($rows as $item) {
                $array[$item[$useKeyAsId]] = $item[$useValueAsName];
            }

            if ($firstItem) {
                $array = ['0' => __('Please select')] + $array;
            }
        }

        return $array;
    }

    /**
     * @param $value
     * @param $column
     *
     * @return string
     */
    public function getSelectBoxValue($value, $column)
    {
        if (!empty($value)) {
            $inputOptions = $column['inputOptions']();

            return isset($inputOptions[$value]) ? $inputOptions[$value] : '-';
        }

        return $this->getEmptyColumnPlaceholder();
    }

    /**
     * @param $value
     * @param $column
     *
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
     *
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

}