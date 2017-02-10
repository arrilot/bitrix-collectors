<?php

namespace Arrilot\BitrixTankers;

use Arrilot\Tankers\Tanker;

abstract class BitrixTanker extends Tanker
{
    protected $suffix = '_DATA';

    /**
     * Prepare select.
     */
    protected function prepareSelect()
    {
        if (is_null($this->config['select'])) {
            return ['*'];
        }
        
        $select = $this->config['select'];
        if (!in_array('ID', $select)) {
            array_unshift($select, 'ID');
        }
        
        return $select;
    }
}
