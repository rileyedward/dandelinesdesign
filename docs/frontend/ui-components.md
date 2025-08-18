# UI Component Library

The Dandelines Design application features a comprehensive UI component library built with Vue 3, TypeScript, and TailwindCSS. All components follow consistent patterns and provide full type safety.

## Library Organization

### Directory Structure

```
resources/js/components/ui/
├── data/                    # Data display components
│   ├── accordion/
│   ├── chart/
│   ├── dropdown-menu/
│   └── tooltip/
├── feedback/               # User feedback components
│   ├── alert/
│   ├── modal/
│   └── toast/
├── forms/                  # Form input components
│   ├── button/
│   ├── input/
│   ├── select/
│   ├── textarea/
│   ├── checkbox/
│   ├── radio/
│   ├── datepicker/
│   ├── file-upload/
│   └── rich-text-editor/
├── layout/                 # Layout and container components
│   ├── card/
│   ├── container/
│   ├── drawer/
│   └── table/
├── navigation/             # Navigation components
│   ├── breadcrumbs/
│   ├── dropdown/
│   ├── menu/
│   ├── navbar/
│   ├── sidebar/
│   └── tab/
└── footer/                 # Site footer
    └── ui-footer/
```

## Component Architecture

### Consistent Component Pattern

Every UI component follows the same structure:

```
ui-component/
├── ui-component.vue        # Vue template and script
└── ui-component.ts         # TypeScript definitions
```

### Type Safety Implementation

**Example: `ui-button.ts`**

```typescript
import type { LucideIcon } from 'lucide-vue-next';

export interface UiButtonProps {
  type?: 'button' | 'submit' | 'reset';
  label?: string;
  variant?: 'primary' | 'secondary' | 'outline' | 'success' | 'danger' | 'warning' | 'info';
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
  (event: 'keyup', e: KeyboardEvent): void;
  (event: 'keydown', e: KeyboardEvent): void;
}
```

**Example: `ui-button.vue`**

```vue
<script setup lang="ts">
import { computed } from 'vue';
import type { UiButtonProps, UiButtonEmits } from './ui-button';

const props = withDefaults(defineProps<UiButtonProps>(), {
  type: 'button',
  variant: 'primary',
  size: 'md',
  fullWidth: false,
  disabled: false,
  loading: false,
});

const emit = defineEmits<UiButtonEmits>();

const buttonClasses = computed(() => {
  // Dynamic class computation based on props
});
</script>

<template>
  <button
    :type="type"
    :class="buttonClasses"
    :disabled="disabled || loading"
    @click="emit('click', $event)"
  >
    <!-- Icon and content rendering -->
  </button>
</template>
```

## Form Components

### Input Components

#### UiInput
```vue
<ui-input
  v-model="value"
  type="text"
  label="Name"
  placeholder="Enter your name"
  :prefix-icon="User"
  :error-text="errors.name"
  required
  full-width
/>
```

**Props:**
- `type`: input type (text, email, password, number, etc.)
- `label`: field label
- `placeholder`: placeholder text
- `prefixIcon`/`suffixIcon`: Lucide icons
- `errorText`: validation error message
- `disabled`: disable state
- `required`: required field indicator

#### UiTextarea
```vue
<ui-textarea
  v-model="description"
  label="Description"
  :rows="4"
  placeholder="Enter description"
  :error-text="errors.description"
/>
```

#### UiSelect
```vue
<ui-select
  v-model="selectedOption"
  :options="selectOptions"
  label="Category"
  placeholder="Choose category"
  :error-text="errors.category"
/>
```

**Options format:**
```typescript
const selectOptions = [
  { value: '1', label: 'Option 1' },
  { value: '2', label: 'Option 2' },
];
```

#### UiCheckbox
```vue
<ui-checkbox
  v-model="isActive"
  label="Active"
  description="Enable this option"
  :error-text="errors.is_active"
/>
```

#### UiButton
```vue
<ui-button
  label="Save"
  variant="primary"
  size="md"
  :prefix-icon="Save"
  :loading="processing"
  :disabled="!isValid"
  @click="handleSave"
/>
```

**Variants:** `primary`, `secondary`, `outline`, `success`, `danger`, `warning`, `info`
**Sizes:** `sm`, `md`, `lg`, `xl`

### Advanced Form Components

