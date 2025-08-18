# Complete Implementation Example: Event Entity

This document provides a complete walkthrough of implementing a new CRUD entity from scratch. We'll create an "Event" entity for managing floral design events.

## Scenario

We need to create an Event entity with the following requirements:
- Events have a title, description, event date, location, and maximum attendees
- Events can be published/unpublished
- Events belong to a category
- We need full CRUD operations

## Step 1: Create Migration

```bash
php artisan make:migration create_events_table
```

**File:** `database/migrations/2024_01_01_000000_create_events_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('location');
            $table->datetime('event_date');
            $table->integer('max_attendees')->default(50);
            $table->decimal('price', 8, 2)->default(0);
            $table->boolean('is_published')->default(false);
            $table->string('image_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
```

## Step 2: Create Model

**File:** `app/Models/Event.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'location',
        'event_date',
        'max_attendees',
        'price',
        'is_published',
        'image_url',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'price' => 'decimal:2',
        'is_published' => 'boolean',
        'max_attendees' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });

        static::updating(function ($event) {
            if ($event->isDirty('title') && empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }
}
```

## Step 3: Create Factory

**File:** `database/factories/EventFactory.php`

```php
<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        
        return [
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => str($title)->slug(),
            'description' => $this->faker->paragraphs(3, true),
            'location' => $this->faker->address(),
            'event_date' => $this->faker->dateTimeBetween('+1 week', '+6 months'),
            'max_attendees' => $this->faker->numberBetween(10, 100),
            'price' => $this->faker->randomFloat(2, 0, 500),
            'is_published' => $this->faker->boolean(70),
            'image_url' => $this->faker->optional()->imageUrl(800, 600, 'events'),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }

    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_date' => $this->faker->dateTimeBetween('+1 day', '+3 months'),
        ]);
    }
}
```

## Step 4: Create Form Request

**File:** `app/Http/Requests/EventRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // TODO: Implement authorization
    }

    public function rules(): array
    {
        $eventId = $this->route('id');
        $isUpdate = $this->isMethod('patch') || $this->isMethod('put');

        return [
            'category_id' => 'required|exists:categories,id',
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('events', 'slug')->ignore($isUpdate ? $eventId : null),
            ],
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date|after:now',
            'max_attendees' => 'required|integer|min:1|max:1000',
            'price' => 'required|numeric|min:0|max:9999.99',
            'is_published' => 'boolean',
            'image_url' => 'nullable|url|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'title.required' => 'The event title is required.',
            'slug.unique' => 'This slug is already taken.',
            'event_date.after' => 'The event date must be in the future.',
            'max_attendees.min' => 'There must be at least 1 attendee spot.',
            'max_attendees.max' => 'Maximum attendees cannot exceed 1000.',
            'price.min' => 'Price cannot be negative.',
        ];
    }

    protected function prepareForValidation()
    {
        // Auto-generate slug if not provided
        if ($this->title && !$this->slug) {
            $this->merge([
                'slug' => str($this->title)->slug(),
            ]);
        }

        // Ensure boolean conversion for is_published
        if ($this->has('is_published')) {
            $this->merge([
                'is_published' => filter_var($this->is_published, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}
```

## Step 5: Create Repository Interface

**File:** `app/Contracts/EventRepositoryInterface.php`

```php
<?php

namespace App\Contracts;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

interface EventRepositoryInterface extends BaseRepositoryInterface
{
    public function findBySlug(string $slug): ?Event;
    
    public function getPublishedEvents(): Collection;
    
    public function getUpcomingEvents(int $limit = 10): Collection;
    
    public function getEventsByCategory(int $categoryId): Collection;
}
```

## Step 6: Create Repository

**File:** `app/Repositories/EventRepository.php`

