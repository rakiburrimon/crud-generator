<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RelationshipTest extends TestCase
{
    public function test_has_many_relationship_generation()
    {
        // First create the related model
        Artisan::call('make:crud', [
            'model' => 'Book',
            '--fields' => 'title:string'
        ]);

        // Then create the main model with relationship
        Artisan::call('make:crud', [
            'model' => 'Author',
            '--fields' => 'name:string',
            '--relations' => 'books:hasMany'
        ]);

        $modelPath = app_path('Models/Author.php');
        $this->assertFileExists($modelPath);

        $modelContent = file_get_contents($modelPath);

        $this->assertStringContainsString('use App\Models\Book;', $modelContent);
        $this->assertStringContainsString('public function books()', $modelContent);
        $this->assertStringContainsString('return $this->hasMany(Book::class);', $modelContent);
    }
}
