<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CommandValidationTest extends TestCase
{
    public function test_requires_model_name_argument()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments');

        Artisan::call('make:crud');
    }
}
