<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Spatie\Permission\Http\Middleware\RoleMiddleware;
use Spatie\Permission\Http\Middleware\PermissionMiddleware;
use Spatie\Permission\Http\Middleware\RoleOrPermissionMiddleware;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'reception' => \App\Http\Middleware\ReceptionMiddleware::class,
        'is_admin' => \App\Http\Middleware\IsAdmin::class,
        'role' => RoleMiddleware::class,
        'permission' => PermissionMiddleware::class,
        'role_or_permission' => RoleOrPermissionMiddleware::class,
    ];
}
