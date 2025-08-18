# Form Patterns

This document outlines the comprehensive form patterns used throughout the Dandelines Design application, including CRUD operations, validation, and UI patterns.

## Form Architecture Overview

### Three-Layer Form System

1. **Form Components** (`[entity]-form/`) - Core form logic and fields
2. **Modal/Drawer Wrappers** (`[entity]-create-modal/`, `[entity]-update-modal/`) - UI containers
3. **Page Integration** - Forms embedded in pages or triggered by actions

### Pattern Philosophy

- **Reusable Forms** - Same form component handles create and update
- **Separation of Concerns** - Form logic separate from UI presentation
- **Type Safety** - Full TypeScript integration
- **Validation** - Server-side validation with real-time feedback

## Form Component Pattern

### Basic Form Structure

Every entity follows this consistent form structure:

```
[entity]/
├── [entity]-form/
│   ├── [entity]-form.vue        # Form template and logic
│   └── [entity]-form.ts         # TypeScript definitions
├── [entity]-create-modal/
│   └── [entity]-create-modal.vue
└── [entity]-update-modal/
    └── [entity]-update-modal.vue
```

### Form Component Example

**File: `components/category/category-form/category-form.ts`**

```typescript
import type { Category } from '@/types/category';

export interface CategoryFormProps {
    category?: Category;          // For updates (optional)
    processing?: boolean;         // Loading state
    errors?: Record<string, string>; // Validation errors
}

export interface CategoryFormEmits {
    (event: 'submit', category: Partial<Category>): void;
    (event: 'cancel'): void;
    (event: 'delete'): void;      // For update forms
}
```

**File: `components/category/category-form/category-form.vue`**

