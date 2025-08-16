# Best Practices

This document outlines coding standards, conventions, and best practices for maintaining consistency across the CRUD implementation.

## Naming Conventions

### Models
- **Singular form**: `Event`, `Product`, `Category`
- **PascalCase**: `BlogPost`, `QuoteRequest`
- **Descriptive**: Use clear, business-domain names

### Tables
- **Plural form**: `events`, `products`, `categories`
- **Snake_case**: `blog_posts`, `quote_requests`
- **Consistent**: Match the plural form of model names

### Files and Classes
```
Model:           Event                    (app/Models/Event.php)
Factory:         EventFactory             (database/factories/EventFactory.php)
Request:         EventRequest             (app/Http/Requests/EventRequest.php)
Repository:      EventRepository          (app/Repositories/EventRepository.php)
Interface:       EventRepositoryInterface (app/Contracts/EventRepositoryInterface.php)
Service:         EventService             (app/Services/EventService.php)
Interface:       EventServiceInterface    (app/Contracts/EventServiceInterface.php)
Controller:      EventController          (app/Http/Controllers/EventController.php)
```

### Routes
- **Kebab-case**: `quote-requests`, `blog-posts`
- **RESTful**: Follow standard REST conventions
- **Descriptive**: Use clear endpoint names

```php
Route::prefix('quote-requests')->name('quote-requests.')->group(function () {
    Route::get('/', [QuoteRequestController::class, 'index'])->name('index');
    Route::post('/', [QuoteRequestController::class, 'store'])->name('store');
    // ...
});
```

## Database Design

### Required Fields
Every table should include:
```php
$table->id();                    // Primary key
$table->timestamps();            // created_at, updated_at
$table->softDeletes();          // deleted_at
```

### Field Types
- **Strings**: Use appropriate length limits (`string('name', 255)`)
- **Text**: For longer content (`text('description')`)
- **Booleans**: Use descriptive names (`is_active`, `is_published`, `is_featured`)
- **Decimals**: For money values (`decimal('price', 8, 2)`)
- **Dates**: Use `datetime` for full timestamps, `date` for date-only

### Foreign Keys
```php
$table->foreignId('category_id')->constrained()->cascadeOnDelete();
```
- Use `constrainted()` to enforce referential integrity
- Consider cascade behavior carefully

### Indexes
Add indexes for frequently queried columns:
```php
$table->index('slug');
$table->index('is_active');
$table->index(['category_id', 'is_active']);
```

## Model Conventions

### Fillable Fields
```php
protected $fillable = [
    'name',
    'description',
    'is_active',
    // Never include 'id', 'created_at', 'updated_at'
];
```

### Casts
```php
protected $casts = [
    'is_active' => 'boolean',
    'price' => 'decimal:2',
    'event_date' => 'datetime',
    'settings' => 'array',
];
```

### Relationships
- Use type hints for better IDE support
- Follow Laravel naming conventions

```php
public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}

public function products(): HasMany
{
    return $this->hasMany(Product::class);
}
```

## Validation Rules

### Common Patterns
```php
public function rules(): array
{
    $entityId = $this->route('id');
    $isUpdate = $this->isMethod('patch') || $this->isMethod('put');

    return [
        // Required string with length limit
        'name' => 'required|string|max:255',
        
        // Unique field with update support
        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($isUpdate ? $entityId : null),
        ],
        
        // Foreign key validation
        'category_id' => 'required|exists:categories,id',
        
        // Boolean with default
        'is_active' => 'boolean',
        
        // Optional fields
        'description' => 'nullable|string',
        
        // Numeric constraints
        'price' => 'required|numeric|min:0|max:9999.99',
        
        // Date validation
        'event_date' => 'required|date|after:now',
    ];
}
```

### Custom Messages
```php
public function messages(): array
{
    return [
        'name.required' => 'The name field is required.',
        'email.unique' => 'This email is already taken.',
        'category_id.exists' => 'The selected category is invalid.',
    ];
}
```

## Service Layer Best Practices

### Relationship Management
```php
class ProductService extends BaseService
{
    protected array $relations = [
        'category',              // Direct relationship
        'images',               // Has many
        'category.parent',      // Nested relationship
    ];
}
```

### Business Logic Methods
```php
public function markAsFeatured(int $id): Product
{
    // Validate business rules
    $product = $this->repository->findById($id);
    
    if (!$product->is_active) {
        throw new InvalidOperationException('Cannot feature inactive products');
    }
    
    // Perform the operation
    return $this->repository->update($id, ['is_featured' => true]);
}
```

## Controller Best Practices

### Standard CRUD
- Extend `BaseController` for standard operations
- Only add custom methods when needed
- Use proper HTTP status codes

```php
class ProductController extends BaseController
{
    protected string $modelClass = Product::class;
    protected string $serviceInterface = ProductServiceInterface::class;
    protected string $requestClass = ProductRequest::class;

    public function index(): Response
    {
        // TODO: Implement with Inertia
        return inertia('Products/Index');
    }
}
```

