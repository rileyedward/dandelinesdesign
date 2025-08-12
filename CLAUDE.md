# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

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
The application follows a layered architecture pattern:

**Repository Pattern**: 
- All data access goes through repositories that extend `BaseRepository`
- Repositories implement specific interfaces (e.g., `ContactMessageRepositoryInterface`)
- Located in `app/Repositories/`

**Service Layer**:
- Business logic is encapsulated in services that extend `BaseService`
- Services use repositories for data access and handle relationship loading
- Located in `app/Services/`

**Controller Layer**:
- Controllers extend `BaseController` which provides standard CRUD operations
- Controllers use services and handle HTTP concerns
- Authorization is prepared but commented out (TODO items exist)
- Located in `app/Http/Controllers/`

**Key Base Classes**:
- `BaseController`: Provides standard store/update/destroy methods with request validation
- `BaseRepository`: Handles basic CRUD operations with Eloquent models
- `BaseService`: Manages business logic and eager loading of relationships

### Frontend Architecture (Vue 3 + Inertia)

**Components**: 
- Comprehensive UI component library in `resources/js/components/ui/`
- Components organized by category: forms, data, feedback, layout, navigation
- Each component has both `.vue` and `.ts` files for implementation and configuration

**Layout System**:
- Multiple layout types: auth, navbar, sidebar
- Located in `resources/js/layouts/`

**Tech Stack**:
- Vue 3 with Composition API
- TypeScript for type safety
- Inertia.js for SPA experience without API complexity
- TailwindCSS with custom UI components
- Reka UI component library
- Vite for build tooling

### Database
- SQLite database for development (`database/database.sqlite`)
- Migrations in `database/migrations/`
- Factories for testing in `database/factories/`

### Key Conventions
- All repositories must extend `BaseRepository` and implement corresponding interface
- All services must extend `BaseService` 
- Controllers should extend `BaseController` when following standard CRUD patterns
- Authorization policies are planned but not yet implemented (see TODO comments)
- Input filtering removes 'with' parameter from request data in base controller