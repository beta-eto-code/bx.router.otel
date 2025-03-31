<?php

namespace Bx\Router\Otel;

use Exception;
use Otel\Base\Interfaces\OTelSpanManagerInterface;
use Otel\Base\OTelRegistry;

class OTelManager
{
    private static ?OTelSpanManagerInterface $instance = null;

    private function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public static function getInstance(): OTelSpanManagerInterface
    {

        if (is_null(self::$instance)) {
            if (!OTelRegistry::has('default')) {

                $otelSpanManager = BxRouterOTelSpanManager::factory();
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
