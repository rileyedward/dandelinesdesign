# Frontend Best Practices

This document outlines the coding standards, development patterns, and best practices used throughout the Dandelines Design Vue.js frontend application.

## Code Organization

### File Structure Standards

#### Component Organization
```
components/
├── ui/                    # Reusable UI components
│   ├── forms/            # Form controls
│   ├── layout/           # Layout components
│   ├── navigation/       # Navigation components
│   └── feedback/         # User feedback components
├── [entity]/             # Business domain components
│   ├── [entity]-form/    # Form components
│   ├── [entity]-list/    # List components
│   ├── [entity]-modal/   # Modal wrappers
│   └── [entity]-drawer/  # Drawer wrappers
└── common/               # Shared project components
```

#### Component Files Pattern
Every component follows the same file structure:
```
component-name/
├── component-name.vue    # Vue component
└── component-name.ts     # TypeScript definitions
```

### Import Standards

#### Import Order
Organize imports in this specific order:
```vue
<script setup lang="ts">
// 1. Vue core imports
import { ref, computed, watch, onMounted } from 'vue';

// 2. External library imports
import { useForm } from '@inertiajs/vue3';
import { Plus, Edit, Trash2 } from 'lucide-vue-next';

// 3. Internal component imports
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';

// 4. Type imports (always use 'import type')
import type { Product, Category } from '@/types';
import type { ComponentProps, ComponentEmits } from './component-name';

// 5. Composable imports
import { useCart } from '@/composables/useCart';
</script>
```

#### Path Aliases
Always use path aliases for cleaner imports:
```typescript
// ✅ Good
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import type { Product } from '@/types/product';

// ❌ Bad
import UiButton from '../../../components/ui/forms/button/ui-button.vue';
import type { Product } from '../../../../types/product';
```

## Component Development

### Component Design Principles

#### Single Responsibility
Each component should have one clear purpose:
```vue
<!-- ✅ Good - Single purpose -->
<script setup lang="ts">
// ProductCard only displays product information
</script>

<!-- ❌ Bad - Multiple responsibilities -->
<script setup lang="ts">
// Component that displays product, handles cart, and manages inventory
</script>
```

#### Props Down, Events Up
Data flows down through props, events bubble up:
```vue
<script setup lang="ts">
// ✅ Good - Clear data flow
const props = defineProps<{
  products: Product[];
  loading: boolean;
}>();

const emit = defineEmits<{
  (e: 'select', product: Product): void;
  (e: 'edit', product: Product): void;
}>();
</script>
```

### TypeScript Integration

#### Always Define Interfaces
Every component should have TypeScript interfaces:
```typescript
// component-name.ts
export interface ComponentNameProps {
  title: string;
  items: Item[];
  loading?: boolean;
}

export interface ComponentNameEmits {
  (event: 'save', data: any): void;
  (event: 'cancel'): void;
}
```

#### Use Strict Typing
Avoid `any` types in favor of specific interfaces:
```typescript
// ✅ Good
interface ProductFormData {
  name: string;
  price: number;
  categoryId?: number;
}

// ❌ Bad
const formData: any = {
  name: 'Product',
  price: 100,
};
```

### Component Template Standards

#### Template Structure
Follow consistent template organization:
```vue
<template>
  <!-- 1. Main container with semantic element -->
  <section class="product-list">
    
    <!-- 2. Header/title section -->
    <header class="product-list__header">
      <h2>{{ title }}</h2>
      <ui-button @click="handleCreate">Add Product</ui-button>
    </header>
    
    <!-- 3. Loading/error states -->
    <div v-if="loading" class="product-list__loading">
      Loading...
    </div>
    
    <!-- 4. Main content -->
    <div v-else class="product-list__content">
      <article
        v-for="product in products"
        :key="product.id"
        class="product-card"
      >
        <!-- Product content -->
      </article>
    </div>
    
    <!-- 5. Footer/actions -->
    <footer v-if="showPagination" class="product-list__footer">
      <!-- Pagination -->
    </footer>
    
  </section>
</template>
```

#### Conditional Rendering
Use clear conditional rendering patterns:
```vue
<template>
  <!-- ✅ Good - Clear loading states -->
  <div v-if="loading" class="spinner">Loading...</div>
  <div v-else-if="error" class="error">{{ error }}</div>
  <div v-else-if="items.length === 0" class="empty-state">No items found</div>
  <div v-else class="content">
    <!-- Main content -->
  </div>

  <!-- ✅ Good - Conditional attributes -->
  <ui-button
    :disabled="processing"
    :loading="processing"
    @click="handleSubmit"
  >
    Save
  </ui-button>
</template>
```

## State Management

### Reactive Data Patterns

#### Use Composition API Consistently
Always use Composition API with `<script setup>`:
```vue
<script setup lang="ts">
import { ref, computed } from 'vue';

// ✅ Good - Composition API
const count = ref(0);
const doubled = computed(() => count.value * 2);

// Define reactive state clearly
const formData = ref({
  name: '',
  email: '',
});
</script>
```

