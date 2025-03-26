<?php

namespace Bx\Otel\Router;

use Bitrix\Main\Application;
use Otel\Base\Tests\Stubs\OTelFactoryStub;

class BxOTelListener
{
    private static $otelManager;

    public static function onStart()
    {
        $request = Application::getInstance()->getContext()->getRequest();
        self::$otelManager = (new OTelFactoryStub())->createDefault();

        self::$otelManager->startRootSpan([
            'http.method' => $request->getRequestMethod(),
            'http.url' => $request->getRequestUri()
        ]);

        self::$otelManager->getSpan()->addEvent('onStart', []);
    }

    public static function onEnd()
    {
        self::$otelManager->getSpan()->addEvent('onEnd', []);
    }
}
