<?php

namespace Arrilot\BitrixCollectors;


use CIBlockElement;

class ElementCollector extends BitrixCollector
{
    /**
     * Fetch data for given ids.
     *
     * @param array $ids
     * @return array
     */
    protected function getByIds(array $ids)
    {
        $items = [];
        $res = CIBlockElement::GetList(["ID" => "ASC"], $this->buildFilter($ids), false, false, $this->select);
        while ($el = $res->Fetch()) {
            $items[$el['ID']] = $el;
        }

        return $items;
    }
}
