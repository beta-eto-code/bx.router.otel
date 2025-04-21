<?php

namespace Bx\Router\Otel\Event;

class DefaultEventConfig extends \Bx\Otel\Event\DefaultEventConfig
{
    public function getModuleId(): string
    {
        return 'bx.router.otel';
    }

}
