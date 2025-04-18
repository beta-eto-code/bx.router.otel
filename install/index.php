<?php

IncludeModuleLangFile(__FILE__);

use Bitrix\Main\EventManager;
use Bitrix\Main\ModuleManager;
use Bx\Router\Otel\Event\EventHandler;


class bx_router_otel extends CModule
{
    public $MODULE_ID = "bx.router.otel";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $errors;

    public function __construct()
    {
        $this->MODULE_VERSION = "1.0.0";
        $this->MODULE_VERSION_DATE = "2025-03-25 00:00:00";
        $this->MODULE_NAME = "BxRouterOtel";
        $this->MODULE_DESCRIPTION = "Сбор метрик через REST API";
    }

    public function DoInstall(): bool
    {
        if (!\Bitrix\Main\Loader::includeModule('bx.otel')) {
            throw new \Exception('Module bx.otel not installed.');
        }

        $this->registerEvents();
        ModuleManager::RegisterModule($this->MODULE_ID);
        return true;
    }

    public function DoUninstall(): bool
    {
        $this->unregisterEvents();
        ModuleManager::UnRegisterModule($this->MODULE_ID);
        return true;
    }

    private function registerEvents(): void
    {
        $eventManager = EventManager::getInstance();
        $eventManager->registerEventHandler(
            'main',
            'OnPageStart',
            $this->MODULE_ID,
            EventHandler::class,
            'onStart',
            1000
        );
    }

    private function unregisterEvents(): void
    {
        $eventManager = EventManager::getInstance();
        $eventManager->unRegisterEventHandler(
            'main',
            'OnPageStart',
            $this->MODULE_ID,
            EventHandler::class,
            'onStart'
        );
    }
}
