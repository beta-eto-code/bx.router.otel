<?php

namespace Bx\Router\Otel;

class OtelEvent
{
    private $spanName;
    private $name;
    private $attributes;

    /**
     * @param $name
     * @param $attributes
     */
    public function __construct($name, $attributes, $spanName = 'root')
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->spanName = $spanName;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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
