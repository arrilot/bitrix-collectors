[![Latest Stable Version](https://poser.pugx.org/arrilot/bitrix-collectors/v/stable.svg)](https://packagist.org/packages/arrilot/bitrix-collectors/)

# Мост для интеграции `arrilot/collectors` с Битриксом (В разработке)

## Установка

```composer require arrilot/bitrix-collectors```

## Использование

Основа - [https://www.github.com/arrilot/collectors](https://www.github.com/arrilot/collectors)
Пакет позволяет собрать из различных коллекций и элементов (обычно полученных через какой-нибудь `CIblockElement::GetList()`) идентификаторы и удобным образом дополучить по ним дополнительные данные *одним запросом*, а не в цикле как это обычно заканчивается

Данный мост реализует несколько наиболее востребованных в Битриксе коллекторов (collectors)

Готовые коллекторы:
 1. `Arrilot\BitrixCollectors\FileCollector` - импользует внутри себя FileTable::getList из d7
 2. `Arrilot\BitrixCollectors\SectionCollector` - SectionTable::getList
 3. `Arrilot\BitrixCollectors\ElementCollector` - CIBlockElement::GetList + Fetch. Рекомендуется использовать инфоблоки 2.0, чтобы не было проблем с множественными свойствами.
 4. `Arrilot\BitrixCollectors\UserCollector` - UserTable::getList

Абстрактные классы-коллекторы. От них можно наследоваться при разработке дополнительных танкеров.
 1. `Arrilot\BitrixCollectors\TableCollector` - для случая когда данные хранятся в отдельной таблице и для неё НЕТ d7 orm класса. 
 2. `Arrilot\BitrixCollectors\OrmTableCollector` - для случая когда данные хранятся в отдельной таблице и ЕСТЬ d7 orm класс. 

Также как и с оригинальным пакетом цепочка методов должна заканчиваться методом `performQuery()` который выполняем getList запрос в БД и возвращает результат. Можно одновременно собирать идентификаторы по нескольким коллекциям/элементам и т д.

Пример:
```php
    use Arrilot\BitrixCollectors\FileCollector;

    $items = [
        ['ID' => 1, 'PROPERTY_FILES1_VALUE' => 1],
        ['ID' => 2, 'PROPERTY_FILES2_VALUE' => [2, 1]],
    ];
    
    $item = ['ID' => 3, 'PROPERTY_OTHER_FILES_VALUE' => 4];
    
    $collector = new FileCollector();
    $files = $collector->scanCollection($items, ['PROPERTY_FILES1_VALUE', 'PROPERTY_FILES2_VALUE'])
                       ->scanItem($item, 'PROPERTY_OTHER_FILES_VALUE')
                       ->performQuery();
    var_dump($files);

    // результат
    /*
        array:3 [▼
            1 => array:13 [▼
              "ID" => "1"
              "TIMESTAMP_X" => "2017-02-10 17:25:17"
              "MODULE_ID" => "iblock"
              "HEIGHT" => "150"
              "WIDTH" => "140"
              "FILE_SIZE" => "15003"
              "CONTENT_TYPE" => "image/png"
              "SUBDIR" => "iblock/b03"
              "FILE_NAME" => "avatar.png"
              "ORIGINAL_NAME" => "avatar-gs.png"
              "DESCRIPTION" => ""
              "HANDLER_ID" => null
              "EXTERNAL_ID" => "125dc3213f7ecde31124f3ebca7322b5"
           ],
           2 => array:13 [▼
              "ID" => "2"
              "TIMESTAMP_X" => "2017-02-10 17:31:30"
              "MODULE_ID" => "iblock"
              "HEIGHT" => "84"
              "WIDTH" => "460"
              "FILE_SIZE" => "4564"
              "CONTENT_TYPE" => "image/png"
              "SUBDIR" => "iblock/fcf"
              "FILE_NAME" => "4881-03.png"
              "ORIGINAL_NAME" => "4881-03.png"
              "DESCRIPTION" => ""
              "HANDLER_ID" => null
              "EXTERNAL_ID" => "35906df62694b4ed5f150c468a1f5d72"
           ]
           4 => array:13 [▼
              "ID" => "4"
              "TIMESTAMP_X" => "2017-02-10 17:33:30"
              "MODULE_ID" => "iblock"
              "HEIGHT" => "84"
              "WIDTH" => "460"
              "FILE_SIZE" => "4564"
              "CONTENT_TYPE" => "image/png"
              "SUBDIR" => "iblock/fc2"
              "FILE_NAME" => "test.png"
              "ORIGINAL_NAME" => "4881-03.png"
              "DESCRIPTION" => ""
              "HANDLER_ID" => null
              "EXTERNAL_ID" => "35906df62694b4ed5f150c468a1f5d53"
           ]
        ]
    */
```

Все коллекторы поддерживают `->select([...])`, в котором можно указать массив `$select`, который передается в API битрикса.
Аналогично в `->where(['...'])` можно указать `$filter`
Исключение - `TableCollector`. Там в `->where()` нужно передавать строку, а не массив-фильтр.
Она будет подставлена в sql запрос без дополнительный обработки.
