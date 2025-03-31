<?php

namespace Bx\Router\Otel;

use Otel\Base\OTelFactory;
use Otel\Base\OTelRegistry;
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
            if (!OTelRegistry::has('default')) {
                self::$instance = OTelRegistry::get('default');
            } else {
                $factory = new OTelFactory();
                $otelSpanManager = $factory->createDefault();
                $otelSpanManager->startRootSpan();

                self::$instance = $otelSpanManager;
            }

        }

        return self::$instance;
    }

}
