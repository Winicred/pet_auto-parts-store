<?php

use App\Http\Middleware\Localization;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php'
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->appendToGroup('web', Localization::class);
    $middleware->appendToGroup('api', Localization::class);

    $middleware->validateCsrfTokens(except: [
      'cart/*/add',
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
