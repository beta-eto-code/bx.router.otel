<?php

namespace Bx\Router\Otel;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Event;

class BxOTelEventListener
{

    const EVENT_FIELD_NAME = 'otel_event';
    const EVENT_NAME = 'onOTelEvent';

    public static function onOTelEvent(Event $event): void
    {
        $isEnabled = Option::get('bx.router.otel', ConfigList::USE_OTEL, 'Y') == 'Y';

        if (!$isEnabled) {
            return;
        }

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