#### Computed Properties for Derived State
Use computed properties for calculated values:
```vue
<script setup lang="ts">
const products = ref<Product[]>([]);
const searchQuery = ref('');

// ✅ Good - Computed for filtering
const filteredProducts = computed(() => {
  if (!searchQuery.value) return products.value;
  return products.value.filter(product => 
    product.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// ✅ Good - Computed for UI state
const hasProducts = computed(() => products.value.length > 0);
const isEmpty = computed(() => products.value.length === 0);
</script>
```

### Form Handling

#### Inertia Form Pattern
Use Inertia's `useForm` for all form submissions:
```vue
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  message: '',
});

const handleSubmit = () => {
  form.post(route('contact.store'), {
    onSuccess: () => {
      // Success handling
      form.reset();
    },
    onError: (errors) => {
      // Error handling is automatic via form.errors
    },
  });
};
</script>

<template>
  <form @submit.prevent="handleSubmit">
    <ui-input
      v-model="form.name"
      :error-text="form.errors.name"
      :disabled="form.processing"
    />
    
    <ui-button
      type="submit"
      :loading="form.processing"
      :disabled="form.processing"
    >
      Submit
    </ui-button>
  </form>
</template>
```

## Styling Standards

### CSS Organization

#### Component-Scoped Styles
Use scoped styles for component-specific styling:
```vue
<template>
  <div class="product-card">
    <h3 class="product-card__title">{{ product.name }}</h3>
    <p class="product-card__price">${{ product.price }}</p>
  </div>
</template>

<style scoped>
.product-card {
  @apply border rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow;
}

.product-card__title {
  @apply text-lg font-semibold text-gray-900;
}

.product-card__price {
  @apply text-xl font-bold text-purple-600;
}
</style>
```

#### TailwindCSS Conventions
Follow consistent TailwindCSS patterns:
```vue
<template>
  <!-- ✅ Good - Consistent spacing and layout classes -->
  <div class="flex items-center justify-between p-6 bg-white rounded-lg shadow-sm">
    <h2 class="text-xl font-semibold text-gray-900">{{ title }}</h2>
    <ui-button variant="primary" size="sm">Action</ui-button>
  </div>

  <!-- ✅ Good - Responsive design -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Grid items -->
  </div>

  <!-- ✅ Good - State-based classes -->
  <div :class="[
    'transition-colors duration-200',
    isActive ? 'bg-purple-50 border-purple-200' : 'bg-gray-50 border-gray-200',
    'border rounded-lg p-4'
  ]">
    <!-- Content -->
  </div>
</template>
```

### Class Binding Patterns

#### Dynamic Classes
Use computed properties for complex class logic:
```vue
<script setup lang="ts">
const buttonClasses = computed(() => [
  'btn',
  `btn--${props.variant}`,
  `btn--${props.size}`,
  {
    'btn--loading': props.loading,
    'btn--disabled': props.disabled,
    'btn--full-width': props.fullWidth,
  }
]);
</script>

<template>
  <button :class="buttonClasses">
    {{ label }}
  </button>
</template>
```

## Performance Optimization

### Component Optimization

#### Lazy Loading
Use async components for large features:
```vue
<script setup lang="ts">
import { defineAsyncComponent } from 'vue';

// ✅ Good - Lazy load heavy components
const HeavyChart = defineAsyncComponent(() => 
  import('@/components/ui/data/chart/ui-chart.vue')
);
</script>

<template>
  <Suspense>
    <template #default>
      <HeavyChart :data="chartData" />
    </template>
    <template #fallback>
      <div class="flex justify-center p-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-500" />
      </div>
    </template>
  </Suspense>
</template>
```

#### Memoization
Cache expensive computations:
```vue
<script setup lang="ts">
import { computed, ref } from 'vue';

const largeDataset = ref<Item[]>([]);
const searchQuery = ref('');

// ✅ Good - Memoized expensive filtering
const filteredItems = computed(() => {
  if (!searchQuery.value) return largeDataset.value;
  
  // This only runs when dependencies change
  return largeDataset.value.filter(item => 
    item.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>
```

### Event Handling

#### Stable Event Handlers
Prevent unnecessary child re-renders:
```vue
<script setup lang="ts">
import { ref } from 'vue';

const items = ref<Item[]>([]);

// ✅ Good - Stable handler reference
const handleItemClick = (item: Item) => {
  console.log('Clicked:', item.name);
};

// ✅ Good - Use event delegation when possible
const handleListClick = (event: Event) => {
  const target = event.target as HTMLElement;
  const itemId = target.dataset.itemId;
  if (itemId) {
    const item = items.value.find(i => i.id === itemId);
    if (item) handleItemClick(item);
  }
};
</script>
```

## Testing Standards

### Component Testing