```php
<?php

namespace App\Repositories;

use App\Contracts\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

class EventRepository extends BaseRepository implements EventRepositoryInterface
{
    public string $model = Event::class;

    public function findBySlug(string $slug): ?Event
    {
        return $this->model::where('slug', $slug)->first();
    }

    public function getPublishedEvents(): Collection
    {
        return $this->model::where('is_published', true)
            ->orderBy('event_date', 'asc')
            ->get();
    }

    public function getUpcomingEvents(int $limit = 10): Collection
    {
        return $this->model::where('is_published', true)
            ->where('event_date', '>', now())
            ->orderBy('event_date', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getEventsByCategory(int $categoryId): Collection
    {
        return $this->model::where('category_id', $categoryId)
            ->where('is_published', true)
            ->orderBy('event_date', 'asc')
            ->get();
    }
}
```

## Step 7: Create Service Interface

**File:** `app/Contracts/EventServiceInterface.php`

```php
<?php

namespace App\Contracts;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

interface EventServiceInterface extends BaseServiceInterface
{
    public function findBySlug(string $slug): ?Event;
    
    public function getPublishedEvents(): Collection;
    
    public function getUpcomingEvents(int $limit = 10): Collection;
    
    public function getEventsByCategory(int $categoryId): Collection;
    
    public function publishEvent(int $id): Event;
    
    public function unpublishEvent(int $id): Event;
}
```

## Step 8: Create Service

**File:** `app/Services/EventService.php`

```php
<?php

namespace App\Services;

use App\Contracts\EventRepositoryInterface;
use App\Contracts\EventServiceInterface;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

class EventService extends BaseService implements EventServiceInterface
{
    protected array $relations = ['category'];

    public function __construct(
        protected EventRepositoryInterface $repository
    ) {
        parent::__construct($repository);
    }

    public function findBySlug(string $slug): ?Event
    {
        $event = $this->repository->findBySlug($slug);
        
        if ($event && !empty($this->relations)) {
            $event->load($this->relations);
        }
        
        return $event;
    }

    public function getPublishedEvents(): Collection
    {
        $events = $this->repository->getPublishedEvents();
        
        if (!empty($this->relations)) {
            $events->load($this->relations);
        }
        
        return $events;
    }

    public function getUpcomingEvents(int $limit = 10): Collection
    {
        $events = $this->repository->getUpcomingEvents($limit);
        
        if (!empty($this->relations)) {
            $events->load($this->relations);
        }
        
        return $events;
    }

    public function getEventsByCategory(int $categoryId): Collection
    {
        $events = $this->repository->getEventsByCategory($categoryId);
        
        if (!empty($this->relations)) {
            $events->load($this->relations);
        }
        
        return $events;
    }

    public function publishEvent(int $id): Event
    {
        return $this->repository->update($id, ['is_published' => true]);
    }

    public function unpublishEvent(int $id): Event
    {
        return $this->repository->update($id, ['is_published' => false]);
    }

    public function store(array $data): Event
    {
        // Auto-generate slug if not provided
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = str($data['title'])->slug();
        }

        return parent::store($data);
    }

    public function update(int $id, array $data): Event
    {
        // Auto-generate slug if title changed but slug not provided
        if (!empty($data['title']) && empty($data['slug'])) {
            $data['slug'] = str($data['title'])->slug();
        }

        return parent::update($id, $data);
    }
}
```

## Step 9: Create Controller

