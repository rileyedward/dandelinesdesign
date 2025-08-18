# Component System

This document outlines the Vue 3 component architecture patterns used throughout the Dandelines Design application, including the .vue/.ts separation pattern, component organization, and TypeScript integration.

## Component Architecture Philosophy

### Separation of Concerns

The component system follows a clear separation between:

- **Template Logic** (`.vue` files) - Vue templates, script setup, and component logic
- **Type Definitions** (`.ts` files) - TypeScript interfaces, props, and emits definitions
- **Business Logic** - Kept in composables and services
- **UI Logic** - Encapsulated within components

### Component Categories

1. **UI Components** (`components/ui/`) - Pure, reusable interface elements
2. **Business Components** (`components/[entity]/`) - Domain-specific functionality
3. **Common Components** (`components/common/`) - Shared project components
4. **Page Components** (`pages/`) - Route-level components

## Component Structure Pattern

### Standard Directory Layout

Every component follows this consistent structure:

```
component-name/
├── component-name.vue         # Vue component (template + script)
└── component-name.ts          # TypeScript definitions
```

### TypeScript Definitions Pattern

**File: `component-name.ts`**

```typescript
import type { LucideIcon } from 'lucide-vue-next';

// Props interface - defines component inputs
export interface ComponentNameProps {
  title?: string;
  variant?: 'primary' | 'secondary';
  disabled?: boolean;
  icon?: LucideIcon;
}

// Emits interface - defines component events
export interface ComponentNameEmits {
  (event: 'click', payload: any): void;
  (event: 'change', value: string): void;
}

// Additional types specific to this component
export interface ComponentNameData {
  id: number;
  name: string;
  status: 'active' | 'inactive';
}
```

### Vue Component Pattern

**File: `component-name.vue`**

```vue
<script setup lang="ts">
import { computed, ref } from 'vue';
import type { 
  ComponentNameProps as Props, 
  ComponentNameEmits as Emits 
} from './component-name';

// Props with defaults
const props = withDefaults(defineProps<Props>(), {
  variant: 'primary',
  disabled: false,
});

// Emits definition
const emit = defineEmits<Emits>();

// Component state
const isLoading = ref(false);

// Computed properties
const componentClasses = computed(() => ({
  'component--primary': props.variant === 'primary',
  'component--secondary': props.variant === 'secondary',
  'component--disabled': props.disabled,
}));

// Methods
const handleClick = (event: MouseEvent) => {
  if (!props.disabled) {
    emit('click', event);
  }
};
</script>

<template>
  <div :class="componentClasses">
    <component :is="icon" v-if="icon" />
    <span>{{ title }}</span>
    <slot />
  </div>
</template>

<style scoped>
/* Component-specific styles */
.component--disabled {
  @apply opacity-50 pointer-events-none;
}
</style>
```

## UI Components Architecture

### Pure Component Pattern

UI components are pure, reusable elements without business logic:

**Example: `ui-button.ts`**

```typescript
import type { LucideIcon } from 'lucide-vue-next';

export interface UiButtonProps {
  type?: 'button' | 'submit' | 'reset';
  label?: string;
  variant?: 'primary' | 'secondary' | 'outline' | 'success' | 'danger';
  size?: 'sm' | 'md' | 'lg' | 'xl';
  fullWidth?: boolean;
  prefixIcon?: LucideIcon;
  suffixIcon?: LucideIcon;
  disabled?: boolean;
  loading?: boolean;
}

export interface UiButtonEmits {
  (event: 'click', e: MouseEvent): void;
  (event: 'focus', e: FocusEvent): void;
  (event: 'blur', e: FocusEvent): void;
}
```

**Example: `ui-button.vue`**

