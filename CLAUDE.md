# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

**Dandelines Design** is a creative business platform offering event planning, floral arrangements, and custom artwork. This is a full-stack Laravel application with Vue 3 frontend, implementing comprehensive CRUD patterns with ecommerce functionality.

## Development Commands

### Backend (Laravel)
- `composer dev` - Start development servers (Laravel server, queue worker, logs, and Vite frontend)
- `composer dev:ssr` - Start development with SSR support
- `composer test` - Run all tests (clears config cache first, then runs tests)
- `php artisan serve` - Start Laravel development server
- `php artisan test` - Run PHP tests using Pest
- `vendor/bin/pint` - Format PHP code using Laravel Pint

### Frontend (Vue 3 + TypeScript)
- `npm run dev` - Start Vite development server
- `npm run build` - Build for production
- `npm run build:ssr` - Build with SSR support
- `npm run lint` - Lint and fix JavaScript/TypeScript/Vue files
- `npm run format` - Format frontend code with Prettier
- `npm run format:check` - Check code formatting

### Testing
- Use Pest for PHP testing (configured in `tests/` directory)
- Frontend tests are not currently configured

## Architecture Overview

This is a Laravel application with Vue 3 frontend using Inertia.js for seamless SPA-like experience without API complexity.

### Backend Architecture (Laravel)
The application follows a clean layered architecture with strict separation of concerns:

**Repository Pattern (Data Access Layer)**: 
- All data access goes through repositories that extend `BaseRepository`
- Repositories implement specific interfaces (e.g., `ContactMessageRepositoryInterface`)
- Located in `app/Repositories/` with interfaces in `app/Contracts/`
- **Actual Implementation**: Uses method signatures `findById(int $id)`, `store(array $data)`, `update(array $data, Model $model)`, `delete(Model $model)`

**Service Layer (Business Logic)**:
- Business logic is encapsulated in services that extend `BaseService`
- Services use repositories for data access and handle relationship loading via `$relations` array
- Located in `app/Services/` with interfaces in `app/Contracts/`
- **Actual Implementation**: Provides `getById()`, `store()`, `update()`, `delete()` with automatic relationship loading

**Controller Layer (HTTP Interface)**:
- Controllers extend `BaseController` which provides standard CRUD operations
- Controllers use services and handle HTTP concerns with automatic validation
- Authorization hooks prepared but commented out (TODO items exist)
- Located in `app/Http/Controllers/`
- **Actual Implementation**: Auto-resolves services, validates requests, filters input data

**Key Base Classes**:
- `BaseController`: Provides `store()`, `update()`, `destroy()` with automatic validation and service resolution
- `BaseRepository`: Handles `findById()`, `store()`, `update()`, `delete()` with Eloquent models
- `BaseService`: Manages relationship loading via configurable `$relations` array and business logic coordination

### Frontend Architecture (Vue 3 + Inertia)

**Component System**: 
- **Comprehensive UI Library**: `resources/js/components/ui/` with organized categories:
  - `forms/`: button, input, select, textarea, checkbox, radio, datepicker, file-upload, rich-text-editor
  - `data/`: accordion, chart, dropdown-menu, tooltip, table
  - `feedback/`: alert, modal, toast
  - `layout/`: card, container, drawer
  - `navigation/`: breadcrumbs, dropdown, menu, navbar, sidebar, tab
- **Business Components**: Domain-specific components in `resources/js/components/` organized by entity
- **TypeScript Integration**: Each component has both `.vue` and `.ts` files for implementation and type definitions

**Layout System**:
- **Multiple Layout Types**: auth, navbar, sidebar layouts in `resources/js/layouts/`
- **Responsive Design**: Mobile-first approach with TailwindCSS
- **State Management**: Composables for cart (`useCart`), notifications (`useNotifications`), sidebar (`useSidebarState`)

**Tech Stack & Patterns**:
- **Vue 3**: Composition API with `<script setup>` syntax
- **TypeScript**: Full type safety with custom type definitions in `resources/js/types/`
- **Inertia.js**: SSR-like experience without API complexity
- **TailwindCSS**: Utility-first CSS with custom design system
- **Vite**: Fast build tooling with hot module replacement
- **Pages**: File-based routing in `resources/js/pages/` matching Laravel routes