**File:** `app/Http/Controllers/EventController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Contracts\EventServiceInterface;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Inertia\Response;

class EventController extends BaseController
{
    protected string $modelClass = Event::class;
    protected string $serviceInterface = EventServiceInterface::class;
    protected string $requestClass = EventRequest::class;

    public function index(): Response
    {
        // TODO: Implement index page with Inertia
        return inertia('Events/Index');
    }

    public function published(): JsonResponse
    {
        $events = $this->getService()->getPublishedEvents();
        return response()->json($events);
    }

    public function upcoming(int $limit = 10): JsonResponse
    {
        $events = $this->getService()->getUpcomingEvents($limit);
        return response()->json($events);
    }

    public function byCategory(int $categoryId): JsonResponse
    {
        $events = $this->getService()->getEventsByCategory($categoryId);
        return response()->json($events);
    }

    public function publish(int $id): JsonResponse
    {
        // TODO: Add authorization check
        $event = $this->getService()->publishEvent($id);
        return response()->json($event);
    }

    public function unpublish(int $id): JsonResponse
    {
        // TODO: Add authorization check
        $event = $this->getService()->unpublishEvent($id);
        return response()->json($event);
    }

    public function findBySlug(string $slug): JsonResponse
    {
        $event = $this->getService()->findBySlug($slug);
        
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        
        return response()->json($event);
    }
}
```

## Step 10: Add Routes

**File:** `routes/admin.php`

```php
use App\Http\Controllers\EventController;

Route::prefix('events')->name('events.')->group(function () {
    // Standard CRUD routes
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::post('/', [EventController::class, 'store'])->name('store');
    Route::get('/{id}', [EventController::class, 'show'])->name('show');
    Route::patch('/{id}', [EventController::class, 'update'])->name('update');
    Route::delete('/{id}', [EventController::class, 'destroy'])->name('destroy');
    
    // Custom routes
    Route::get('/published/list', [EventController::class, 'published'])->name('published');
    Route::get('/upcoming/{limit?}', [EventController::class, 'upcoming'])->name('upcoming');
    Route::get('/category/{categoryId}', [EventController::class, 'byCategory'])->name('by-category');
    Route::patch('/{id}/publish', [EventController::class, 'publish'])->name('publish');
    Route::patch('/{id}/unpublish', [EventController::class, 'unpublish'])->name('unpublish');
    Route::get('/slug/{slug}', [EventController::class, 'findBySlug'])->name('by-slug');
});
```

## Step 11: Register Services

**File:** `app/Providers/AppServiceProvider.php`

```php
public function register(): void
{
    // Add these bindings to existing bindings
    $this->app->bind(
        \App\Contracts\EventRepositoryInterface::class,
        \App\Repositories\EventRepository::class
    );

    $this->app->bind(
        \App\Contracts\EventServiceInterface::class,
        \App\Services\EventService::class
    );
}
```

## Step 12: Run Migration and Test

```bash
# Run the migration
php artisan migrate

# Run tests to ensure everything works
php artisan test

# Format the code
vendor/bin/pint
npm run format
```

## Usage Examples

### Creating Events
```php
// Via API
POST /admin/events
{
    "category_id": 1,
    "title": "Spring Floral Workshop",
    "description": "Learn to create beautiful spring arrangements",
    "location": "123 Garden St, Flower City",
    "event_date": "2024-04-15T14:00:00",
    "max_attendees": 25,
    "price": 75.00,
    "is_published": true
}
```

### Custom Endpoints
```php
// Get upcoming events
GET /admin/events/upcoming/5

// Get events by category
GET /admin/events/category/1

// Publish an event
PATCH /admin/events/1/publish

// Find by slug
GET /admin/events/slug/spring-floral-workshop
```

## Testing

Create a test file at `tests/Feature/EventTest.php`:

```php
<?php

use App\Models\Category;
use App\Models\Event;

test('can create an event', function () {
    $category = Category::factory()->create();
    
    $eventData = [
        'category_id' => $category->id,
        'title' => 'Test Event',
        'description' => 'A test event',
        'location' => 'Test Location',
        'event_date' => now()->addDays(30)->toISOString(),
        'max_attendees' => 50,
        'price' => 100.00,
        'is_published' => true,
    ];
    
    $response = $this->postJson('/admin/events', $eventData);
    
    $response->assertStatus(201);
    $this->assertDatabaseHas('events', [
        'title' => 'Test Event',
        'slug' => 'test-event',
    ]);
});
```

This complete example demonstrates how all the pieces work together to create a full CRUD implementation following the established patterns.