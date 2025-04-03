# Laravel CRUD Generator - README

## Overview

A powerful Laravel package that automatically generates complete CRUD (Create, Read, Update, Delete) operations for your models with a single Artisan command. This package creates:

- Models with fillable attributes and relationships
- Database migrations with proper data types
- Controllers with RESTful methods
- Form Request validation classes
- Blade views with reusable components
- API and web routes

## Features

✅ **One-command CRUD generation**  
✅ **Supports all field types** (string, text, enum, datetime, etc.)  
✅ **Relationship handling** (hasMany, belongsTo, belongsToMany)  
✅ **Automatic route generation** (API and web)  
✅ **Validation rules generation**  
✅ **Modern Blade components**  
✅ **Laravel 12+ compatible**  
✅ **Fully customizable stubs**  

## Installation

1. Install via Composer:

```bash
composer require rakibur-rimon/laravel-crud-generator
```

2. For Laravel 12, add this to your `bootstrap/app.php` after the `$app` initialization:

```php
\RakiburRimon\CrudGenerator\CrudGenerator::register($app);
```

## Usage

### Basic Command

Generate a complete CRUD for a model:

```bash
php artisan make:crud Product --fields="name:string,price:decimal,description:text"
```

### With Relationships

```bash
php artisan make:crud Post --fields="title:string,content:text" --relations="comments:hasMany,author:belongsTo,tags:belongsToMany"
```

### With Enum Field

```bash
php artisan make:crud Task --fields="title:string,status:enum(open,closed,archived)"
```

### With Date/Time Fields

```bash
php artisan make:crud Event --fields="name:string,start_at:datetime,end_at:datetime"
```

## Field Types Supported

| Type        | Example                     | Description                          |
|-------------|-----------------------------|--------------------------------------|
| string      | `name:string`               | VARCHAR(255) field                   |
| text        | `description:text`          | TEXT field                           |
| integer     | `quantity:integer`          | INTEGER field                        |
| decimal     | `price:decimal`             | DECIMAL field (15,2)                 |
| boolean     | `is_active:boolean`         | BOOLEAN/TINYINT(1) field             |
| date        | `birthday:date`             | DATE field                           |
| datetime    | `published_at:datetime`     | DATETIME field                       |
| enum        | `status:enum(open,closed)`  | ENUM field with specified options    |
| json        | `meta:json`                 | JSON field                           |

## Relationship Types Supported

| Type          | Example                     | Description                          |
|---------------|-----------------------------|--------------------------------------|
| hasOne        | `profile:hasOne`            | One-to-one relationship              |
| hasMany       | `comments:hasMany`          | One-to-many relationship             |
| belongsTo     | `author:belongsTo`          | Inverse of hasOne/hasMany            |
| belongsToMany | `tags:belongsToMany`        | Many-to-many relationship            |

## Customization

### Publishing Stubs

Customize the template files:

```bash
php artisan vendor:publish --tag=crud-generator-stubs
```

This will copy all stub files to `stubs/vendor/crud-generator/` where you can modify them.

### Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=crud-generator-config
```

Available configuration options:

```php
return [
    'model_namespace' => 'App\Models',
    'controller_namespace' => 'App\Http\Controllers',
    'api_controller_namespace' => 'App\Http\Controllers\Api',
    'request_namespace' => 'App\Http\Requests',
    'views_path' => 'resources/views',
    'api_prefix' => 'api',
    'route_middleware' => ['web'],
];
```

## Generated Files Structure

For a `Post` model, the generator will create:

```
app/
├── Models/
│   └── Post.php
├── Http/
│   ├── Controllers/
|   |   ├── Api/
│   │   |    └── PostController.php
│   │   └── PostController.php
│   └── Requests/
│       └── PostRequest.php
database/
└── migrations/
    └── [timestamp]_create_posts_table.php
resources/
└── views/
    └── posts/
        ├── index.blade.php
        ├── create.blade.php
        ├── edit.blade.php
        └── show.blade.php
routes/
├── api.php
└── web.php
```

## Best Practices

1. **Review generated code** - Always check the generated files before using in production
2. **Use version control** - Commit before generating new CRUDs to easily review changes
3. **Customize stubs** - Adapt the templates to match your project's coding standards
4. **Run migrations** - Remember to run `php artisan migrate` after generation

## Troubleshooting

**Q: I get an error about duplicate routes/migrations/models**
A: The generator checks for existing files, but you may need to manually delete previous versions if you're regenerating

**Q: My custom fields aren't showing up in the views**
A: Make sure to publish and update the view stubs to include your custom field types

**Q: Relationships aren't working**
A: Verify that both models in the relationship exist and the relationship type is correct

## Contributing

Pull requests are welcome! Please follow PSR-12 coding standards and include tests for new features.

## License

MIT License - See LICENSE file included in the package.
