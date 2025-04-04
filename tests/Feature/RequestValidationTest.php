<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RequestValidationTest extends TestCase
{
    public function test_request_validation_rules()
    {
        Artisan::call('make:crud', [
            'model' => 'User',
            '--fields' => 'name:string,email:string'
        ]);

        $requestPath = app_path('Http/Requests/UserRequest.php');
        $this->assertFileExists($requestPath);

        $requestContent = file_get_contents($requestPath);

        // Test for basic rules
        $this->assertStringContainsString("'name' => 'required|string|max:255'", $requestContent);
        $this->assertStringContainsString("'email' => 'required|string|email|max:255'", $requestContent);

        // For unique rule, you might need to add a specific test case
        Artisan::call('make:crud', [
            'model' => 'Member',
            '--fields' => 'username:string:unique'
        ]);

        $memberRequestContent = file_get_contents(app_path('Http/Requests/MemberRequest.php'));
        $this->assertStringContainsString("'username' => 'required|string|max:255|unique:members'", $memberRequestContent);
    }
}