```vue
<script setup lang="ts">
import { computed, ref } from 'vue';
import type { CategoryFormProps, CategoryFormEmits } from './category-form';

const props = withDefaults(defineProps<CategoryFormProps>(), {
    processing: false,
    errors: () => ({}),
});

const emit = defineEmits<CategoryFormEmits>();

// Form fields
const name = ref(props.category?.name || '');
const slug = ref(props.category?.slug || '');
const description = ref(props.category?.description || '');
const is_active = ref(props.category?.is_active || true);

// Computed properties
const isEditing = computed(() => !!props.category);

// Event handlers
const handleSubmit = () => {
    emit('submit', {
        name: name.value,
        slug: slug.value,
        description: description.value,
        is_active: is_active.value,
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
            
            <ui-checkbox
                v-model="is_active"
                label="Active Category"
                :error-text="errors.is_active"
                :disabled="processing"
            />
        </div>

        <div class="flex justify-end space-x-3">
            <ui-button 
                v-if="isEditing" 
                type="button" 
                variant="danger" 
                :prefix-icon="Trash2"
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

## Modal Pattern

### Create Modal Implementation

**File: `components/category/category-create-modal/category-create-modal.vue`**

```vue
<script setup lang="ts">
import CategoryForm from '@/components/category/category-form/category-form.vue';
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import { useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';

const showModal = ref(false);

const emit = defineEmits<{
    (e: 'created'): void;
}>();

const form = useForm({
    name: '',
    slug: '',
    description: '',
    is_active: true,
});

const handleSubmit = (category: any) => {
    // Map form data
    Object.assign(form, category);

    form.post(route('admin.categories.store'), {
        onSuccess: () => {
            showModal.value = false;
            emit('created');
            form.reset();
        },
    });
};
</script>

<template>
    <div>
        <ui-button 
            label="New" 
            variant="primary" 
            size="sm" 
            :prefix-icon="Plus" 
            @click="showModal = true" 
        />

        <ui-modal
            :show="showModal"
            title="Create Category"
            description="Add a new product category"
            size="lg"
            @update:show="(value) => (showModal = value)"
        >
            <category-form 
                :processing="form.processing" 
                :errors="form.errors" 
                @submit="handleSubmit" 
                @cancel="() => (showModal = false)" 
            />
        </ui-modal>
    </div>
</template>
```

### Update Modal Implementation

Update modals receive the entity data and handle updates:

```vue
<script setup lang="ts">
import CategoryForm from '@/components/category/category-form/category-form.vue';
import { useForm } from '@inertiajs/vue3';
import type { Category } from '@/types/category';

interface Props {
    category: Category;
    show: boolean;
}

const props = defineProps<Props>();
const emit = defineEmits<{
    (e: 'updated'): void;
    (e: 'close'): void;
}>();

const form = useForm({
    name: props.category.name,
    slug: props.category.slug,
    description: props.category.description,
    is_active: props.category.is_active,
});

const handleSubmit = (categoryData: any) => {
    Object.assign(form, categoryData);
    
    form.put(route('admin.categories.update', props.category.id), {
        onSuccess: () => {
            emit('updated');
            emit('close');
        },
    });
};

const handleDelete = () => {
    if (confirm('Are you sure you want to delete this category?')) {
        form.delete(route('admin.categories.destroy', props.category.id), {
            onSuccess: () => {
                emit('updated');
                emit('close');
            },
        });
    }
};
</script>
```

## Drawer Pattern

### Create Drawer Implementation

Some entities use drawers instead of modals for better mobile experience:

**File: `components/lead/lead-create-drawer/lead-create-drawer.vue`**

```vue
<script setup lang="ts">
import LeadForm from '@/components/lead/lead-form/lead-form.vue';
import UiDrawer from '@/components/ui/layout/drawer/ui-drawer.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const showDrawer = ref(false);
const emit = defineEmits<{ (e: 'created'): void; }>();

const form = useForm({
    name: '',
    email: '',
    phone_number: '',
    status: 'new',
    notes: '',
});

const handleSubmit = (lead: any) => {
    Object.assign(form, lead);
    
    form.post(route('admin.leads.store'), {
        onSuccess: () => {
            showDrawer.value = false;
            emit('created');
            form.reset();
        },
    });
};
</script>

<template>
    <div>
        <ui-button 
            label="New" 
            variant="primary" 
            size="sm" 
            :prefix-icon="Plus" 
            @click="showDrawer = true" 
        />

        <ui-drawer 
            v-model:show="showDrawer" 
            title="Create New Lead" 
            description="Add a new lead to your CRM system" 
            width="500px"
        >
            <lead-form 
                :processing="form.processing" 
                :errors="form.errors" 
                @submit="handleSubmit" 
                @cancel="() => showDrawer = false" 
            />
        </ui-drawer>
    </div>
</template>
```

## Page Integration Pattern

### Embedded Forms in Pages

Some forms are embedded directly in pages without modals:

```vue
<!-- resources/js/pages/contact/contact-index.vue -->
<script setup lang="ts">
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import ContactForm from '@/components/contact/contact-form.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const handleSubmit = (contactData: any) => {
    Object.assign(form, contactData);
    
    form.post(route('contact.store'), {
        onSuccess: () => {
            // Handle success (show toast, redirect, etc.)
        },
    });
};
</script>

<template>
    <navbar-layout page-title="Contact Us">
        <div class="container mx-auto py-12">
            <contact-form 
                :processing="form.processing"
                :errors="form.errors"
                @submit="handleSubmit"
            />
        </div>
    </navbar-layout>
</template>
```

### List Pages with CRUD Actions

List pages integrate create/update modals:

```vue
<!-- resources/js/pages/admin/categories/categories-index.vue -->
<script setup lang="ts">
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import CategoryList from '@/components/category/category-list/category-list.vue';
import CategoryCreateModal from '@/components/category/category-create-modal/category-create-modal.vue';
import { ref } from 'vue';
import type { Category } from '@/types/category';

interface Props {
    categories: Category[];
}

const props = defineProps<Props>();
const refreshKey = ref(0);

const handleCategoryCreated = () => {
    refreshKey.value++;
    // Refresh data or emit event to parent
};
</script>

<template>
    <sidebar-layout>
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Categories</h1>
                <category-create-modal @created="handleCategoryCreated" />
            </div>
            
            <category-list 
                :categories="props.categories" 
                :key="refreshKey"
                @updated="handleCategoryCreated"
            />
        </div>
    </sidebar-layout>
