# Frontend Documentation

This directory contains comprehensive documentation for the Vue 3 + Inertia.js frontend architecture used in Dandelines Design.

## Quick Reference

- **[Architecture Overview](architecture.md)** - High-level frontend structure and design patterns
- **[Component System](component-system.md)** - Vue component patterns, .vue/.ts separation, and organization
- **[UI Component Library](ui-components.md)** - Comprehensive UI component library documentation
- **[Layout System](layout-system.md)** - Navbar/sidebar layouts with configuration-based approach
- **[Form Patterns](form-patterns.md)** - CRUD forms, modals, drawers, and validation patterns
- **[Type System](type-system.md)** - TypeScript integration and type definitions
- **[Inertia Integration](inertia-integration.md)** - Server-side rendering with Inertia.js patterns
- **[Best Practices](best-practices.md)** - Coding standards and development patterns

## Technology Stack

- **Vue 3** with Composition API and `<script setup>`
- **TypeScript** for type safety and better development experience
- **Inertia.js** for SSR-like experience without API complexity
- **TailwindCSS** for utility-first styling
- **Vite** for fast development and build tooling
- **Lucide Vue Next** for consistent iconography

## Project Structure Overview

```
resources/js/
├── components/           # Business logic components
│   ├── ui/              # Reusable UI component library
│   ├── [entity]/        # Entity-specific components
│   └── common/          # Shared project components
├── layouts/             # Application layouts
├── pages/               # Inertia page components
├── types/               # TypeScript definitions
├── composables/         # Vue composables
└── lib/                 # Utility functions
```

## Getting Started

1. Read the [Architecture Overview](architecture.md) to understand the overall structure
2. Review [Component System](component-system.md) for component patterns
3. Study the [UI Component Library](ui-components.md) for available components
4. Check [Form Patterns](form-patterns.md) for CRUD implementation patterns

## Development Workflow

1. **New Features**: Start with page components in `pages/`
2. **Reusable Logic**: Extract to `components/[entity]/`
3. **UI Elements**: Use existing `components/ui/` or extend library
4. **Type Safety**: Define types in `types/` directory
5. **Layouts**: Choose appropriate layout from `layouts/`