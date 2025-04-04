<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    public function test_controller_has_crud_methods()
    {
        Artisan::call('make:crud', ['model' => 'Post']);

        $controllerPath = app_path('Http/Controllers/PostController.php');
        $controllerContent = file_get_contents($controllerPath);

        $this->assertStringContainsString('public function index()', $controllerContent);
        $this->assertStringContainsString('public function store(PostRequest $request)', $controllerContent);
        $this->assertStringContainsString('public function update(PostRequest $request, Post $post)', $controllerContent);
    }
}