### Custom Endpoints
```php
public function featured(): JsonResponse
{
    $products = $this->getService()->getFeaturedProducts();
    return response()->json($products);
}

public function toggleFeatured(int $id): JsonResponse
{
    // TODO: Add authorization
    $product = $this->getService()->toggleFeatured($id);
    return response()->json($product);
}
```

## Repository Best Practices

### Query Methods
```php
public function findActiveByCategory(int $categoryId): Collection
{
    return $this->model::where('category_id', $categoryId)
        ->where('is_active', true)
        ->orderBy('created_at', 'desc')
        ->get();
}
```

### Single Responsibility
- Keep methods focused on data access
- Avoid business logic in repositories
- Use descriptive method names

## Error Handling

### Validation Errors
Laravel automatically handles validation errors with 422 status codes.

### Not Found Errors
```php
public function show(int $id): JsonResponse
{
    $entity = $this->getService()->findById($id);
    
    if (!$entity) {
        return response()->json(['message' => 'Entity not found'], 404);
    }
    
    return response()->json($entity);
}
```

### Business Logic Errors
```php
class InvalidOperationException extends Exception
{
    public function __construct(string $message = "Invalid operation")
    {
        parent::__construct($message, 422);
    }
}
```

## Testing Guidelines

### Factory Design
```php
public function definition(): array
{
    return [
        'name' => $this->faker->words(3, true),
        'email' => $this->faker->unique()->safeEmail(),
        'is_active' => $this->faker->boolean(80), // 80% active
    ];
}

public function inactive(): static
{
    return $this->state(['is_active' => false]);
}
```

### Test Structure
```php
test('can create a product', function () {
    $category = Category::factory()->create();
    
    $productData = [
        'category_id' => $category->id,
        'name' => 'Test Product',
        'price' => 99.99,
    ];
    
    $response = $this->postJson('/admin/products', $productData);
    
    $response->assertStatus(201);
    $this->assertDatabaseHas('products', ['name' => 'Test Product']);
});
```

## Security Considerations

### Authorization
```php
// TODO: Implement authorization in controllers
$this->authorize('create', Product::class);
$this->authorize('update', $product);
```

### Input Sanitization
- Use validated() method from form requests
- The BaseController automatically filters 'with' parameter
- Validate all user input

### SQL Injection Prevention
- Use Eloquent ORM (automatically prevents SQL injection)
- Parameterize any raw queries
- Validate foreign key constraints

## Performance Optimization

### Eager Loading
```php
// In services
protected array $relations = ['category', 'images'];

// For specific queries
$products = Product::with(['category', 'images'])->get();
```

### Indexes
Add database indexes for:
- Foreign keys
- Frequently searched columns
- Unique constraints
- Composite indexes for complex queries

### Pagination
```php
public function getPaginatedProducts(int $perPage = 15): LengthAwarePaginator
{
    return $this->model::with($this->relations)
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);
}
```

## Code Documentation

### Method Documentation
```php
/**
 * Find events by category with optional date filtering.
 *
 * @param int $categoryId The category ID to filter by
 * @param Carbon|null $startDate Optional start date filter
 * @param Carbon|null $endDate Optional end date filter
 * @return Collection<Event>
 */
public function findByCategoryAndDateRange(
    int $categoryId, 
    ?Carbon $startDate = null, 
    ?Carbon $endDate = null
): Collection {
    // Implementation...
}
```

### Class Documentation
```php
/**
 * Service for managing floral design events.
 * 
 * Handles business logic for event creation, publishing,
 * and category-based filtering.
 */
class EventService extends BaseService implements EventServiceInterface
{
    // Implementation...
}
```

## File Organization

```
app/
├── Contracts/           # Interfaces
├── Http/
│   ├── Controllers/     # Controllers
│   └── Requests/        # Form requests
├── Models/              # Eloquent models
├── Repositories/        # Data access layer
└── Services/            # Business logic layer

database/
├── factories/           # Model factories
└── migrations/          # Database migrations

tests/
├── Feature/             # Integration tests
└── Unit/                # Unit tests
```

## Deployment Checklist

Before deploying new CRUD entities:

1. ✅ Run migrations: `php artisan migrate`
2. ✅ Run tests: `php artisan test`
3. ✅ Format code: `vendor/bin/pint`
4. ✅ Check for TODO comments
5. ✅ Verify service bindings in AppServiceProvider
6. ✅ Test all endpoints manually
7. ✅ Verify frontend integration (if applicable)
8. ✅ Check authorization rules (when implemented)

## Common Pitfalls

### Avoid These Mistakes
- ❌ Creating repositories/services without interfaces
- ❌ Putting business logic in controllers
- ❌ Forgetting to register service bindings
- ❌ Not using soft deletes consistently
- ❌ Missing validation for foreign keys
- ❌ Hardcoding relationship loading instead of using $relations
- ❌ Creating new files when existing patterns should be followed
- ❌ Not following naming conventions
- ❌ Skipping the factory creation for testing