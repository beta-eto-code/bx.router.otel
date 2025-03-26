<?php

namespace Bx\Router\Otel;

use Otel\Base\OTelFactory;
use Otel\Base\OTelSpanManager;

class OTelManager
{
    private static ?OTelSpanManager $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): OTelSpanManager
    {
        if (is_null(self::$instance)) {
            $factory = new OTelFactory();
            $otelSpanManager = $factory->createDefault();
            self::$instance = $otelSpanManager;
        }
        return self::$instance;
    }

}
