<?php

namespace Arrilot\BitrixTankers;


use CIBlockElement;

class ElementTanker extends BitrixTanker
{
    /**
     * Fetch data for given ids.
     *
     * @param array $ids
     * @return array
     */
    protected function fetch(array $ids)
    {
        $items = [];
        $res = CIBlockElement::GetList(["ID" => "ASC"], $this->buildFilter($ids), false, false, $this->select);
        while ($el = $res->Fetch()) {
            $items[$el['ID']] = $el;
        }

        return $items;
    }
}
