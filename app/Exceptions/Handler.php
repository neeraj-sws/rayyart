<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        if ($request->user() && $e instanceof MissingAbilityException) {
            return response()->json([
                "status" => 401, 
                "message" => "Unauthenticated.",
                "data" => []
            ], 401);
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
           //
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // if ($request->expectsJson()) {
        //     return response()->json(['message' => 'Unauthenticated.'], 401);
        // }

        // if($exception instanceof AuthenticationException) {
        //     $guards = array_keys(config('auth.guards'));
        //       foreach ($guards as $guard) {
        //     if ($request->is("$guard") || $request->is("$guard/*")) {
        //         return redirect()->guest(route("$guard.adminlogin.form"));
        //     }
        // }
        // } 

        if($exception instanceof AuthenticationException) {
            return response()->json([
                "status" => 401, 
                "message" => "Unauthenticated.",
                "data" => []
            ],401);
        }
        // $guards = array_keys(config('auth.guards'));

        // foreach ($guards as $guard) {
        //     if ($request->is("$guard") || $request->is("$guard/*")) {
        //         return redirect()->guest(route("$guard/login-form"));
        //     }
        // }

        if ($request->is('admin') || $request->is('admin/*')) {
            return redirect()->guest('/admin');
        }
        
        if ($request->is('client') || $request->is('client/*')) {
            return redirect()->guest('/client');
        }

        return redirect()->guest(route('login'));
    }
}
