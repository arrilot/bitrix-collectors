<?php

namespace Arrilot\BitrixTankers;

use Bitrix\Iblock\SectionTable;

class SectionTanker extends OrmTableTanker
{
    protected function entityClassName()
    {
        return SectionTable::class;
    }
}
