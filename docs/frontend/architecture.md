# Frontend Architecture Overview

This document outlines the high-level architecture and design patterns used in the Dandelines Design frontend built with Vue 3, TypeScript, and Inertia.js.

## Architecture Philosophy

The frontend follows a **component-driven architecture** with clear separation of concerns:

- **Pages** handle route-level concerns and data fetching via Inertia.js
- **Components** encapsulate reusable UI logic and business domain concepts
- **Layouts** provide consistent page structure with configurable navigation
- **Types** ensure type safety across the entire application
- **Composables** manage shared reactive state and logic

## High-Level Structure

### Directory Organization

```
resources/js/
├── app.ts                 # Application entry point
├── ssr.ts                 # Server-side rendering setup
├── components/            # All Vue components
│   ├── ui/               # Reusable UI component library
│   ├── [entity]/         # Domain-specific components
│   └── common/           # Shared project components
├── layouts/              # Page layout templates
├── pages/                # Inertia.js page components
├── types/                # TypeScript definitions
├── composables/          # Vue composables
└── lib/                  # Utility functions
```

## Component Architecture

### Three-Tier Component System

1. **UI Components** (`components/ui/`)
   - Pure, reusable components
   - No business logic
   - Props-based API
   - Comprehensive TypeScript interfaces

2. **Domain Components** (`components/[entity]/`)
   - Business logic components
   - Entity-specific functionality
   - Form handling, data display, actions

3. **Common Components** (`components/common/`)
   - Project-specific shared components
   - Page headers, backgrounds, etc.
   - Not generic enough for UI library

### Component Structure Pattern

Each component follows a consistent structure:

```
component-name/
├── component-name.vue     # Template and script
└── component-name.ts      # TypeScript definitions
```

**Example:**
```typescript
// ui-button.ts
export interface UiButtonProps {
  variant?: 'primary' | 'secondary';
  size?: 'sm' | 'md' | 'lg';
  disabled?: boolean;
}

export interface UiButtonEmits {
  (event: 'click', e: MouseEvent): void;
}
```

```vue
<!-- ui-button.vue -->
<script setup lang="ts">
import type { UiButtonProps, UiButtonEmits } from './ui-button';

const props = defineProps<UiButtonProps>();
const emit = defineEmits<UiButtonEmits>();
</script>
```

## Page Architecture

### Inertia.js Integration

Pages receive data from Laravel controllers and render without API calls:

```php
// Laravel Controller
return inertia('store/store-index', [
    'products' => $products,
    'categories' => $categories,
]);
```

```vue
<!-- resources/js/pages/store/store-index.vue -->
<script setup lang="ts">
import type { Product, Category } from '@/types';

interface Props {
  products: Product[];
  categories: Category[];
}

defineProps<Props>();
</script>
```

### Layout Selection

Pages can specify layouts explicitly or use defaults:

```vue
<script setup lang="ts">
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
</script>

<template>
  <navbar-layout>
    <!-- Page content -->
  </navbar-layout>
</template>
```

## State Management

### Composables for Shared State

Instead of Vuex/Pinia, we use composables for reactive state:

```typescript
// useCart.ts
export function useCart() {
  const items = ref<CartItem[]>([]);
  
  const addItem = (product: Product) => {
    // Cart logic
  };
  
  return { items, addItem };
}
```

### Form State with Inertia

Forms use Inertia's `useForm` for automatic validation and submission:

```vue
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
});

const submit = () => {
  form.post(route('contact.store'));
};
</script>
```

## Type Safety

### Comprehensive Type System

All data structures are typed in `resources/js/types/`:

```typescript
// types/product.ts
export interface Product {
  id: number;
  name: string;
  price: number;
  category: Category;
  is_active: boolean;
  created_at: string;
  updated_at: string;
}
```

### Component Type Definitions

Each component has dedicated type files for props and emits:

- Props interfaces define component inputs
- Emits interfaces define event signatures
- Ensures compile-time safety and IDE support

## Styling Architecture

### TailwindCSS Integration

- Utility-first CSS approach
- Consistent design system
- Responsive design patterns
- Component-scoped styles when needed

### Design System

- Consistent color palette
- Typography scale
- Spacing system
- Component variants

## Development Patterns

### Composition API

All components use Vue 3 Composition API with `<script setup>`:

```vue
<script setup lang="ts">
import { ref, computed } from 'vue';

const count = ref(0);
const doubled = computed(() => count.value * 2);
</script>
```

### Reactive Forms

Forms are reactive and provide real-time validation:

```vue
<script setup lang="ts">
const name = ref('');
const errors = ref<Record<string, string>>({});

const isValid = computed(() => name.value.length > 0);
</script>
```

## Build and Development

### Vite Configuration

- Fast hot module replacement
- TypeScript compilation
- Asset optimization
- SSR support

### Development Commands

```bash
npm run dev      # Development server
npm run build    # Production build
npm run lint     # Code linting
npm run format   # Code formatting
```

## Next Steps

- Review [Component System](component-system.md) for detailed component patterns
- Study [UI Components](ui-components.md) for available components
- Check [Layout System](layout-system.md) for navigation patterns