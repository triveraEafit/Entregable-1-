<?php

use App\Http\Middleware\EnsureUserIsAdmin;

/*
 * Pega esto dentro de bootstrap/app.php de tu proyecto Laravel 13,
 * en el bloque ->withMiddleware(function (Middleware $middleware) { ... })
 */

$middleware->alias([
    'admin' => EnsureUserIsAdmin::class,
]);

/*
 * Y registra el RepositoryServiceProvider en bootstrap/providers.php:
 *
 * return [
 *     App\Providers\AppServiceProvider::class,
 *     App\Providers\RepositoryServiceProvider::class,
 * ];
 */
