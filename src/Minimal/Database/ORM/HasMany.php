<?php

namespace Maduser\Minimal\Database\ORM;

class HasMany extends AbstractRelation
{
    protected $pivotTable;
    protected $foreignPivotKey;
    protected $localPivotKey;

     /**
     * @return mixed
     */
    public function getPivotTable()
    {
        return $this->pivotTable;
    }

    /**
     * @param mixed $pivotTable
     *
     * @return HasMany
     */
    public function setPivotTable($pivotTable)
    {
        $this->pivotTable = $pivotTable;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getForeignPivotKey()
    {
        return $this->foreignPivotKey;
    }

    /**
     * @param mixed $foreignPivotKey
     *
     * @return HasMany
     */
    public function setForeignPivotKey($foreignPivotKey)
    {
        $this->foreignPivotKey = $foreignPivotKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocalPivotKey()
    {
        return $this->localPivotKey;
    }

    /**
     * @param mixed $localPivotKey
     *
     * @return HasMany
     */
    public function setLocalPivotKey($localPivotKey)
    {
        $this->localPivotKey = $localPivotKey;

        return $this;
    }



    public function __construct(
        ORM $class, $pivotTable, $foreignPivotKey, $localPivotKey
    ) {
        $this->setClass($class);
        $this->setPivotTable($pivotTable);
        $this->setForeignPivotKey($foreignPivotKey);
        $this->setLocalPivotKey($localPivotKey);
    }


}