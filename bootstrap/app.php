<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function(Spatie\Permission\Exceptions\UnauthorizedException $e){
            return Response::errorJson($e->getMessage(),null,403);
        });
        $exceptions->renderable(function(Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e){
            return Response::errorJson($e->getMessage(),null,404);
        });
        $exceptions->renderable(function(Illuminate\Auth\AuthenticationException $e){
            return Response::errorJson($e->getMessage(),null,401);
        });
    })->create();
