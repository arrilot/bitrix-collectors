<?php

namespace Arrilot\BitrixCollectors;

use Bitrix\Main\UserTable;

class UserCollector extends OrmTableCollector
{
    protected function entityClassName()
    {
        return UserTable::class;
    }
}
