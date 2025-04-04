<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CrudGeneratorTest extends TestCase
{
    public function test_model_creation()
    {
        Artisan::call('make:crud', [
            'model' => 'Test',
            '--fields' => 'title:string'
        ]);

        $this->assertFileExists(app_path('Models/Test.php'));

        $modelContent = file_get_contents(app_path('Models/Test.php'));
        $this->assertStringContainsString('protected $fillable', $modelContent);
        $this->assertStringContainsString("'title'", $modelContent);
    }
}
