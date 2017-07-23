<?php

namespace Maduser\Minimal\Database\ORM;

class BelongsTo extends AbstractRelation
{
    public function __construct($class, $foreignKey, $localKey)
    {
        $this->setClass($class);
        $this->setLocalKey($localKey);
        $this->setForeignKey($foreignKey);
    }

    public function resolve($collection, $with, $queryingClass = null)
    {
        $foreignKeys = $collection->extract($this->getForeignKey());
        $relatedCollection = $this->getWhereIn($foreignKeys);

        foreach ($collection->getArray() as &$item) {
            foreach ($relatedCollection as $related) {
                if ($item->{$this->getForeignKey()} ==
                    $related->{$this->getLocalKey()}) {
                    $item->addRelated($with, $related);
                }
            }
        }
    }

    public function resolveInline($queryingClass)
    {
        $class = $this->getClass();
        return $class::create()->where([
                $this->getLocalKey(),
                $queryingClass->{$this->getForeignKey()}
        ])->getFirst();
    }

    public function getWhereIn($array, $relation = null)
    {
        $class = $this->getClass();

        return $class::create()->where([
            $this->localKey,
            'IN',
            implode(',', $array)
        ])->getAll();
    }
}