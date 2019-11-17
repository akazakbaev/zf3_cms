<?php
/**
 * Available languages
 *
 * @var key     Language shortName
 * @var name Display Name
 * @var locale Language File Name
 * 
 * @NOTE First language is default
 * 
 * @author Berdimurat Masaliev <muratmbt@gmail.com>
 */

use Zend\Cache\Storage\Adapter\Filesystem;

return [
    'translator' => [
        'locale' => 'en_EN',
//        'remote_translation' => [
//            [
//                'type' => \Application\Service\DatabaseTranslationLoader::class,
//            ]
//        ]

    ],
    'languages' => [
        'defaultLocale' => 'en_EN',
        'languages' => ['ru' => 'ru_RU', 'en' => 'en_EN'],
    ]
];
