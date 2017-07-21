<?php

namespace Maduser\Minimal\Database;

use Maduser\Minimal\Collections\Collection;
use Maduser\Minimal\Database\Exceptions\DatabaseException;
use Maduser\Minimal\Loaders\IOC;

class ORM
{
    protected $builder;

    /**
     * Database table to use
     *
     * @var
     */
    //protected $table;

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
    protected $orderBy = '';

    /**
     * Default ID column
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
     * Represents the row
     *
     * @var array
     */
    protected $state = [];

    protected $with;

    /**
     * @return QueryBuilder
     */
    public function getBuilder(): QueryBuilder
    {
        return $this->builder;
    }

    /**
     * @param QueryBuilder $builder
     *
     * @return ORM
     */
    public function setBuilder(QueryBuilder $builder): ORM
    {
        $this->builder = $builder;

        return $this;
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
     *
     * @return ORM
     */
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
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
     *
     * @return ORM
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     *
     * @return ORM
     */
    public function setOrderBy(string $orderBy): ORM
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * @param string $primaryKey
     *
     * @return ORM
     */
    public function setPrimaryKey(string $primaryKey): ORM
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    /**
     * @return bool
     */
    public function useTimestamps(): bool
    {
        return $this->timestamps;
    }

    /**
     * @param bool $timestamps
     *
     * @return ORM
     */
    public function setTimestamps(bool $timestamps): ORM
    {
        $this->timestamps = $timestamps;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimestampCreatedAt(): string
    {
        return $this->timestampCreatedAt;
    }

    /**
     * @param string $timestampCreatedAt
     *
     * @return ORM
     */
    public function setTimestampCreatedAt(string $timestampCreatedAt): ORM
    {
        $this->timestampCreatedAt = $timestampCreatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimestampUpdatedAt(): string
    {
        return $this->timestampUpdatedAt;
    }

    /**
     * @param string $timestampUpdatedAt
     *
     * @return ORM
     */
    public function setTimestampUpdatedAt(string $timestampUpdatedAt): ORM
    {
        $this->timestampUpdatedAt = $timestampUpdatedAt;

        return $this;
    }

    /**
     * @return array
     */
    public function getState(): array
    {
        return $this->state;
    }

    /**
     * @param array $state
     *
     * @return ORM
     */
    public function setState(array $state): ORM
    {
        $this->state = $state;

        return $this;
    }

    public function __construct($connection = null)
    {
        ! is_null($connection) || $connection = PDO::connection();

        $builder = $this->newQueryBuilder();
        $builder->setDb($connection);

        $builder->setPrimaryKey($this->getPrimaryKey());
        $builder->setPrefix($this->getPrefix());
        $builder->setTable($this->getTable());
        $builder->setOrderBy($this->getOrderBy());

        $builder->setTimestamps($this->useTimestamps());
        $builder->setTimestampCreatedAt($this->getTimestampCreatedAt());
        $builder->setTimestampUpdatedAt($this->getTimestampUpdatedAt());

        $this->builder = $builder;
    }

    public static function create(array $data = [])
    {
        /** @var ORM $obj */
        $class = get_called_class();
        $obj = new $class();
        $obj->setState($data);

        return $obj;
    }

    public static function find($id)
    {
        $newInstance = self::create();
        return $newInstance->getById($id);
    }

    public function newQueryBuilder()
    {
        return new QueryBuilder();
    }

    public function getById($id)
    {
        $result = $this->builder->getById($id);

        if (isset($result[0])) {
            return self::create($result[0]);
        }

        return null;
    }

    public function getFirst($sql = null)
    {
        $result = $this->builder->getFirst($sql);

        if (isset($result[0])) {
            return self::create($result[0]);
        }

        return null;
    }

    /**
     * Return all the rows of this table
     *
     * @param null $sql Optional query string
     *
     * @return Collection|null
     * @throws DatabaseException
     */
    public function getAll($sql = null)
    {
        $results = $this->builder->getAll($sql);

        if (count($results) > 0) {
            $collection = new Collection();
            foreach ($results as $value) {
                $obj = self::create($value);
                $collection->add($obj);
            }

            if (!is_null($this->with)) {
                if (is_string($this->with)) {
                    $this->with = [$this->with];
                }

                foreach ($this->with as $with) {

                    $relation = $this->{$with}();
                    $array = $collection->extract($relation->getLocalKey());


                    if ($relation instanceof HasOne) {

                        $relatedCollection = $relation->getWhereIn($array);

                        foreach ($collection->getArray() as &$item) {
                            foreach ($relatedCollection->getArray() as $related) {
                                if ($item->{$relation->getLocalKey()} ==
                                    $related->{$relation->getForeignKey()}) {
                                    $item->{$with} = $related;
                                }
                            }

                        }
                    }

                    if ($relation instanceof BelongsToMany) {

                        $relatedCollection = $relation->getWhereIn($array);

                        foreach ($collection->getArray() as &$item) {
                            $newCollection = new Collection();
                            foreach ($relatedCollection->getArray() as $related) {
                                if ($item->{$relation->getLocalKey()} ==
                                    $related->{$relation->getForeignKey()}) {
                                    $newCollection->add($related);
                                }
                            }
                            $item->{$with} = $newCollection;

                        }
                    }

                }
            }

            return $collection;
        }

        return null;
    }

    public function with($string)
    {
        $this->with = $string;

        return $this;
    }

    public function hasOne($class, $foreignKey, $localKey)
    {
        return new HasOne($class, $foreignKey, $localKey, $this);
    }


    public function belongsToMany($class, $foreignKey, $localKey)
    {
        return new BelongsToMany($class, $foreignKey, $localKey, $this);
    }


    public function toArray()
    {
        return $this->state;
    }

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->{$name}();
        }

        return $this->{'get' . ucfirst($name)}();
    }

    public function __call($name, $arguments)
    {
        $prefix = 'get';

        if (substr($name, 0, strlen($prefix)) == $prefix) {

            $name = lcfirst(substr($name, strlen($prefix)));
            if (array_key_exists($name, $this->state)) {
                return $this->state[$name];
            } else {
                throw new DatabaseException('Key ' . $name . ' does not exist.');
            }
        } else {
            $result = call_user_func_array([$this->builder, $name], $arguments);

            if (in_array($name, ['lastQuery'])) {
                return $result;
            }
            return $this;
        }

    }


}