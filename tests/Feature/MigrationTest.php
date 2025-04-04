<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MigrationTest extends TestCase
{
    public function test_migration_has_correct_columns()
    {
        Artisan::call('make:crud', [
            'model' => 'Product',
            '--fields' => 'name:string,price:decimal'
        ]);

        $migrations = glob(database_path('migrations/*_create_products_table.php'));
        $latestMigration = end($migrations);

        $migrationContent = file_get_contents($latestMigration);
        $this->assertStringContainsString("\$table->string('name')", $migrationContent);
        $this->assertStringContainsString("\$table->decimal('price')", $migrationContent);
    }
}
