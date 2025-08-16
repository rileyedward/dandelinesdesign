# Base Classes Documentation

This document details the base classes that form the foundation of the CRUD architecture.

## BaseRepository

**Location:** `app/Repositories/BaseRepository.php`

### Purpose
Provides standardized data access methods for all entities, ensuring consistent database operations across the application.

### Key Methods

```php
abstract class BaseRepository
{
    // Find entity by ID with optional relationships
    public function findById(int $id, array $with = []): ?Model;
    
    // Store new entity
    public function store(array $data): Model;
    
    // Update existing entity
    public function update(int $id, array $data): Model;
    
    // Soft delete entity
    public function delete(int $id): bool;
}
```

### Implementation Requirements

All repositories must:
1. Extend `BaseRepository`
2. Implement a specific interface (extends `BaseRepositoryInterface`)
3. Define the `$model` property with the Eloquent model class

**Example:**
```php
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public string $model = Product::class;
    
    // Custom methods can be added here
    public function findBySlug(string $slug): ?Product
    {
        return $this->model::where('slug', $slug)->first();
    }
}
```

### Features
- **Automatic Model Resolution:** Uses the `$model` property to instantiate models
- **Soft Delete Support:** Automatically handles soft deletes
- **Relationship Loading:** Supports eager loading via `$with` parameter
- **Type Safety:** Returns typed models or null

---

## BaseService

**Location:** `app/Services/BaseService.php`

### Purpose
Encapsulates business logic and manages relationships between entities. Acts as an intermediary between controllers and repositories.

### Key Features

```php
abstract class BaseService
{
    protected array $relations = []; // Define relationships to eager load
    
    // Find entity with configured relationships
    public function findById(int $id): ?Model;
    
    // Store with relationship loading
    public function store(array $data): Model;
    
    // Update with relationship loading
    public function update(int $id, array $data): Model;
    
    // Delete entity
    public function delete(int $id): bool;
}
```

### Implementation Requirements

All services must:
1. Extend `BaseService`
2. Implement a specific interface (extends `BaseServiceInterface`)
3. Inject the corresponding repository interface via constructor
4. Define `$relations` array for eager loading

**Example:**
```php
class ProductService extends BaseService implements ProductServiceInterface
{
    protected array $relations = ['category', 'images'];
    
    public function __construct(
        protected ProductRepositoryInterface $repository
    ) {
        parent::__construct($repository);
    }
    
    // Custom business logic methods
    public function markAsFeatured(int $id): Product
    {
        $product = $this->repository->findById($id);
        return $this->repository->update($id, ['is_featured' => true]);
    }
}
```

### Relationship Management
The `$relations` array automatically eager loads specified relationships:

```php
protected array $relations = [
    'category',           // belongsTo
    'images',            // hasMany
    'tags',              // belongsToMany
    'category.parent'    // nested relationship
];
```

---

## BaseController

**Location:** `app/Http/Controllers/BaseController.php`

### Purpose
Handles HTTP concerns and provides standardized CRUD endpoints. Manages request validation, service coordination, and response formatting.

### Key Methods

```php
abstract class BaseController extends Controller
{
    // Store new entity (POST)
    public function store(Request $request): JsonResponse;
    
    // Update existing entity (PATCH/PUT)
    public function update(Request $request, int $id): JsonResponse;
    
    // Delete entity (DELETE)
    public function destroy(int $id): JsonResponse;
    
    // Show single entity (GET)
    public function show(int $id): JsonResponse;
}
```

### Implementation Requirements

All controllers must define these properties:
- `$modelClass`: The Eloquent model class name
- `$serviceInterface`: The service interface class name
- `$requestClass`: The form request class name for validation

**Example:**
```php
class ProductController extends BaseController
{
    protected string $modelClass = Product::class;
    protected string $serviceInterface = ProductServiceInterface::class;
    protected string $requestClass = ProductRequest::class;
    
    public function index(): Response
    {
        // TODO: Implement index page with Inertia
        return inertia('Products/Index');
    }
    
    // Custom endpoints can be added here
    public function featured(): JsonResponse
    {
        $products = $this->service->getFeaturedProducts();
        return response()->json($products);
    }
}
```

### Automatic Features

#### Request Validation
The controller automatically validates requests using the specified `$requestClass`:

```php
// In store() and update() methods
$validatedData = app($this->requestClass)->validated();
```

#### Input Filtering
Automatically removes the 'with' parameter from request data to prevent injection:

```php
protected function getFilteredInput(array $input): array
{
    return collect($input)->except(['with'])->toArray();
}
```

#### Service Resolution
Services are automatically resolved via dependency injection:

```php
protected function getService(): BaseServiceInterface
{
    return app($this->serviceInterface);
}
```

#### Authorization (Planned)
Authorization hooks are prepared but commented out:

```php
// TODO: Implement authorization
// $this->authorize('create', $this->modelClass);
```

### Response Format

All endpoints return consistent JSON responses:

```json
{
    "id": 1,
    "name": "Product Name",
    "category": {
        "id": 1,
        "name": "Category Name"
    },
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

---

## Dependency Injection Flow

```
Controller → Service → Repository → Model → Database
```

1. **Controller** receives HTTP request
2. **Service** is injected via interface binding
3. **Repository** is injected into service via interface binding
4. **Model** is resolved in repository via `$model` property
5. **Database** operations are performed through Eloquent

## Interface Binding

All interfaces are bound in `AppServiceProvider`:

```php
public function register(): void
{
    $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    $this->app->bind(ProductServiceInterface::class, ProductService::class);
}
```

This allows for:
- **Testability:** Easy mocking of dependencies
- **Flexibility:** Swappable implementations
- **Consistency:** Standardized contracts across the application

## Error Handling

Base classes include consistent error handling:
- **Model Not Found:** Returns 404 responses
- **Validation Errors:** Returns 422 with error details
- **Database Errors:** Returns 500 with appropriate messages
- **Soft Delete Awareness:** Automatically excludes deleted records

## Testing Support

Base classes are designed for easy testing:
- Interface-based dependencies for mocking
- Predictable method signatures
- Consistent return types
- Factory integration for test data