### Database Architecture
- **SQLite**: Lightweight database for development (`database/database.sqlite`)
- **Migrations**: Comprehensive schema in `database/migrations/` with soft deletes on all entities
- **Factories**: Rich test data generation in `database/factories/` with realistic faker data
- **Seeders**: Development data seeding for all entities
- **Observers**: Model observers for Contact Messages, Quote Requests, and Leads (automatic notification creation)
- **Relationships**: Well-defined relationships with proper foreign key constraints

### Key Conventions & Patterns
- **Interface-Based Architecture**: All repositories and services implement interfaces for dependency injection
- **Service Provider Bindings**: All interfaces bound to implementations in `AppServiceProvider`
- **Consistent Naming**: Entity naming follows Laravel conventions (singular models, plural tables)
- **Soft Deletes**: All entities support soft deletion via `SoftDeletes` trait
- **Request Validation**: Dedicated FormRequest classes with unique field handling for updates
- **Relationship Loading**: Services handle eager loading via configurable `$relations` arrays
- **Input Filtering**: Base controller automatically filters 'with' parameter to prevent injection
- **Authorization**: Policy structure prepared but not implemented (TODO comments throughout)
- **Type Safety**: Full TypeScript integration on frontend with custom type definitions

## Documentation

For comprehensive documentation on the CRUD architecture patterns, see the [`docs/`](docs/) directory:

- **[Complete Documentation](docs/README.md)** - Start here for full guides and examples
- **[Architecture Overview](docs/architecture.md)** - High-level system design and patterns
- **[CRUD Implementation Guide](docs/crud-guide.md)** - Step-by-step implementation instructions
- **[Complete Example](docs/example-implementation.md)** - Full walkthrough from migration to routes
- **[Base Classes](docs/base-classes.md)** - BaseRepository, BaseService, BaseController documentation
- **[Best Practices](docs/best-practices.md)** - Coding standards and conventions

## Working with Backend CRUD

This project implements a comprehensive CRUD pattern with service-repository architecture. When adding new entities, follow these steps:

### Creating New CRUD Entities

For each new entity (e.g., `BlogPost`), create these files in this order:

1. **Migration** (`database/migrations/`)
   - Create with `php artisan make:migration create_table_name_table`
   - Include `id`, appropriate columns, `timestamps()`, and `softDeletes()`

2. **Model** (`app/Models/`)
   - Extend `Model`, use `HasFactory` and `SoftDeletes` traits
   - Define `$table`, `$fillable`, and `$casts` properties
   - Follow naming convention: `BlogPost` model for `blog_posts` table

3. **Factory** (`database/factories/`)
   - For testing and seeding with faker data
   - Define realistic test data in `definition()` method

4. **Request** (`app/Http/Requests/`)
   - Handle validation for store/update operations
   - For unique fields (like email), use `Rule::unique()` with ignore for updates:
     ```php
     $entityId = $this->route('id');
     $isUpdate = $this->isMethod('patch') || $this->isMethod('put');
     Rule::unique('table', 'column')->ignore($isUpdate ? $entityId : null)
     ```

5. **Repository Interface** (`app/Contracts/`)
   - Extend `BaseRepositoryInterface`
   - Usually empty unless custom methods needed

6. **Repository** (`app/Repositories/`)
   - Extend `BaseRepository` and implement interface
   - Define `public string $model = ModelClass::class;`

7. **Service Interface** (`app/Contracts/`)
   - Extend `BaseServiceInterface`
   - Usually empty unless custom methods needed

8. **Service** (`app/Services/`)
   - Extend `BaseService` and implement interface
   - Inject repository interface in constructor
   - Define `$relations = []` for eager loading

9. **Controller** (`app/Http/Controllers/`)
   - Extend `BaseController`
   - Define `$modelClass`, `$serviceInterface`, `$requestClass`
   - Add `index()` method returning `inertia(null)` with TODO comment

10. **Routes** (`routes/admin.php`)
    - Add controller import and route group with standard CRUD routes
    - Follow pattern: prefix, name, and standard REST methods

