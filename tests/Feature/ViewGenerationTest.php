<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ViewGenerationTest extends TestCase
{
    public function test_view_files_are_created()
    {
        Artisan::call('make:crud', ['model' => 'Comment']);

        $viewPath = resource_path('views/comments/');
        $this->assertDirectoryExists($viewPath);

        $this->assertFileExists($viewPath.'index.blade.php');
        $this->assertFileExists($viewPath.'create.blade.php');
        $this->assertFileExists($viewPath.'edit.blade.php');
        $this->assertFileExists($viewPath.'show.blade.php');
    }
}