</template>
```

## Validation Patterns

### Server-Side Validation Integration

Forms integrate seamlessly with Laravel FormRequest validation:

```vue
<script setup lang="ts">
const form = useForm({ name: '', email: '' });

// Inertia automatically handles validation errors
// errors are available in form.errors
</script>

<template>
    <ui-input 
        v-model="form.name"
        :error-text="form.errors.name"
        label="Name"
    />
</template>
```

### Client-Side Validation

Additional client-side validation for better UX:

```vue
<script setup lang="ts">
import { computed } from 'vue';

const email = ref('');
const clientEmailError = computed(() => {
    if (!email.value) return '';
    if (!email.value.includes('@')) return 'Invalid email format';
    return '';
});

const finalEmailError = computed(() => 
    props.errors.email || clientEmailError.value
);
</script>
```

## UI Component Integration

### Consistent Form Controls

All forms use the same UI components:

- `ui-input` - Text, email, number inputs
- `ui-textarea` - Multi-line text
- `ui-select` - Dropdown selections
- `ui-checkbox` - Boolean values
- `ui-button` - Form actions
- `ui-modal` - Modal containers
- `ui-drawer` - Slide-out containers

### Form Layout Patterns

```vue
<template>
    <form @submit.prevent="handleSubmit" class="space-y-6">
        <!-- Form fields -->
        <div class="space-y-4">
            <!-- Input fields here -->
        </div>
        
        <!-- Form actions -->
        <div class="flex justify-end space-x-3">
            <ui-button variant="danger" v-if="isEditing" />
            <div class="flex-1"></div> <!-- Spacer -->
            <ui-button label="Cancel" variant="secondary" />
            <ui-button label="Save" type="submit" variant="primary" />
        </div>
    </form>
</template>
```

## Advanced Patterns

### Dynamic Form Fields

Forms that change based on user input:

```vue
<script setup lang="ts">
const productType = ref('physical');
const showInventoryFields = computed(() => 
    productType.value === 'physical'
);
</script>

<template>
    <ui-select v-model="productType" :options="typeOptions" />
    
    <div v-if="showInventoryFields">
        <ui-input v-model="stockQuantity" label="Stock Quantity" />
    </div>
</template>
```

### Multi-Step Forms

Complex forms broken into steps:

```vue
<script setup lang="ts">
const currentStep = ref(1);
const totalSteps = 3;

const nextStep = () => {
    if (currentStep.value < totalSteps) {
        currentStep.value++;
    }
};
</script>

<template>
    <div class="space-y-6">
        <!-- Step indicator -->
        <div class="flex justify-between mb-8">
            <span v-for="step in totalSteps" 
                  :class="step <= currentStep ? 'active' : 'inactive'">
                Step {{ step }}
            </span>
        </div>
        
        <!-- Step content -->
        <div v-show="currentStep === 1">
            <!-- Step 1 fields -->
        </div>
        
        <!-- Navigation -->
        <div class="flex justify-between">
            <ui-button @click="prevStep" :disabled="currentStep === 1">
                Previous
            </ui-button>
            <ui-button @click="nextStep" :disabled="currentStep === totalSteps">
                Next
            </ui-button>
        </div>
    </div>
</template>
```

## Best Practices

### Form Design

1. **Consistent Structure** - Follow the three-layer pattern
2. **Reusable Components** - Same form for create/update
3. **Type Safety** - Define interfaces for all props/emits
4. **Error Handling** - Integrate server validation smoothly

### UX Considerations

1. **Loading States** - Disable form during submission
2. **Success Feedback** - Clear success indication
3. **Validation Feedback** - Real-time error messages
4. **Mobile Friendly** - Use drawers for complex forms on mobile

### Performance

1. **Lazy Loading** - Load forms only when needed
2. **Form Reset** - Clear form data after successful submission
3. **Memory Leaks** - Properly clean up refs and watchers

This form pattern system provides a consistent, scalable approach to handling all CRUD operations throughout the application while maintaining type safety and excellent user experience.