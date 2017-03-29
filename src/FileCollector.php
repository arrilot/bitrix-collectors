<?php

namespace Arrilot\BitrixCollectors;

use Bitrix\Main\FileTable;

class FileCollector extends OrmTableCollector
{
    protected function entityClassName()
    {
        return FileTable::class;
    }
    
    protected function transformItems(array $items)
    {
        foreach ($items as $id => $item) {
             $items[$id]['PATH'] = "/upload/{$item['SUBDIR']}/{$item['FILE_NAME']}";
        }
        
        return $items;
    }
}
