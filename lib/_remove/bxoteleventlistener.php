<?php

namespace Bx\Router\Otel;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Event;
use Exception;

class BxOTelEventListener
{

    const EVENT_FIELD_NAME = 'otel_event';
    const EVENT_NAME = 'onOTelEvent';

    /**
     * @throws Exception
     */
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
