<?php

namespace Bx\Router\Otel;

use Bitrix\Main\Event;

class BxOTelEventListener
{

    const EVENT_FIELD_NAME = 'otel_event';
    const EVENT_NAME = 'onOTelEvent';

    public static function onOTelEvent(Event $event): void
    {
        /** @var OtelEvent $otelEvent */
        $otelEvent = $event->getParameter(self::EVENT_FIELD_NAME);

        if ($otelEvent instanceof OtelEvent) {
            $otelSpanManager = OTelManager::getInstance();
            $otelSpanManager->addSpanEvent(
                $otelEvent->getSpanName(),
                $otelEvent->getEventName(),
                $otelEvent->getAttributes(),
            );
        }
    }
}
