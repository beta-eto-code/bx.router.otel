<?php

namespace Bx\Router\Otel;

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use OpenTelemetry\API\Trace\SpanInterface;
use OpenTelemetry\API\Trace\TracerInterface;
use OpenTelemetry\Contrib\Otlp\ContentTypes;
use OpenTelemetry\Contrib\Otlp\OtlpHttpTransportFactory;
use OpenTelemetry\Contrib\Otlp\SpanExporter;
use OpenTelemetry\SDK\Common\Export\Stream\StreamTransport;
use OpenTelemetry\SDK\Common\Http\Psr\Client\Discovery;
use OpenTelemetry\SDK\Trace\SpanExporter\ConsoleSpanExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use OpenTelemetry\SDK\Trace\TracerProviderInterface;
use Otel\Base\Abstracts\OTeBaselSpanManager;

class BxRouterOTelSpanManager extends OTeBaselSpanManager
{
    private static ?array $options = null;

    public function __construct(TracerProviderInterface $tracerProvider, ?iterable $eventIterator = null)
    {
        parent::__construct($tracerProvider, $eventIterator);
    }

    public static function getOptions(): array
    {

        if (!is_null(self::$options)) {
            return self::$options;
        }

        $optionsTabs = ConfigList::getOptionsTab();
        $mid = ConfigList::MODULE_NAME;
        $result = [];


        foreach ($optionsTabs as $optionTab) {
            foreach ($optionTab['options'] as $name => $value) {
                if (is_string($value)) {
                    $optionName = $name;
                } else if (is_array($value)) {
                    $optionName = $value['name'] ?? null;
                    if (!$optionName) {
                        continue;
                    }
                } else {
                    continue;
                }

                $optionValue = (string)Option::get($mid, $optionName, $value['default'] ?? "");
                $decodedValue = json_decode($optionValue, true) ?? null;
                if ($decodedValue) {
                    $optionValue = $decodedValue;
                }

                $result[$name] = $optionValue;
            }
        }
        self::$options = $result;
        return self::$options;
    }

    public function __destruct()
    {
        if (!$this->isEnabled()) {
            return;
        }
        $request = Application::getInstance()->getContext()->getRequest();
        $uri = $request->getRequestUri();
        $options = self::getOptions();

        if (!empty($options[ConfigList::OTEL_URLS] && is_array($options[ConfigList::OTEL_URLS]))) {
            if (in_array($uri, $options[ConfigList::OTEL_URLS])) {
                parent::__destruct(); // TODO: Change the autogenerated stub
            }
        } else {
            parent::__destruct(); // TODO: Change the autogenerated stub
        }
    }

    public function createAndStartSpan($name, $attributes = []): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        parent::createAndStartSpan($name, $attributes); // TODO: Change the autogenerated stub
    }

    public function addSpanEvent(string $spanName, string $eventName, ?array $attributes): void
    {
        if (!$this->isEnabled()) {
            return;
        }
        parent::addSpanEvent($spanName, $eventName, $attributes); // TODO: Change the autogenerated stub
    }

    public function endSpan(): void
    {
        if (!$this->isEnabled()) {
            return;
        }
        parent::endSpan(); // TODO: Change the autogenerated stub
    }

    public function getTracer(): TracerInterface
    {
        return parent::getTracer(); // TODO: Change the autogenerated stub
    }

    public function setTracer(?string $tracerName): void
    {
        parent::setTracer($tracerName); // TODO: Change the autogenerated stub
    }

    public function startRootSpan(?array $attributes = []): void
    {
        if (!$this->isEnabled()) {
            return;
        }
        parent::startRootSpan($attributes); // TODO: Change the autogenerated stub
    }

    public function getSpan(): ?SpanInterface
    {
        if (!$this->isEnabled()) {
            return null;
        }
        return parent::getSpan(); // TODO: Change the autogenerated stub
    }

    public function getEventListener(): ?iterable
    {
        if (!$this->isEnabled()) {
            return [];
        }

        return parent::getEventListener(); // TODO: Change the autogenerated stub
    }

    public function getSpansNames(): array
    {
        if (!$this->isEnabled()) {
            return [];
        }

        return parent::getSpansNames(); // TODO: Change the autogenerated stub
    }

    private function isEnabled(): bool
    {
        $options = self::getOptions();
        return ($options[ConfigList::USE_OTEL] == 'Y');
    }

    public static function factory(): self
    {

        $options = self::getOptions();

        try {
            if ($options[ConfigList::OTEL_HOST]) {
                if ($options[ConfigList::OTEL_SSL_VERIFY_DISABLE]) {
                    Discovery::setDiscoverers([
                        \Bx\Router\Otel\GuzzleNonSSLDiscovery::class
                    ]);
                }

                $transport = (new OtlpHttpTransportFactory())
                    ->create($options[ConfigList::OTEL_HOST], ContentTypes::JSON);
                $exporter = new SpanExporter($transport);
            } else {
                $stream = fopen('php://stdout', 'w');
                $exporter = new ConsoleSpanExporter(
                    new StreamTransport($stream, 'json')
                );
            }
        } catch (\Throwable $e) {

            $stream = fopen('php://stdout', 'w');
            $exporter = new ConsoleSpanExporter(
                new StreamTransport($stream, 'json')
            );

        }


        $tracerProvider = new TracerProvider(
            new SimpleSpanProcessor(
                $exporter
            )
        );

        return new self($tracerProvider);
    }
}
