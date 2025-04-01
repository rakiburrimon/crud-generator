<?php

namespace App\Services\CrudGenerator;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RouteGenerator
{
    protected $modelName;
    protected $controllerNamespace;
    protected $routeName;

    public function __construct($modelName, $controllerNamespace = 'App\Http\Controllers')
    {
        $this->modelName = $modelName;
        $this->controllerNamespace = $controllerNamespace;
        $this->routeName = Str::kebab(Str::plural($this->modelName));
    }

    public function generate()
    {
        $controller = $this->modelName . 'Controller';
        $fullControllerPath = $this->controllerNamespace . '\\' . $controller;

        // API Routes
        $apiRoute = <<<ROUTE
        Route::apiResource('{$this->routeName}', \\{$fullControllerPath}::class)
            ->names('api.{$this->routeName}')
            ->parameters(['{$this->routeName}' => '{$this->modelNameLowerCase()}']);
        ROUTE;
        $this->appendToRoutesFile($apiRoute, 'api');

        // Web Routes
        $webRoute = <<<ROUTE
        Route::resource('{$this->routeName}', \\{$fullControllerPath}::class)
            ->parameters(['{$this->routeName}' => '{$this->modelNameLowerCase()}']);
        ROUTE;
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
        if (strpos($content, "Route::resource('{$this->routeName}'") === false &&
            strpos($content, "Route::apiResource('{$this->routeName}'") === false) {

            // Add proper route group if not exists
            if ($type === 'api' && strpos($content, 'Route::prefix(\'api\')') === false) {
                $route = "Route::prefix('api')->group(function () {\n    {$route}\n});";
            }

            $content = rtrim($content) . "\n\n" . $route . "\n";
            File::put($path, $content);
        }
    }

    protected function modelNameLowerCase()
    {
        return Str::camel($this->modelName);
    }
}
