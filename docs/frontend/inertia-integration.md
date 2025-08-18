# Inertia Integration

This document outlines how Inertia.js is integrated throughout the Dandelines Design application to provide server-side rendering capabilities with a single-page application experience.

## Inertia Architecture Overview

### Core Concept

Inertia.js eliminates the need for a separate API by allowing Laravel controllers to return Vue components directly:

```php
// Laravel Controller
return inertia('store/store-index', [
    'products' => $products,
    'categories' => $categories,
]);
```

```vue
<!-- Vue Page Component -->
<script setup lang="ts">
interface Props {
  products: Product[];
  categories: Category[];
}

const props = defineProps<Props>();
</script>
```

### Application Setup

**File: `resources/js/app.ts`**

```typescript
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => 
    resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
```

## Page Component Patterns

### Basic Page Structure

All Inertia pages follow this structure:

```vue
<!-- resources/js/pages/store/store-index.vue -->
<script setup lang="ts">
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import type { Product, Category } from '@/types';

interface Props {
  products: Product[];
  categories: Category[];
}

const props = defineProps<Props>();
</script>

<template>
  <navbar-layout page-title="Store">
    <div class="container mx-auto py-8">
      <!-- Page content -->
    </div>
  </navbar-layout>
</template>
```

### Layout Integration

Pages can specify layouts or use defaults:

```vue
<!-- Using specific layout -->
<script setup lang="ts">
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
</script>

<template>
  <sidebar-layout>
    <!-- Admin page content -->
  </sidebar-layout>
</template>
```

## Data Flow Patterns

### Controller to Page Data Flow

Laravel controllers pass data directly to Vue pages:

**Laravel Controller:**
```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Response;

class StoreController extends Controller
{
    public function index(Request $request): Response
    {
        $products = Product::query()
            ->with(['category', 'prices'])
            ->where('is_active', true)
            ->inStock()
            ->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return inertia('store/store-index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
```

**Vue Page Component:**
```vue
<script setup lang="ts">
import type { Product, Category } from '@/types';

interface Props {
  products: Product[];
  categories: Category[];
}

const props = defineProps<Props>();

// Data is immediately available, no loading states needed
console.log(props.products.length); // Works immediately
</script>
```

### Reactive Data Updates

Inertia provides reactive updates when navigating:

```vue
<script setup lang="ts">
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps<{ products: Product[] }>();

// Data reactively updates when navigating
const productCount = computed(() => props.products.length);

// Navigate with new data
const filterProducts = (categoryId: number) => {
  router.get(route('store'), { category: categoryId });
};
</script>
```

## Form Handling with Inertia

### Form Submission Pattern

Inertia forms provide automatic validation and error handling:

```vue
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  message: '',
});

const submit = () => {
  form.post(route('contact.store'), {
    onSuccess: () => {
      // Handle success
      form.reset();
    },
    onError: (errors) => {
      // Errors automatically available in form.errors
      console.log(errors);
    },
  });
};
</script>

<template>
  <form @submit.prevent="submit">
    <ui-input
      v-model="form.name"
      label="Name"
      :error-text="form.errors.name"
      :disabled="form.processing"
      required
    />
    
    <ui-button
      type="submit"
      label="Send Message"
      :loading="form.processing"
      :disabled="form.processing"
    />
  </form>
</template>
```

### File Upload Handling

Inertia supports file uploads seamlessly:

```vue
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  title: '',
  content: '',
  image: null as File | null,
});

const handleImageUpload = (file: File) => {
  form.image = file;
};

const submit = () => {
  form.post(route('blog.store'), {
    forceFormData: true, // Required for file uploads
  });
};
</script>

<template>
  <form @submit.prevent="submit">
    <ui-input v-model="form.title" label="Title" />
    
    <ui-file-upload
      @file-selected="handleImageUpload"
      :error-text="form.errors.image"
    />
    
    <ui-button type="submit" :loading="form.processing">
      Create Post
    </ui-button>
  </form>
</template>
```

## Navigation Patterns

### Programmatic Navigation

Navigate between pages with the router:

```vue
<script setup lang="ts">
import { router } from '@inertiajs/vue3';

// Simple navigation
const goToStore = () => {
  router.visit(route('store'));
};

// Navigation with data
const viewProduct = (product: Product) => {
  router.visit(route('store.product', product.slug));
};

// Navigation with query parameters
const filterProducts = (filters: ProductFilters) => {
  router.get(route('store'), filters);
};

// Replace current URL (no history entry)
const replaceUrl = () => {
  router.visit(route('home'), { replace: true });
};
</script>
```

### Link Components

Use Inertia's Link component for navigation:

```vue
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <!-- Basic link -->
  <Link :href="route('store')" class="text-purple-500 hover:text-purple-600">
    Visit Store
  </Link>
  
  <!-- Link with data -->
  <Link
    :href="route('store')"
    :data="{ category: 'floral' }"
    class="button"
  >
    Floral Arrangements
  </Link>
  
  <!-- Link that preserves scroll position -->
  <Link
    :href="route('blog')"
    preserve-scroll
    class="nav-link"
  >
    Blog
  </Link>
</template>
```

## Advanced Inertia Features

### Partial Reloads

Update only specific props without full page reload:

```vue
<script setup lang="ts">
import { router } from '@inertiajs/vue3';

const refreshProducts = () => {
  router.reload({
    only: ['products'], // Only reload products prop
    preserveScroll: true,
  });
};

const refreshAll = () => {
  router.reload(); // Reload all props
};
</script>
```

