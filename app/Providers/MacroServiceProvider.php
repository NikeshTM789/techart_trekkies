<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('successJson', function($message = 'OK', $data = null, $status = 200){
            $response = [
                'message' => $message,
                'data' => $data
            ];
            return $this->json($response, $status);
        });
        Response::macro('errorJson', function($message = 'Error', $data = null, $status = 422){
            $response = [
                'message' => $message,
                'data' => $data
            ];
            return $this->json($response, $status);
        });
    }
}
