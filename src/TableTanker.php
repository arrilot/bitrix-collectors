<?php

namespace Arrilot\BitrixTankers;

use Bitrix\Main\Application;
use Bitrix\Main\DB\Connection;
use LogicException;

abstract class TableTanker extends BitrixTanker
{
    /**
     * Fields that should be selected.
     *
     * @var mixed
     */
    protected $select = ['*'];
    
    /**
     * Table name.
     *
     * @return string
     */
    abstract protected function getTableName();

    /**
     * Fetch data for given ids.
     *
     * @param array $ids
     * @return array
     */
    protected function fetch(array $ids)
    {
        $items = [];
        $connection = Application::getConnection();
        $query = $this->buildSqlQuery($ids, $connection);
        
        $recordset = $connection->query($query);
        while ($el = $recordset->fetchRaw()) {
            $items[$el['ID']] = $el;
        }

        return $items;
    }
    
    /**
     * Construct sql query to fetch data.
     *
     * @param array $ids
     * @param Connection $connection
     * @return string
     */
    protected function buildSqlQuery(array $ids, Connection $connection)
    {
        $idsString = implode(',', $ids);
        $where = count($ids) > 1 ? "ID IN ({$idsString})" : "ID={$ids[0]}";
        
        if ($this->where) {
            $where .= " AND {$this->where}";
        }
        
        $select = implode(',', $this->select);
        $table = $connection->getSqlHelper()->quote($this->getTableName());
        
        return "SELECT {$select} FROM {$table} WHERE {$where}";
    }

    /**
     * Setter for where.
     *
     * @param mixed $where
     * @return $this
     */
    public function where($where)
    {
        if (!is_string($where)) {
            throw new LogicException('A string should be passed to `where()` in TableTanker');
        }

        $this->where = $where;

        return $this;
    }
    
    /**
     * Setter for select.
     *
     * @param array $select
     * @return $this
     */
    public function select(array $select)
    {
        if (!in_array('ID', $select)) {
            array_unshift($select, 'ID');
        }

        $helper = Application::getConnection()->getSqlHelper();
        foreach ($select as $i => $field) {
            $select[$i] = $helper->quote($field);
        }

        $this->select = $select;

        return $this;
    }
}