```vue
<script setup lang="ts">
import { computed } from 'vue';
import type { UiButtonProps as Props, UiButtonEmits as Emits } from './ui-button';

const props = withDefaults(defineProps<Props>(), {
  type: 'button',
  variant: 'primary',
  size: 'md',
  fullWidth: false,
  disabled: false,
  loading: false,
});

const emit = defineEmits<Emits>();

const buttonClasses = computed<string>(() => {
  const classes: string[] = [
    'inline-flex items-center justify-center gap-2',
    'font-medium border border-transparent',
    'transition-colors duration-200',
    'focus-visible:outline-none focus-visible:ring-2',
    'disabled:pointer-events-none disabled:opacity-50',
  ];

  // Variant classes
  switch (props.variant) {
    case 'primary':
      classes.push('bg-purple-500 text-white hover:bg-purple-600');
      break;
    case 'secondary':
      classes.push('bg-gray-500 text-white hover:bg-gray-600');
      break;
    // ... other variants
  }

  // Size classes
  switch (props.size) {
    case 'sm':
      classes.push('h-8 px-3 text-xs rounded-md');
      break;
    case 'md':
      classes.push('h-9 px-4 text-sm rounded-md');
      break;
    // ... other sizes
  }

  if (props.fullWidth) {
    classes.push('w-full');
  }

  return classes.join(' ');
});
</script>

<template>
  <button
    :type="type"
    :class="buttonClasses"
    :disabled="disabled || loading"
    @click="emit('click', $event)"
    @focus="emit('focus', $event)"
    @blur="emit('blur', $event)"
  >
    <component
      :is="prefixIcon"
      v-if="prefixIcon && !loading"
      class="h-4 w-4"
    />
    
    <div
      v-if="loading"
      class="h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent"
    />
    
    <span v-if="label || $slots.default">
      <slot>{{ label }}</slot>
    </span>
    
    <component
      :is="suffixIcon"
      v-if="suffixIcon && !loading"
      class="h-4 w-4"
    />
  </button>
</template>
```

## Business Components Architecture

### Domain-Specific Components

Business components handle entity-specific logic and integrate with the backend:

**Example: `category-form.ts`**

```typescript
import type { Category } from '@/types/category';

export interface CategoryFormProps {
  category?: Category;              // Optional for create forms
  processing?: boolean;             // Form submission state
  errors?: Record<string, string>;  // Validation errors
}

export interface CategoryFormEmits {
  (event: 'submit', category: Partial<Category>): void;
  (event: 'cancel'): void;
  (event: 'delete'): void;
}
```

**Example: `category-form.vue`**

```vue
<script setup lang="ts">
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import { computed, ref } from 'vue';
import type { CategoryFormProps as Props, CategoryFormEmits as Emits } from './category-form';

const props = withDefaults(defineProps<Props>(), {
  processing: false,
  errors: () => ({}),
});

const emit = defineEmits<Emits>();

// Form state
const name = ref(props.category?.name || '');
const slug = ref(props.category?.slug || '');
const description = ref(props.category?.description || '');
const isActive = ref(props.category?.is_active ?? true);

// Computed properties
const isEditing = computed(() => !!props.category);

// Methods
const handleSubmit = () => {
  emit('submit', {
    name: name.value,
    slug: slug.value,
    description: description.value,
    is_active: isActive.value,
  });
};
</script>

<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <div class="space-y-4">
      <ui-input
        v-model="name"
        label="Name"
        :error-text="errors.name"
        :disabled="processing"
        required
        full-width
      />
      
      <ui-input
        v-model="slug"
        label="Slug"
        :error-text="errors.slug"
        :disabled="processing"
        required
        full-width
      />
    </div>

    <div class="flex justify-end space-x-3">
      <ui-button
        v-if="isEditing"
        type="button"
        variant="danger"
        @click="emit('delete')"
      />
      <ui-button
        label="Cancel"
        type="button"
        variant="secondary"
        @click="emit('cancel')"
      />
      <ui-button
        label="Save"
        type="submit"
        variant="primary"
        :loading="processing"
      />
    </div>
  </form>
</template>
```

## Component Organization Patterns

### Entity-Based Organization

Components are organized by business entity:

