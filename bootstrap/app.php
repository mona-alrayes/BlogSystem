<?php

use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Illuminate\Database\Eloquent\ModelNotFoundException|Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'The requested model was not found.',
            ], 404);
        });

        $exceptions->render(function (Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e, $request) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'The HTTP method is not allowed for this route.',
            ], 405);
        });

        $exceptions->render(function (Illuminate\Auth\AuthenticationException $e, $request) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated, please login.',
            ], 401);
        });

        $exceptions->render(function (Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException|Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException|Illuminate\Auth\Access\AuthorizationException $e, $request) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'You do not have permission to access this resource.',
            ], 403);
        });

        $exceptions->render(function (Illuminate\Http\Exceptions\ThrottleRequestsException $e, $request) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Too many requests. Please slow down.',
            ], 429);
        });

        $exceptions->render(function (Symfony\Component\HttpKernel\Exception\BadRequestHttpException $e, $request) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Bad request. Please check your input.',
            ], 400);
        });

        $exceptions->render(function (Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException $e, $request) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Unsupported media type.',
            ], 415);
        });

        $exceptions->render(function (Illuminate\Database\QueryException $e, $request) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'A database query error occurred.',
            ], 500);
        });

        $exceptions->render(function (\Exception $e, $request) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $debug = config('app.debug');
            $message = $debug ? $e->getMessage() : 'An unexpected error occurred.';
            $status = $debug ? ($e->getCode() ?: 500) : 500;
            return response()->json([
                'status' => 'error',
                'message' => $message,
            ], $status);
        });
    })->create();
