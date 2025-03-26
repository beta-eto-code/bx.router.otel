<?php

use Bitrix\Main\EventManager;
use Bx\Router\Otel\BxOTelEventListener;


EventManager::getInstance()
    ->addEventHandler('bx.router.otel', BxOTelEventListener::EVENT_NAME, [
        Bx\Router\Otel\BxOTelEventListener::class,
        BxOTelEventListener::EVENT_NAME
    ]);