#### UiDatePicker
```vue
<ui-datepicker
  v-model="selectedDate"
  label="Event Date"
  :min-date="new Date()"
  :error-text="errors.event_date"
/>
```

#### UiFileUpload
```vue
<ui-file-upload
  v-model="uploadedFile"
  label="Upload Image"
  accept="image/*"
  :max-size="2048"
  :error-text="errors.image"
/>
```

#### UiRichTextEditor
```vue
<ui-rich-text-editor
  v-model="content"
  label="Content"
  :toolbar="['bold', 'italic', 'link']"
  :error-text="errors.content"
/>
```

## Feedback Components

### UiModal
```vue
<ui-modal
  :show="showModal"
  title="Confirm Action"
  description="Are you sure you want to proceed?"
  size="md"
  @update:show="(value) => showModal = value"
>
  <div class="space-y-4">
    <!-- Modal content -->
  </div>
  
  <template #footer>
    <ui-button label="Cancel" variant="secondary" @click="showModal = false" />
    <ui-button label="Confirm" variant="primary" @click="handleConfirm" />
  </template>
</ui-modal>
```

**Props:**
- `show`: modal visibility
- `title`: modal title
- `description`: modal description
- `size`: `sm`, `md`, `lg`, `xl`, `full`
- `closable`: show close button

### UiAlert
```vue
<ui-alert
  variant="success"
  title="Success!"
  description="Operation completed successfully"
  :closable="true"
  @close="handleClose"
/>
```

**Variants:** `info`, `success`, `warning`, `error`

### UiToast
```vue
<ui-toast
  :show="showToast"
  variant="success"
  title="Saved!"
  description="Changes have been saved"
  :auto-close="3000"
/>
```

## Layout Components

### UiCard
```vue
<ui-card
  title="Card Title"
  description="Card description"
  :padding="true"
  :shadow="true"
>
  <div class="space-y-4">
    <!-- Card content -->
  </div>
  
  <template #footer>
    <ui-button label="Action" variant="primary" />
  </template>
</ui-card>
```

### UiDrawer
```vue
<ui-drawer
  v-model:show="showDrawer"
  title="Settings"
  description="Configure your preferences"
  position="right"
  width="400px"
>
  <!-- Drawer content -->
</ui-drawer>
```

**Positions:** `left`, `right`, `top`, `bottom`

### UiTable
```vue
<ui-table
  :headers="tableHeaders"
  :rows="tableRows"
  :sortable="true"
  :loading="loading"
  @row-click="handleRowClick"
>
  <template #actions="{ row }">
    <ui-button size="sm" variant="outline" @click="editRow(row)">
      Edit
    </ui-button>
  </template>
</ui-table>
```

## Navigation Components

### UiNavbar
```vue
<ui-navbar
  :left-nav-links="leftLinks"
  :right-nav-links="rightLinks"
  :logo="{ src: '/logo.png', alt: 'Logo' }"
  :sticky="true"
/>
```

### UiSidebar
```vue
<ui-sidebar
  :items="sidebarItems"
  :collapsible="true"
  :collapsed="sidebarCollapsed"
  @item-click="handleItemClick"
/>
```

**Sidebar Item Structure:**
```typescript
interface SidebarItem {
  label: string;
  route?: string;
  icon?: LucideIcon;
  children?: SidebarItem[];
  badge?: string;
  active?: boolean;
}
```

### UiBreadcrumb
```vue
<ui-breadcrumb
  :items="breadcrumbItems"
  separator="/"
/>
```

## Data Display Components

### UiAccordion
```vue
<ui-accordion
  :items="accordionItems"
  :multiple="false"
  :default-open="0"
/>
```

### UiDropdownMenu
```vue
<ui-dropdown-menu>
  <template #trigger>
    <ui-button label="Actions" :suffix-icon="ChevronDown" />
  </template>
  
  <template #content>
    <div class="py-1">
      <a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100">Delete</a>
    </div>
  </template>
</ui-dropdown-menu>
```

### UiTooltip
```vue
<ui-tooltip text="Helpful information">
  <ui-button label="Hover me" />
</ui-tooltip>
```

## Design System Integration

### Color Variants

All components support consistent color variants:

- **Primary:** Purple theme colors
- **Secondary:** Gray theme colors
- **Success:** Green for positive actions
- **Danger:** Red for destructive actions
- **Warning:** Yellow for caution
- **Info:** Blue for information

