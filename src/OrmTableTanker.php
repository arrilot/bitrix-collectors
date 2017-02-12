<?php

namespace Arrilot\BitrixTankers;

abstract class OrmTableTanker extends BitrixTanker
{
    /**
     * Fields that should be selected.
     *
     * @var mixed
     */
    protected $select = ['*'];
    
    /**
     * Class name of the entity.
     *
     * @return string
     */
    abstract protected function entityClassName();

    /**
     * Fetch data for given ids.
     *
     * @param array $ids
     * @return array
     */
    protected function fetch(array $ids)
    {
        $items = [];
        $entity = $this->entityClassName();
        $result = $entity::getList([
            'filter' => $this->buildFilter($ids),
            'select' => $this->select,
        ]);
        while ($row = $result->fetch()) {
            $items[$row['ID']] = $row;
        }

        return $items;
    }
}