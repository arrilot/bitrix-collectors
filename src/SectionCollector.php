<?php

namespace Arrilot\BitrixCollectors;

use Bitrix\Iblock\SectionTable;

class SectionCollector extends OrmTableCollector
{
    protected function entityClassName()
    {
        return SectionTable::class;
    }
}
