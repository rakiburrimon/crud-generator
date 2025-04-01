<?php

namespace App\Services\CrudGenerator;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RouteGenerator
{
    protected $modelName;

    public function __construct($modelName)
    {
        $this->modelName = $modelName;
    }

    public function generate()
    {
        $routeName = Str::kebab(Str::plural($this->modelName));
        $controller = $this->modelName . 'Controller';

        // API Routes
        $apiRoute = "Route::apiResource('{$routeName}', {$controller}::class);";
        $this->appendToRoutesFile($apiRoute, 'api');

        // Web Routes
        $webRoute = "Route::resource('{$routeName}', {$controller}::class);";
        $this->appendToRoutesFile($webRoute, 'web');
    }

    protected function appendToRoutesFile($route, $type)
    {
        $path = base_path("routes/{$type}.php");

        // Create the file if it doesn't exist
        if (!File::exists($path)) {
            $content = "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\n";
            File::put($path, $content);
        } else {
            $content = File::get($path);
        }

        // Check if route already exists
        if (strpos($content, $route) === false) {
            $content = rtrim($content) . "\n\n" . $route . "\n";
            File::put($path, $content);
        }
    }
}
