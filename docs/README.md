# Documentation

This directory contains comprehensive documentation for the Dandelines Design full-stack application architecture, covering both Laravel backend and Vue.js frontend patterns.

## Table of Contents

### Backend Documentation
1. **[Architecture Overview](backend/architecture.md)** - High-level overview of the layered architecture
2. **[CRUD Implementation Guide](backend/crud-guide.md)** - Step-by-step guide for implementing CRUD operations
3. **[Base Classes](backend/base-classes.md)** - Documentation for BaseRepository, BaseService, and BaseController
4. **[Complete Example](backend/example-implementation.md)** - Full walkthrough from migration to routes
5. **[Best Practices](backend/best-practices.md)** - Coding standards and conventions

### Frontend Documentation
1. **[Architecture Overview](frontend/architecture.md)** - Vue 3 + Inertia.js frontend structure and design patterns
2. **[Component System](frontend/component-system.md)** - Vue component patterns, .vue/.ts separation, and organization
3. **[UI Component Library](frontend/ui-components.md)** - Comprehensive UI component library documentation
4. **[Layout System](frontend/layout-system.md)** - Navbar/sidebar layouts with configuration-based approach
5. **[Form Patterns](frontend/form-patterns.md)** - CRUD forms, modals, drawers, and validation patterns
6. **[Type System](frontend/type-system.md)** - TypeScript integration and type definitions
7. **[Inertia Integration](frontend/inertia-integration.md)** - Server-side rendering with Inertia.js patterns
8. **[Best Practices](frontend/best-practices.md)** - Coding standards and development patterns

## Quick Start

### For Backend Development
Start with the [Backend Architecture Overview](backend/architecture.md) to understand the service-repository pattern, then follow the [CRUD Implementation Guide](backend/crud-guide.md) for hands-on implementation.

### For Frontend Development
Begin with the [Frontend Architecture Overview](frontend/architecture.md) to understand the Vue 3 component system, then explore the [Component System](frontend/component-system.md) and [UI Component Library](frontend/ui-components.md).

### For Full-Stack Development
1. Review both architecture overviews to understand the full system
2. Follow the backend CRUD guide to implement data layer
3. Use frontend form patterns to build corresponding UI components
4. Leverage Inertia.js for seamless server-client integration

## Technology Stack

### Backend
- **Laravel 11** with PHP 8.3+
- **SQLite** database with comprehensive migrations
- **Service-Repository Pattern** for clean architecture
- **Pest** for testing with realistic factories
- **Laravel Pint** for code formatting

### Frontend
- **Vue 3** with Composition API and `<script setup>` syntax
- **TypeScript** for full type safety
- **Inertia.js** for server-side rendering without API complexity
- **TailwindCSS** for utility-first styling
- **Vite** for fast development and build tooling

## Project Patterns

This documentation establishes reusable patterns for:

- **CRUD Operations** - Consistent backend implementation from database to controller
- **Component Architecture** - Scalable Vue.js component organization
- **Form Handling** - Type-safe forms with server validation integration  
- **Layout Management** - Configuration-driven navigation and page structure
- **Type Safety** - Comprehensive TypeScript integration across the stack

## Purpose

This documentation serves as a comprehensive guide for AI agents and developers working on similar Laravel + Vue.js + Inertia.js applications. It provides the complete picture from database design to user interface, establishing patterns that can be replicated across projects.