### Global Properties

Access global data throughout the application:

```vue
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';

const page = usePage();

// Access shared data
const user = computed(() => page.props.auth?.user);
const notifications = computed(() => page.props.notifications);

// Access flash messages
const successMessage = computed(() => page.props.flash?.success);
</script>

<template>
  <div v-if="successMessage" class="alert alert-success">
    {{ successMessage }}
  </div>
</template>
```

### Remember State

Preserve component state across page visits:

```vue
<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const searchQuery = ref('');
const selectedCategory = ref('');

// Remember search state when navigating
router.remember({
  searchQuery,
  selectedCategory,
});
</script>
```

## Server-Side Integration

### Laravel Controller Patterns

Controllers return Inertia responses with typed data:

```php
<?php

class BlogController extends Controller
{
    public function index(): Response
    {
        $blogPosts = BlogPost::query()
            ->where('is_published', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        return inertia('blog/blog-index', [
            'blogPosts' => $blogPosts,
        ]);
    }

    public function show(string $slug): Response
    {
        $blogPost = BlogPost::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return inertia('blog/blog-show', [
            'blogPost' => $blogPost,
        ]);
    }
}
```

### Middleware Integration

Inertia works with Laravel middleware for authentication and authorization:

```php
// routes/web.php
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return inertia('home/home-index');
    })->name('home');
    
    Route::get('/store', [StoreController::class, 'index'])->name('store');
});
```

### Shared Data

Share common data across all pages:

```php
// app/Http/Middleware/HandleInertiaRequests.php
public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        'auth' => [
            'user' => $request->user(),
        ],
        'notifications' => fn () => $request->user()?->unreadNotifications,
        'cart' => fn () => session('cart', []),
        'flash' => [
            'success' => fn () => $request->session()->get('success'),
            'error' => fn () => $request->session()->get('error'),
        ],
    ]);
}
```

## Error Handling

### Validation Errors

Inertia automatically handles Laravel validation errors:

```vue
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
});

// form.errors automatically populated on validation failure
</script>

<template>
  <form @submit.prevent="form.post(route('contact.store'))">
    <ui-input
      v-model="form.name"
      :error-text="form.errors.name" <!-- Automatic error display -->
    />
  </form>
</template>
```

### Global Error Handling

Handle application errors globally:

```typescript
// app.ts
createInertiaApp({
  // ... other config
  resolve: (name) => {
    const page = resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue'));
    
    page.then((module) => {
      // Add global error boundary
      if (!module.default.errorCaptured) {
        module.default.errorCaptured = (error: Error) => {
          console.error('Page error:', error);
          // Handle error (show toast, redirect, etc.)
        };
      }
    });
    
    return page;
  },
});
```

## Performance Optimization

### Code Splitting

Inertia automatically code splits by page:

```typescript
// Automatic code splitting per page
resolve: (name) => 
  resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue'))
```

### Prefetching

Prefetch pages for faster navigation:

```vue
<template>
  <!-- Prefetch on hover -->
  <Link
    :href="route('store')"
    prefetch
    class="nav-link"
  >
    Store
  </Link>
</template>
```

### Asset Versioning

Laravel Vite handles asset versioning automatically:

```html
<!-- Automatic cache busting -->
<link rel="stylesheet" href="/build/assets/app.abc123.css">
<script type="module" src="/build/assets/app.def456.js"></script>
```

## Testing with Inertia

### Unit Testing Pages

Test Inertia page components:

```typescript
// store-index.test.ts
import { mount } from '@vue/test-utils';
import StoreIndex from '@/pages/store/store-index.vue';

describe('StoreIndex', () => {
  it('displays products', () => {
    const products = [
      { id: 1, name: 'Test Product', price: 10.00 }
    ];
    
    const wrapper = mount(StoreIndex, {
      props: { products, categories: [] }
    });
    
    expect(wrapper.text()).toContain('Test Product');
  });
});
```

### Integration Testing

Test full Inertia responses in Laravel:

```php
// tests/Feature/StoreTest.php
public function test_store_index_returns_inertia_response()
{
    $response = $this->get('/store');
    
    $response->assertInertia(fn (Assert $page) =>
        $page
            ->component('store/store-index')
            ->has('products')
            ->has('categories')
    );
}
```

## Best Practices

### Page Organization

1. **File-based routing** - Page components match Laravel routes
2. **Layout consistency** - Use appropriate layouts for page types
3. **Props validation** - Define TypeScript interfaces for all props
4. **Error boundaries** - Handle errors gracefully

### Data Management

1. **Server-side filtering** - Keep complex queries on the server
2. **Pagination** - Use Laravel's built-in pagination
3. **Caching** - Cache expensive queries on the server
4. **Partial reloads** - Update only necessary data

### Performance

1. **Code splitting** - Leverage automatic page-based splitting
2. **Prefetching** - Prefetch likely navigation targets
3. **Asset optimization** - Use Vite's optimization features
4. **Server-side rendering** - Benefits of SSR without complexity

### Security

1. **CSRF protection** - Automatic CSRF token handling
2. **XSS prevention** - Vue's built-in XSS protection
3. **Authorization** - Use Laravel middleware and policies
4. **Input validation** - Server-side validation with client feedback

Inertia.js provides the perfect balance between the simplicity of server-rendered applications and the rich interactivity of single-page applications, making it ideal for the Dandelines Design project's needs.