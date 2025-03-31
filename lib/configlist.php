<?php

namespace Bx\Router\Otel;

class ConfigList
{
    const MODULE_NAME = 'bx_router_otel';
    const USE_OTEL = 'USE_OTEL';
    const OTEL_URLS = 'OTEL_URLS';
    const OTEL_HOST = 'OTEL_HOST';
    const OTEL_LOGIN = 'OTEL_LOGIN';
    const OTEL_PASSWORD = 'OTEL_PASSWORD';

    public static function getOptionsTab(): array
    {
        return [
            [
                'tab' => "Телеметрия",
                'options' => [
                    ConfigList::USE_OTEL => [
                        'label' => 'Включить профилирование запросов',
                        'name' => ConfigList::USE_OTEL,
                        'type' => 'checkbox',
                        'multiple' => false
                    ],
                    ConfigList::OTEL_HOST => [
                        'label' => 'Адрес OTEL сервера',
                        'name' => ConfigList::OTEL_HOST,
                        'type' => 'string',
                        'multiple' => false
                    ],
                    ConfigList::OTEL_LOGIN => [
                        'label' => 'Логин OTEL сервера',
                        'name' => ConfigList::OTEL_LOGIN,
                        'type' => 'string',
                        'multiple' => false
                    ],

                    ConfigList::OTEL_PASSWORD => [
                        'label' => 'Пароль OTEL сервера',
                        'name' => ConfigList::OTEL_PASSWORD,
                        'type' => 'string',
                        'multiple' => false
                    ],
                    ConfigList::OTEL_URLS => [
                        'label' => 'Список URL разрешенных для отправки в OTEL (по-умолчанию все разрешены)',
                        'name' => ConfigList::OTEL_URLS,
                        'type' => 'string',
                        'multiple' => true
                    ],
                ],
            ],
        ];
    }
}