#### Test Structure
Organize tests consistently:
```typescript
// ProductCard.test.ts
import { mount } from '@vue/test-utils';
import ProductCard from './ProductCard.vue';
import type { Product } from '@/types/product';

describe('ProductCard', () => {
  const mockProduct: Product = {
    id: 1,
    name: 'Test Product',
    price: 99.99,
    // ... other properties
  };

  describe('rendering', () => {
    it('displays product name', () => {
      const wrapper = mount(ProductCard, {
        props: { product: mockProduct }
      });

      expect(wrapper.text()).toContain(mockProduct.name);
    });
  });

  describe('interactions', () => {
    it('emits edit event when edit button clicked', async () => {
      const wrapper = mount(ProductCard, {
        props: { product: mockProduct }
      });

      await wrapper.find('[data-test="edit-button"]').trigger('click');

      expect(wrapper.emitted('edit')).toBeTruthy();
      expect(wrapper.emitted('edit')?.[0]).toEqual([mockProduct]);
    });
  });
});
```

### Test Data Attributes
Use test-specific data attributes:
```vue
<template>
  <div class="product-card">
    <h3 data-test="product-name">{{ product.name }}</h3>
    <button
      data-test="edit-button"
      @click="emit('edit', product)"
    >
      Edit
    </button>
  </div>
</template>
```

## Error Handling

### Component Error Boundaries

#### Error Handling in Components
Handle errors gracefully:
```vue
<script setup lang="ts">
import { ref, onErrorCaptured } from 'vue';

const error = ref<string | null>(null);
const loading = ref(false);

// Handle async errors
const handleAsyncOperation = async () => {
  try {
    loading.value = true;
    error.value = null;
    
    await someAsyncOperation();
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'An error occurred';
  } finally {
    loading.value = false;
  }
};

// Capture child component errors
onErrorCaptured((err, instance, info) => {
  console.error('Component error:', err, info);
  error.value = 'Something went wrong';
  return false; // Prevent error from propagating
});
</script>

<template>
  <div v-if="error" class="error-state">
    <ui-alert variant="error" :title="error" />
    <ui-button @click="handleAsyncOperation">Retry</ui-button>
  </div>
  
  <div v-else-if="loading" class="loading-state">
    Loading...
  </div>
  
  <div v-else>
    <!-- Normal content -->
  </div>
</template>
```

## Accessibility

### ARIA and Semantic HTML

#### Use Semantic Elements
Choose appropriate HTML elements:
```vue
<template>
  <!-- ✅ Good - Semantic structure -->
  <article class="blog-post">
    <header>
      <h1>{{ post.title }}</h1>
      <time :datetime="post.created_at">{{ formatDate(post.created_at) }}</time>
    </header>
    
    <main>
      <p>{{ post.excerpt }}</p>
    </main>
    
    <footer>
      <nav aria-label="Post actions">
        <ui-button>Edit</ui-button>
        <ui-button>Delete</ui-button>
      </nav>
    </footer>
  </article>
</template>
```

#### ARIA Attributes
Include proper ARIA attributes:
```vue
<template>
  <button
    type="button"
    :aria-label="`Edit ${product.name}`"
    :aria-expanded="showMenu"
    :aria-controls="menuId"
    @click="toggleMenu"
  >
    Edit Product
  </button>
  
  <div
    :id="menuId"
    role="menu"
    :aria-hidden="!showMenu"
    class="dropdown-menu"
  >
    <!-- Menu items -->
  </div>
</template>
```

## Documentation Standards

### Component Documentation

#### JSDoc Comments
Document complex components:
```vue
<script setup lang="ts">
/**
 * ProductCard displays product information with actions
 * 
 * @example
 * <ProductCard
 *   :product="product"
 *   :editable="true"
 *   @edit="handleEdit"
 *   @delete="handleDelete"
 * />
 */
interface Props {
  /** Product data to display */
  product: Product;
  /** Whether edit/delete actions are shown */
  editable?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  editable: false,
});
</script>
```

### Code Comments

#### Inline Comments
Comment complex logic:
```vue
<script setup lang="ts">
// Calculate discount percentage based on compare_at_price
const discountPercentage = computed(() => {
  if (!product.value.compare_at_price || product.value.compare_at_price <= product.value.price) {
    return 0;
  }
  
  // Round to nearest whole number for display
  return Math.round(
    ((product.value.compare_at_price - product.value.price) / product.value.compare_at_price) * 100
  );
});
</script>
```

## Security Considerations

### XSS Prevention

#### Safe Data Binding
Always use Vue's built-in XSS protection:
```vue
<template>
  <!-- ✅ Good - Vue automatically escapes -->
  <p>{{ userInput }}</p>
  
  <!-- ⚠️ Use v-html only for trusted content -->
  <div v-html="trustedHtmlContent"></div>
  
  <!-- ✅ Good - Sanitize HTML if needed -->
  <div v-html="sanitizeHtml(htmlContent)"></div>
</template>
```

#### Input Validation
Validate all user inputs:
```vue
<script setup lang="ts">
const email = ref('');

const isValidEmail = computed(() => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email.value);
});

const handleSubmit = () => {
  if (!isValidEmail.value) {
    // Show error
    return;
  }
  
  // Proceed with form submission
};
</script>
```

This comprehensive set of best practices ensures consistent, maintainable, and high-quality Vue.js code throughout the Dandelines Design application.