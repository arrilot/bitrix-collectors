<?php

namespace Arrilot\BitrixTankers;

use Bitrix\Main\FileTable;

class FileTanker extends OrmTableTanker
{
    protected function entityClassName()
    {
        return FileTable::class;
    }
}
