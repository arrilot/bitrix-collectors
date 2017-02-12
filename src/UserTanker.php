<?php

namespace Arrilot\BitrixTankers;

use Bitrix\Main\UserTable;

class UserTanker extends OrmTableTanker
{
    protected function entityClassName()
    {
        return UserTable::class;
    }
}
