<?php

namespace App\Services\CrudGenerator;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ControllerGenerator
{
    protected $modelName;
    protected $fields;
    protected $relations;
    protected $modelNamespace;

    public function __construct($modelName, $fields, $relations, $modelNamespace = 'App\\Models')
    {
        $this->modelName = $modelName;
        $this->fields = $fields;
        $this->relations = $relations;
        $this->modelNamespace = $modelNamespace;
    }

    public function generate()
    {
        $stub = File::get($this->getStubPath('controller'));

        $modelVariable = Str::camel($this->modelName);
        $modelPlural = Str::camel(Str::plural($this->modelName));
        $requestClass = $this->modelName . 'Request';
        $fullModelClass = $this->modelNamespace . '\\' . $this->modelName;

        $replacements = [
            '{{namespace}}' => 'App\\Http\\Controllers',
            '{{class}}' => $this->modelName . 'Controller',
            '{{model}}' => $this->modelName,
            '{{fullModelClass}}' => $fullModelClass,
            '{{modelVariable}}' => $modelVariable,
            '{{modelPlural}}' => $modelPlural,
            '{{requestClass}}' => $requestClass,
            '{{requestNamespace}}' => 'App\\Http\\Requests\\' . $requestClass,
        ];

        $content = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $stub
        );

        $path = app_path('Http/Controllers/' . $this->modelName . 'Controller.php');

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $content);
    }

    protected function getStubPath($type)
    {
        return base_path("stubs/{$type}.stub");
    }
}
