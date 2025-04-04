<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RouteGenerationTest extends TestCase
{
    public function test_routes_are_registered()
    {
        Artisan::call('make:crud', ['model' => 'Category']);

        $apiRouteContent = file_get_contents(base_path('routes/api.php'));
        $this->assertStringContainsString("Route::apiResource('categories'", $apiRouteContent);

        $webRouteContent = file_get_contents(base_path('routes/web.php'));
        $this->assertStringContainsString("Route::resource('categories'", $webRouteContent);
    }
}
