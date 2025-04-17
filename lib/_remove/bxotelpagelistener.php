<?php

namespace Bx\Router\Otel;

use Bitrix\Main\Application;
use Bitrix\Main\Event;

class BxOTelPageListener
{
    public static function onStart()
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $event = new Event("bx.router.otel", BxOTelEventListener::EVENT_NAME, [
            BxOTelEventListener::EVENT_FIELD_NAME => new OtelEvent(
                'onStart',
                [
                    'url' => $request->getRequestUri(),
                    'method' => $request->getRequestMethod(),
                    'session' => session_id()
                ],
                'root'
            )
        ]);
        $event->send();
    }

    public static function onEnd()
    {
        $event = new Event("bx.router.otel", BxOTelEventListener::EVENT_NAME, [
            BxOTelEventListener::EVENT_FIELD_NAME => new OtelEvent(
                'onPageEnd',
                [],
                'root'
            )
        ]);
        $event->send();
    }
}
