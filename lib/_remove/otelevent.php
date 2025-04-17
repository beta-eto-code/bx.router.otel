<?php

namespace Bx\Router\Otel;

class OtelEvent
{
    private $spanName;
    private $eventName;
    private $attributes;

    /**
     * @param $eventName
     * @param $attributes
     */
    public function __construct($eventName, $attributes, $spanName = 'root')
    {
        $this->eventName = $eventName;
        $this->attributes = $attributes;
        $this->spanName = $spanName;
    }


    /**
     * @return mixed
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getSpanName()
    {
        return $this->spanName;
    }
}
