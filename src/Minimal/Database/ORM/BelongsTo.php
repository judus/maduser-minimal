<?php

namespace Maduser\Minimal\Database\ORM;

use Maduser\Minimal\Collections\CollectionInterface;
use Maduser\Minimal\Database\Exceptions\DatabaseException;

class BelongsTo extends AbstractRelation
{
    public function __construct($class, $foreignKey, $localKey)
    {
        $this->setClass($class);
        $this->setLocalKey($localKey);
        $this->setForeignKey($foreignKey);
        $this->setCaller(debug_backtrace()[1]['object']);
    }

    public function resolve(
        CollectionInterface $collection,
        string $with,
        ORM $queryingClass = null
    ) {
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

    public function resolveInline(ORM $queryingClass)
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

    public function __call($name, $args)
    {
        array_unshift($args, $this);

        if (!in_array($name, ['associate', 'dissociate'])) {
            throw new DatabaseException('Call to undefined method ' . __CLASS__ . '::' . $name . '()');
        }

        return call_user_func_array([$this->getCaller(), $name], $args);
    }

}