<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ModelGenerationTest extends TestCase
{
    public function test_model_has_correct_fillable_fields()
    {
        Artisan::call('make:crud', [
            'model' => 'Book',
            '--fields' => 'title:string,isbn:string'
        ]);

        $modelPath = app_path('Models/Book.php');
        $this->assertFileExists($modelPath);

        $modelContent = file_get_contents($modelPath);
        $this->assertStringContainsString("protected \$fillable = ['title', 'isbn']", $modelContent);
    }
}
