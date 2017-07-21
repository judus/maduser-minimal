<?php

namespace Maduser\Minimal\Database\ORM;

class AbstractRelation
{
    protected $class;

    protected $foreignKey;

    protected $localKey;

    protected $parent;

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     *
     * @return HasOne
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * @param mixed $foreignKey
     *
     * @return HasOne
     */
    public function setForeignKey($foreignKey)
    {
        $this->foreignKey = $foreignKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocalKey()
    {
        return $this->localKey;
    }

    /**
     * @param mixed $localKey
     *
     * @return HasOne
     */
    public function setLocalKey($localKey)
    {
        $this->localKey = $localKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     *
     * @return HasOne
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    public function __construct($class, $foreignKey, $localKey, $parent)
    {
        $this->setClass($class);
        $this->setForeignKey($foreignKey);
        $this->setLocalKey($localKey);
        $this->setParent($parent);
    }

    public function getWhereIn($array)
    {
        $class = $this->getClass();

        return $class::create()->where([
            $this->foreignKey,
            'IN',
            implode(',', $array)
        ])->getAll();
    }
}