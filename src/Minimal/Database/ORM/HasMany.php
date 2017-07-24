<?php

namespace Maduser\Minimal\Database\ORM;

use Maduser\Minimal\Collections\Collection;
use Maduser\Minimal\Collections\CollectionInterface;

class HasMany extends AbstractRelation
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

        foreach ($collection->getArray() as &$item) {
            $newCollection = new Collection();
            foreach ($relatedCollection as $related) {
                if ($item->{$this->getLocalKey()} ==
                    $related->{$this->getForeignKey()}) {
                    $newCollection->add($related);
                }
            }
            $item->addRelated($with, $newCollection);
        }

    }

    public function resolveInline(ORM $queryingClass)
    {
        $class = $this->getClass();
        return $class::create()->where([
                $this->getForeignKey(),
                $queryingClass->{$this->getLocalKey()}
            ]
        )->getAll();
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

        return $class::create()->where([
            $this->foreignKey,
            'IN',
            implode(',', $array)
        ])->getAll();
    }
}