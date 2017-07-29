<?php

namespace Maduser\Minimal\Database\ORM;

use Maduser\Minimal\Collections\CollectionInterface;

class HasOne extends AbstractRelation
{
    public function __construct($class, $foreignKey, $localKey)
    {
        $this->setClass($class);
        $this->setForeignKey($foreignKey);
        $this->setLocalKey($localKey);
    }

    public function resolve(
        CollectionInterface $collection,
        string $with,
        ORM $queryingClass = null
    ) {
        $localKeys = $collection->extract($this->getLocalKey());
        $relatedCollection = $this->getWhereIn($localKeys);

        if ($relatedCollection) {
            /** @var ORM $item */
            foreach ($collection->getArray() as &$item) {
                foreach ($relatedCollection as $related) {
                    if ($item->{$this->getLocalKey()} ==
                        $related->{$this->getForeignKey()}
                    ) {
                        $item->addRelated($with, $related);
                    }
                }
            }
        }

    }

    public function resolveInline(ORM $queryingClass)
    {
        $class = $this->getClass();
        return $class::instance()->where([
            $this->getForeignKey(), $queryingClass->{$this->getLocalKey()}]
        )->getFirst();
    }

    /**
     * @param      $array
     * @param null $relation
     *
     * @return mixed
     */
    public function getWhereIn($array, $relation = null)
    {
        $class = $this->getClass();

        return $class::instance()->where([
            $this->foreignKey,
            'IN',
            implode(',', $array)
        ])->getAll();
    }

}