# OpenTelemetry модуль для использования Bitrix проектах с REST API

**Установка**
```shell
composer require beta/bx.router.otel
```

**Пример описания HTTP контроллера: REST API приложения с интеграцией OpenTelemetry**
```php
use Psr\Http\Message\ServerRequestInterface;

public function handle(ServerRequestInterface $request) {
    ...
    $taskId   = $request->getAttribute('task_id');
    
    \Bx\Router\Otel\Event\EventHelper::newSpanEvent($request, 'EventName', [
        'task_id' => $taskId,
    ]);


    \Bx\Router\Otel\Event\EventHelper::newSpanEvent($request, 'IncludedSpanName', [
        'task_id' => $taskId,
    ]);
    
    new \Bitrix\Main\Event('bx.router.otel', 'new_span', [
        $request,
        'IncludedSpanName',
        [
            'task_id' => $taskId,
        ]
    ]);
    
    new \Bitrix\Main\Event('bx.router.otel', 'new_span_event', [
        $request,
        'EventName',
        [
            'task_id' => $taskId,
        ]
    ]);
}

```
