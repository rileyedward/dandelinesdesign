# Architecture Overview

This Laravel application follows a layered architecture pattern with clear separation of concerns using the Repository and Service patterns.

## Architecture Layers

```
┌─────────────────┐
│   Frontend      │ ← Vue 3 + Inertia.js + TypeScript
│   (Inertia)     │
├─────────────────┤
│   Controllers   │ ← HTTP layer, extends BaseController
├─────────────────┤
│   Services      │ ← Business logic, extends BaseService
├─────────────────┤
│   Repositories  │ ← Data access, extends BaseRepository
├─────────────────┤
│   Models        │ ← Eloquent models with relationships
├─────────────────┤
│   Database      │ ← SQLite with migrations
└─────────────────┘
```

## Key Patterns

### Repository Pattern
- **Purpose**: Abstract data access logic from business logic
- **Implementation**: All repositories extend `BaseRepository` and implement specific interfaces
- **Location**: `app/Repositories/` with interfaces in `app/Contracts/`
- **Benefits**: Testable, swappable data sources, consistent API

### Service Pattern
- **Purpose**: Encapsulate business logic and coordinate between repositories
- **Implementation**: All services extend `BaseService` and implement specific interfaces
- **Location**: `app/Services/` with interfaces in `app/Contracts/`
- **Benefits**: Reusable business logic, relationship management, clean controllers

### Base Classes
- **BaseRepository**: Provides standard CRUD operations (`findById`, `store`, `update`, `delete`)
- **BaseService**: Adds relationship loading via `$relations` array
- **BaseController**: Handles HTTP concerns, validation, and standard CRUD endpoints

## Data Flow

1. **Request** → Controller receives HTTP request
2. **Validation** → Controller validates using FormRequest classes
3. **Service** → Controller delegates to service for business logic
4. **Repository** → Service uses repository for data operations
5. **Model** → Repository interacts with Eloquent models
6. **Response** → Controller returns Inertia response for frontend

## Frontend Integration

- **Inertia.js**: Provides SPA-like experience without API complexity
- **Vue 3**: Modern reactive frontend with Composition API
- **TypeScript**: Type safety throughout the frontend
- **Components**: Comprehensive UI library in `resources/js/components/ui/`

## Database Design

- **SQLite**: Lightweight database for development
- **Soft Deletes**: All entities support soft deletion
- **Timestamps**: Automatic created_at/updated_at tracking
- **Factories**: Test data generation with Faker

## Current Entities

The following CRUD entities are implemented:
- Contact Messages
- Blog Posts
- Quote Requests
- Testimonials
- Leads
- Categories
- Products (with basic ecommerce features)

Each follows the same architectural pattern for consistency and maintainability.