```
components/
├── category/
│   ├── category-banner/          # Display component
│   ├── category-form/            # Form component
│   ├── category-list/            # List component
│   ├── category-create-modal/    # Create wrapper
│   └── category-update-modal/    # Update wrapper
├── product/
│   ├── product-banner/
│   ├── product-info/
│   └── product-list/
└── order/
    ├── order-banner/
    ├── order-info/
    └── order-line-items/
```

### Component Types by Function

#### Banner Components
Display entity information in a summary format:

```typescript
// product-banner.ts
export interface ProductBannerProps {
  product: Product;
  showActions?: boolean;
}

export interface ProductBannerEmits {
  (event: 'edit', product: Product): void;
  (event: 'delete', product: Product): void;
}
```

#### List Components
Display collections of entities:

```typescript
// product-list.ts
export interface ProductListProps {
  products: Product[];
  loading?: boolean;
  selectable?: boolean;
}

export interface ProductListEmits {
  (event: 'select', products: Product[]): void;
  (event: 'edit', product: Product): void;
  (event: 'delete', product: Product): void;
}
```

#### Info Components
Detailed entity information display:

```typescript
// product-info.ts
export interface ProductInfoProps {
  product: Product;
  editable?: boolean;
}

export interface ProductInfoEmits {
  (event: 'edit'): void;
  (event: 'update', data: Partial<Product>): void;
}
```

## Advanced Component Patterns

### Compound Components

Components that work together as a system:

```vue
<!-- accordion-example.vue -->
<template>
  <ui-accordion>
    <ui-accordion-item value="item1">
      <ui-accordion-trigger>Section 1</ui-accordion-trigger>
      <ui-accordion-content>Content 1</ui-accordion-content>
    </ui-accordion-item>
    
    <ui-accordion-item value="item2">
      <ui-accordion-trigger>Section 2</ui-accordion-trigger>
      <ui-accordion-content>Content 2</ui-accordion-content>
    </ui-accordion-item>
  </ui-accordion>
</template>
```

### Render Props Pattern

Components that accept render functions:

```vue
<template>
  <data-table
    :data="products"
    :columns="columns"
  >
    <template #cell-actions="{ row }">
      <ui-button @click="editProduct(row)">Edit</ui-button>
      <ui-button variant="danger" @click="deleteProduct(row)">Delete</ui-button>
    </template>
  </data-table>
</template>
```

### Higher-Order Components

Wrapper components that enhance functionality:

```vue
<!-- with-loading.vue -->
<script setup lang="ts">
interface Props {
  loading: boolean;
}

const props = defineProps<Props>();
</script>

<template>
  <div class="relative">
    <div v-if="loading" class="absolute inset-0 bg-gray-100 opacity-50">
      <div class="flex justify-center items-center h-full">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-500" />
      </div>
    </div>
    <slot />
  </div>
</template>
```

## TypeScript Integration Patterns

### Generic Components

Components that work with different data types:

```typescript
// generic-list.ts
export interface GenericListProps<T> {
  items: T[];
  keyField: keyof T;
  displayField: keyof T;
  selectable?: boolean;
}

export interface GenericListEmits<T> {
  (event: 'select', item: T): void;
  (event: 'selectMultiple', items: T[]): void;
}
```

### Conditional Props

Props that depend on other props:

```typescript
// conditional-button.ts
interface BaseButtonProps {
  label: string;
  variant: 'primary' | 'secondary';
}

interface LoadingButtonProps extends BaseButtonProps {
  loading: true;
  onClick?: never;  // Cannot have onClick when loading
}

interface InteractiveButtonProps extends BaseButtonProps {
  loading?: false;
  onClick: (e: MouseEvent) => void;
}

export type ConditionalButtonProps = LoadingButtonProps | InteractiveButtonProps;
```

### Type Guards

Runtime type checking for component props:

```typescript
// type-guards.ts
export function isProduct(item: any): item is Product {
  return item && typeof item.id === 'number' && typeof item.name === 'string';
}

// Usage in component
<script setup lang="ts">
const validateProps = () => {
  if (props.item && !isProduct(props.item)) {
    console.warn('Invalid product data provided');
  }
};
</script>
```

