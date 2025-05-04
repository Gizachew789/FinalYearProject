<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // ... other code

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
       'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,

       'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
   
       'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,

    ];
}

