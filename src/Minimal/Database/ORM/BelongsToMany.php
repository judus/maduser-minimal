<?php

namespace Maduser\Minimal\Database\ORM;

use Maduser\Minimal\Collections\Collection;
use Maduser\Minimal\Database\QueryBuilder;

class BelongsToMany extends AbstractRelation
{
    public function __construct(
        $class,
        $pivotTable,
        $foreignKey,
        $localKey
    ) {
        $this->setClass($class);
        $this->setPivotTable($pivotTable);
        $this->setForeignKey($foreignKey);
        $this->setLocalKey($localKey);
    }

    public function resolve($collection, $with, $queryingClass = null)
    {
        $localKeys = $collection->extract($queryingClass->getPrimaryKey());
        $relatedCollection = $this->getWhereIn($localKeys);

        foreach ($collection->getArray() as &$item) {
            $newCollection = new Collection();
            foreach ($relatedCollection as $related) {

                if (isset($related->attributes['pivot_' . $this->getLocalKey()]) &&
                    $item->{$queryingClass->getPrimaryKey()} ==
                    $related->attributes['pivot_' . $this->getLocalKey()]) {
                    $related->drop('pivot_' . $this->getLocalKey());
                    $related->drop('pivot_' . $this->getForeignKey());
                    $newCollection->add($related);
                }
            }
            $item->addRelated($with, $newCollection);
        }
    }

    public function resolveInline($queryingClass)
    {
        $localKey = $queryingClass->{$queryingClass->getPrimaryKey()};

        return $this->getWhereIn([$localKey]);
    }

    public function getWhereIn($localKeys)
    {
        $builder = new QueryBuilder();

        $class = $this->getClass();
        /** @var ORM $obj */
        $obj = $class::create();

        $table = $obj->getTable();
        $pivot = $this->getPivotTable();
        $primary = $obj->getPrimaryKey();
        $localKey = $this->getLocalKey();
        $foreignKey = $this->getForeignKey();

        $sql = "SELECT `" . $table . "`.*, " .
            "`" . $pivot . "`.`" . $localKey . "` AS `pivot_" . $localKey . "`, " .
            "`" . $pivot . "`.`" . $foreignKey . "` AS `pivot_" . $foreignKey . "` " .
            "FROM `" . $table . "` " .
            "INNER JOIN `" . $pivot . "` " .
            "ON `" . $table . "`.`" . $primary . "` = `" . $pivot . "`.`" . $foreignKey . "` " .
            "WHERE `" . $pivot . "`.`" . $localKey . "` IN (" . implode(', ',
                $localKeys) . ")";

        return $obj->getAll($sql);
    }
}