## Slot Patterns

### Named Slots

Components with specific content areas:

```vue
<!-- ui-card.vue -->
<template>
  <div class="card">
    <header v-if="$slots.header" class="card-header">
      <slot name="header" />
    </header>
    
    <main class="card-body">
      <slot />
    </main>
    
    <footer v-if="$slots.footer" class="card-footer">
      <slot name="footer" />
    </footer>
  </div>
</template>
```

### Scoped Slots

Slots that pass data to parent:

```vue
<!-- data-table.vue -->
<template>
  <table>
    <tbody>
      <tr v-for="row in data" :key="row.id">
        <td v-for="column in columns" :key="column.key">
          <slot
            :name="`cell-${column.key}`"
            :row="row"
            :column="column"
            :value="row[column.key]"
          >
            {{ row[column.key] }}
          </slot>
        </td>
      </tr>
    </tbody>
  </table>
</template>
```

## Performance Optimization

### Lazy Loading

Components loaded only when needed:

```vue
<script setup lang="ts">
import { defineAsyncComponent } from 'vue';

const HeavyComponent = defineAsyncComponent(() =>
  import('@/components/heavy-component/heavy-component.vue')
);
</script>
```

### Memoization

Expensive computations cached:

```vue
<script setup lang="ts">
import { computed, ref } from 'vue';

const expensiveData = ref([]);
const processedData = computed(() => {
  // Expensive computation only runs when expensiveData changes
  return expensiveData.value.map(item => processItem(item));
});
</script>
```

### Event Handler Optimization

Stable event handlers to prevent unnecessary re-renders:

```vue
<script setup lang="ts">
import { ref } from 'vue';

const items = ref([]);

// Stable handler - won't cause child re-renders
const handleItemClick = (item: Item) => {
  // Handle click
};
</script>

<template>
  <item-component
    v-for="item in items"
    :key="item.id"
    :item="item"
    @click="handleItemClick"
  />
</template>
```

## Testing Patterns

### Component Testing Setup

```typescript
// category-form.test.ts
import { mount } from '@vue/test-utils';
import CategoryForm from './category-form.vue';
import type { Category } from '@/types/category';

describe('CategoryForm', () => {
  const mockCategory: Category = {
    id: 1,
    name: 'Test Category',
    slug: 'test-category',
    description: 'Test description',
    is_active: true,
  };

  it('renders with initial data', () => {
    const wrapper = mount(CategoryForm, {
      props: { category: mockCategory }
    });

    expect(wrapper.find('[data-test="name-input"]').element.value)
      .toBe(mockCategory.name);
  });

  it('emits submit event with form data', async () => {
    const wrapper = mount(CategoryForm);
    
    await wrapper.find('form').trigger('submit');
    
    expect(wrapper.emitted('submit')).toBeTruthy();
  });
});
```

## Best Practices

### Component Design

1. **Single Responsibility** - Each component has one clear purpose
2. **Props Down, Events Up** - Data flows down, events bubble up
3. **Composition over Inheritance** - Use composables for shared logic
4. **Type Everything** - Full TypeScript coverage for all props and emits

### File Organization

1. **Consistent Structure** - Always pair .vue with .ts files
2. **Named Exports** - Use named interfaces for better IDE support
3. **Co-location** - Keep related files close together
4. **Index Files** - Use index.ts for clean imports when needed

### Performance

1. **Lazy Loading** - Async components for large features
2. **Memoization** - Cache expensive computations
3. **Event Delegation** - Minimize event handlers
4. **Bundle Splitting** - Separate vendor and app code

### Maintainability

1. **Documentation** - Comment complex logic
2. **Testing** - Unit tests for all components
3. **Refactoring** - Regular cleanup and optimization
4. **Consistency** - Follow established patterns

This component system provides a robust foundation for building scalable, maintainable, and type-safe Vue applications with clear separation of concerns and excellent developer experience.