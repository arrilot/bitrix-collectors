<?php

namespace Arrilot\BitrixCollectors;

use Bitrix\Main\FileTable;

class FileCollector extends OrmTableCollector
{
    protected function entityClassName()
    {
        return FileTable::class;
    }
}
