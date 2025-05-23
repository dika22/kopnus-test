<?php

namespace App\Http;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\RoleEmployee;
use App\Http\Middleware\RoleJobseeker;

Class Kernel extends HttpKernel 
{
    protected $middlewareGroups = [
        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // optional for SPA
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];
    
    protected $routeMiddleware = [
        'emp' => RoleEmployee::class,
        'jobseeker' => RoleJobseeker::class,
    ];
}