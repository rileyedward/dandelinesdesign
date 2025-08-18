# CRUD Implementation Guide

This guide provides step-by-step instructions for implementing CRUD operations following the established architectural patterns.

## Overview

For each new entity, you'll create files in this specific order to ensure dependencies are properly resolved:

1. Migration → Model → Factory → Request → Repository Interface → Repository → Service Interface → Service → Controller → Routes → Service Registration

## Step-by-Step Implementation

### 1. Create Migration

```bash
php artisan make:migration create_table_name_table
```

**Template:**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_name', function (Blueprint $table) {
            $table->id();
            // Add your columns here
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_name');
    }
};
```

### 2. Create Model

**Location:** `app/Models/EntityName.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntityName extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'table_name';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Add relationships here
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }
}
```

### 3. Create Factory

**Location:** `database/factories/EntityNameFactory.php`

```php
<?php

namespace Database\Factories;

use App\Models\EntityName;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntityNameFactory extends Factory
{
    protected $model = EntityName::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
```

### 4. Create Form Request

**Location:** `app/Http/Requests/EntityNameRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntityNameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // TODO: Implement authorization
    }

    public function rules(): array
    {
        $entityId = $this->route('id');
        $isUpdate = $this->isMethod('patch') || $this->isMethod('put');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('table_name', 'name')->ignore($isUpdate ? $entityId : null),
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'This name is already taken.',
        ];
    }
}
```

### 5. Create Repository Interface

**Location:** `app/Contracts/EntityNameRepositoryInterface.php`

```php
<?php

namespace App\Contracts;

interface EntityNameRepositoryInterface extends BaseRepositoryInterface
{
    // Add custom methods if needed
    // public function findBySlug(string $slug): ?EntityName;
}
```

### 6. Create Repository

**Location:** `app/Repositories/EntityNameRepository.php`

```php
<?php

namespace App\Repositories;

use App\Contracts\EntityNameRepositoryInterface;
use App\Models\EntityName;

class EntityNameRepository extends BaseRepository implements EntityNameRepositoryInterface
{
    public string $model = EntityName::class;

    // Implement custom methods if needed
    // public function findBySlug(string $slug): ?EntityName
    // {
    //     return $this->model::where('slug', $slug)->first();
    // }
}
```

### 7. Create Service Interface

**Location:** `app/Contracts/EntityNameServiceInterface.php`

```php
<?php

namespace App\Contracts;

interface EntityNameServiceInterface extends BaseServiceInterface
{
    // Add custom methods if needed
}
```

### 8. Create Service

**Location:** `app/Services/EntityNameService.php`

```php
<?php

namespace App\Services;

use App\Contracts\EntityNameRepositoryInterface;
use App\Contracts\EntityNameServiceInterface;

class EntityNameService extends BaseService implements EntityNameServiceInterface
{
    protected array $relations = [
        // 'category', // Add relationships to eager load
    ];

    public function __construct(
        protected EntityNameRepositoryInterface $repository
    ) {
        parent::__construct($repository);
    }
}
```

### 9. Create Controller

**Location:** `app/Http/Controllers/EntityNameController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Contracts\EntityNameServiceInterface;
use App\Http\Requests\EntityNameRequest;
use App\Models\EntityName;
use Inertia\Response;

class EntityNameController extends BaseController
{
    protected string $modelClass = EntityName::class;
    protected string $serviceInterface = EntityNameServiceInterface::class;
    protected string $requestClass = EntityNameRequest::class;

    public function index(): Response
    {
        // TODO: Implement index page with Inertia
        return inertia(null);
    }
}
```

### 10. Add Routes

**Location:** `routes/admin.php` (or appropriate route file)

```php
use App\Http\Controllers\EntityNameController;

Route::prefix('entity-names')->name('entity-names.')->group(function () {
    Route::get('/', [EntityNameController::class, 'index'])->name('index');
    Route::post('/', [EntityNameController::class, 'store'])->name('store');
    Route::get('/{id}', [EntityNameController::class, 'show'])->name('show');
    Route::patch('/{id}', [EntityNameController::class, 'update'])->name('update');
    Route::delete('/{id}', [EntityNameController::class, 'destroy'])->name('destroy');
});
```

### 11. Register Services

**Location:** `app/Providers/AppServiceProvider.php`

```php
public function register(): void
{
    // Add these bindings to the register method
    $this->app->bind(
        \App\Contracts\EntityNameRepositoryInterface::class,
        \App\Repositories\EntityNameRepository::class
    );

    $this->app->bind(
        \App\Contracts\EntityNameServiceInterface::class,
        \App\Services\EntityNameService::class
    );
}
```

## After Implementation

1. **Run Migration:**
   ```bash
   php artisan migrate
   ```

2. **Test the Implementation:**
   ```bash
   php artisan test
   ```

3. **Format Code:**
   ```bash
   vendor/bin/pint
   npm run format
   ```

## Common Patterns

### Relationships
When adding relationships, update both the model and service:

**Model:**
```php
public function category()
{
    return $this->belongsTo(Category::class);
}
```

**Service:**
```php
protected array $relations = ['category'];
```

### Unique Validation
For fields that must be unique but allow updates:

```php
Rule::unique('table_name', 'field_name')->ignore($isUpdate ? $entityId : null)
```

### Soft Deletes
All entities use soft deletes by default. The BaseRepository handles this automatically.

### Frontend Integration
The controller's `index()` method should return an Inertia response. The frontend components should be created in `resources/js/pages/` following the established patterns.