11. **Register Services** (`app/Providers/AppServiceProvider.php`)
    - Bind repository and service interfaces to implementations

### Current CRUD Entities

The system implements 13 fully-featured CRUD entities with complete frontend/backend integration:

**Core Business Entities**:
- **Contact Messages**: Customer inquiries with observer-based notification creation
- **Quote Requests**: Service quotes for events/floral design with status workflow and observer notifications
- **Leads**: CRM lead management with status tracking and automatic notification generation
- **Testimonials**: Customer testimonials with featured/unfeatured status

**Content Management**:
- **Blog Posts**: Content management with title, slug, markdown content, and image integration
- **Newsletter Subscribers**: Email list management with unsubscribe functionality
- **Newsletter Templates**: Email template creation and sending system
- **Images**: File upload and management system with organized storage

**Ecommerce System**:
- **Categories**: Product organization with hierarchical structure
- **Products**: Complex ecommerce products with Stripe integration, pricing, inventory, and stock management
- **Orders**: Order management with line items, Stripe integration, and fulfillment workflow
- **Prices**: Stripe-integrated pricing system with current/historical price tracking
- **Line Items**: Order line items linking products to orders with quantities and pricing

**System Features**:
- **Notifications**: In-app notification system with read/unread states
- **Users**: Authentication and user management

### Base Class Implementation Details

**BaseRepository** (`app/Repositories/BaseRepository.php`):
- `findById(int $id): Model` - Uses `findOrFail()` for automatic 404 handling
- `store(array $data): Model` - Creates new model instance with mass assignment
- `update(array $data, Model $model): Model` - Updates existing model and returns fresh instance
- `delete(Model $model): bool` - Soft deletes model (returns boolean success)

**BaseService** (`app/Services/BaseService.php`):
- `getById(int $id, ?array $relations = null): Model` - Retrieves with relationship loading
- Automatic relationship resolution via `$relations` and `$commonRelations` arrays
- Relationship filtering to prevent unauthorized access
- Delegates CRUD operations to repository layer

**BaseController** (`app/Http/Controllers/BaseController.php`):
- Auto-resolves services via dependency injection using `$serviceInterface` property
- Validates requests using `$requestClass` with automatic FormRequest resolution
- `store()`, `update(int $id)`, `destroy(int $id)` methods with automatic validation
- Input filtering removes 'with' parameter to prevent relationship injection attacks
- Authorization hooks prepared (commented out) for future policy implementation

### Ecommerce System Architecture

**Stripe-Integrated Ecommerce** for creative business products:

**Categories** (`app/Models/Category.php`):
- Organize products into logical groups (Floral Arrangements, Design Prints, etc.)
- Fields: name, slug, description, is_active, sort_order
- One-to-many relationship with Products
- Admin interface with create/update modals and category filtering

**Products** (`app/Models/Product.php`):
- **Stripe Integration**: `stripe_product_id`, product import from Stripe catalog
- **Rich Metadata**: name, slug, description, images array, package_dimensions, weight, tax_code
- **Inventory Management**: `stock_quantity` with increment/decrement methods, stock scopes
- **Pricing System**: Relationships with Price model for current/historical pricing
- **Complex Relationships**: Category, Prices, Orders (via LineItems), LineItems
- **Business Logic**: `isInStock()`, `decrementStock()`, revenue calculation, formatted pricing
- **Scopes**: active, featured, by category, in stock, price range filtering

**Orders & Checkout** (`app/Models/Order.php`):
- **Stripe Integration**: Full checkout flow with Stripe session management
- **Line Items**: Complex order structure with products, quantities, pricing
- **Order Management**: Status tracking, fulfillment workflow, admin interface
- **Customer Data**: Billing/shipping information, order history

**Advanced Features**:
- **Stock Management**: Real-time inventory tracking with admin controls
- **Cart System**: Frontend cart with persistent state via composables
- **Product Import**: Automated Stripe product catalog synchronization
- **Price Management**: Multiple prices per product with current price designation
- **Order Processing**: Complete order lifecycle from cart to fulfillment