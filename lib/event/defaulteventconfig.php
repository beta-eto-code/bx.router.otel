<?php

namespace Bx\Router\Otel\Event;

use Bx\Otel\Event\BaseEventConfig;

class DefaultEventConfig extends BaseEventConfig
{
    public function getModuleId(): string
    {
        return 'bx.router.otel';
    }

    public function getNewSpanEventName(): string
    {
        return 'bx.router.otel.new_span_event';
    }

    public function getNewSpanName(): string
    {
        return 'bx.router.otel.new_span';
    }
}
