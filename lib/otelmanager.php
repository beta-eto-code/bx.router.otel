<?php

namespace Bx\Router\Otel;

use Exception;
use Otel\Base\OTelFactory;
use Otel\Base\OTelRegistry;
use Otel\Base\OTelSpanManager;

class OTelManager
{
    private static ?OTelSpanManager $instance = null;

    private function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public static function getInstance(): OTelSpanManager
    {

        if (is_null(self::$instance)) {
            if (!OTelRegistry::has('default')) {
                $factory = new OTelFactory();
                $otelSpanManager = $factory->createDefault();
                $otelSpanManager->startRootSpan();

                OTelRegistry::register('default', $otelSpanManager);
                self::$instance = $otelSpanManager;

            } else {
                self::$instance = OTelRegistry::get('default');
            }

        }

        return self::$instance;
    }

}
