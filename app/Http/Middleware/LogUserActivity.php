<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ActivityLogger;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Log user activity here
        if (auth()->check()) {
            $user = auth()->user();
            $action = $request->route()->getName(); // You can customize this based on your needs
            $description = 'Visited ' . $request->url();

            ActivityLogger::log($user->id, $action, $description);
        }

        return $response;
    }
}