### Size System

Consistent sizing across components:

- **sm:** Small, compact variant
- **md:** Default medium size
- **lg:** Large, prominent variant
- **xl:** Extra large for emphasis

### Spacing and Layout

Components use TailwindCSS spacing classes:

```vue
<template>
  <div class="space-y-4">        <!-- Vertical spacing -->
    <div class="flex space-x-3"> <!-- Horizontal spacing -->
      <!-- Components -->
    </div>
  </div>
</template>
```

## Icon Integration

### Lucide Vue Next

All components use Lucide icons for consistency:

```vue
<script setup lang="ts">
import { Save, Edit, Trash2, Plus } from 'lucide-vue-next';
</script>

<template>
  <ui-button :prefix-icon="Save" label="Save" />
  <ui-button :prefix-icon="Edit" label="Edit" />
  <ui-button :prefix-icon="Trash2" variant="danger" />
</template>
```

### Icon Sizing

Icons automatically size based on component size:

- `sm` components: 12px (h-3 w-3)
- `md` components: 16px (h-4 w-4)
- `lg` components: 20px (h-5 w-5)
- `xl` components: 24px (h-6 w-6)

## Responsive Design

### Mobile-First Approach

Components are designed mobile-first with responsive breakpoints:

```vue
<template>
  <ui-button
    class="w-full md:w-auto"  <!-- Full width on mobile, auto on desktop -->
    size="md"
    :full-width="isMobile"
  />
</template>
```

### Adaptive Layouts

Components adapt to screen size:

- **Navbar:** Collapses to hamburger menu on mobile
- **Sidebar:** Converts to overlay on mobile
- **Tables:** Become scrollable horizontally
- **Modals:** Take full screen on mobile
- **Forms:** Stack vertically on small screens

## Accessibility Features

### ARIA Support

Components include proper ARIA attributes:

```vue
<template>
  <button
    :aria-label="label"
    :aria-disabled="disabled"
    role="button"
    :tabindex="disabled ? -1 : 0"
  >
    {{ label }}
  </button>
</template>
```

### Keyboard Navigation

- **Tab navigation** through interactive elements
- **Enter/Space** activation for buttons
- **Escape** to close modals and dropdowns
- **Arrow keys** for menu navigation

### Screen Reader Support

- Semantic HTML structure
- Descriptive labels and descriptions
- Status announcements for dynamic content
- Focus management for modals and drawers

## Usage Examples

### Complete Form Example

```vue
<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <ui-card title="User Information" :padding="true">
      <div class="space-y-4">
        <ui-input
          v-model="form.name"
          label="Full Name"
          :prefix-icon="User"
          :error-text="errors.name"
          required
        />
        
        <ui-input
          v-model="form.email"
          type="email"
          label="Email"
          :prefix-icon="Mail"
          :error-text="errors.email"
          required
        />
        
        <ui-select
          v-model="form.role"
          :options="roleOptions"
          label="Role"
          :error-text="errors.role"
        />
        
        <ui-checkbox
          v-model="form.active"
          label="Active User"
          description="User can log in and access the system"
        />
      </div>
    </ui-card>
    
    <div class="flex justify-end space-x-3">
      <ui-button
        label="Cancel"
        variant="secondary"
        @click="$emit('cancel')"
      />
      <ui-button
        label="Save User"
        type="submit"
        variant="primary"
        :loading="processing"
        :prefix-icon="Save"
      />
    </div>
  </form>
</template>
```

## Best Practices

### Component Usage

1. **Import Types** - Always import component interfaces
2. **Use v-model** - For two-way data binding
3. **Handle Events** - Emit events for parent communication
4. **Error Handling** - Pass validation errors to components
5. **Loading States** - Show loading states during async operations

### Performance

1. **Lazy Loading** - Load components only when needed
2. **Props Validation** - Use TypeScript for compile-time validation
3. **Event Handlers** - Use computed properties for complex logic
4. **Memory Management** - Clean up event listeners and refs

### Customization

1. **CSS Classes** - Extend with additional TailwindCSS classes
2. **Slots** - Use slots for custom content
3. **Props** - Leverage props for configuration
4. **Themes** - Use CSS custom properties for theming

This UI component library provides a solid foundation for building consistent, accessible, and maintainable user interfaces throughout the application.