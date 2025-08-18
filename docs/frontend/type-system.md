# Type System

This document outlines the comprehensive TypeScript type system used throughout the Dandelines Design frontend application.

## Type Architecture Overview

### Type Organization

The type system is organized in the `resources/js/types/` directory:

```
types/
├── index.d.ts              # Global type exports
├── env.d.ts               # Environment variable types
├── globals.d.ts           # Global augmentations
├── ziggy.d.ts             # Laravel route types
├── layouts/               # Layout-specific types
│   ├── app-layout.ts
│   └── navbar-layout.ts
├── blog.ts                # Blog entity types
├── cart.ts                # Shopping cart types
├── category.ts            # Category types
├── contact-message.ts     # Contact form types
├── lead.ts                # Lead management types
├── newsletter-subscriber.ts
├── newsletter-template.ts
├── notification.ts
├── order.ts               # E-commerce order types
├── product.ts             # Product types
├── quote-request.ts       # Quote system types
├── testimonial.ts         # Testimonial types
└── tracking.ts            # Analytics types
```

## Entity Type Definitions

### Base Entity Pattern

All entities follow a consistent structure:

```typescript
// Base entity interface
export interface BaseEntity {
  id: number;
  created_at: string;
  updated_at: string;
  deleted_at?: string;
}
```

### Product Type System

**File: `types/product.ts`**

```typescript
import type { Category } from './category';
import type { BaseEntity } from './index';

export interface Product extends BaseEntity {
  name: string;
  slug: string;
  description?: string;
  short_description?: string;
  sku?: string;
  stripe_product_id?: string;
  
  // Pricing
  price?: number;
  compare_at_price?: number;
  cost?: number;
  
  // Inventory
  stock_quantity: number;
  track_inventory: boolean;
  allow_backorder: boolean;
  
  // Physical properties
  weight?: number;
  package_dimensions?: PackageDimensions;
  
  // Status
  is_active: boolean;
  is_featured: boolean;
  
  // Media
  image_url?: string;
  images: string[];
  
  // Tax
  tax_code?: string;
  
  // Relationships
  category_id?: number;
  category?: Category;
  prices?: Price[];
  line_items?: LineItem[];
  
  // Computed properties
  current_price?: number;
  formatted_price?: string;
  in_stock?: boolean;
}

export interface PackageDimensions {
  length: number;
  width: number;
  height: number;
  weight: number;
}

export interface Price extends BaseEntity {
  product_id: number;
  stripe_price_id: string;
  amount: number;
  currency: string;
  is_current: boolean;
  product?: Product;
}

// Product-related form types
export interface ProductFormData {
  name: string;
  slug: string;
  description?: string;
  price: number;
  category_id?: number;
  stock_quantity: number;
  is_active: boolean;
  is_featured: boolean;
  images: string[];
}

// Product filtering and searching
export interface ProductFilters {
  category_id?: number;
  price_min?: number;
  price_max?: number;
  in_stock?: boolean;
  is_featured?: boolean;
  search?: string;
}

export interface ProductSearchParams extends ProductFilters {
  sort?: 'name' | 'price' | 'created_at';
  order?: 'asc' | 'desc';
  per_page?: number;
  page?: number;
}
```

### Order and E-commerce Types

**File: `types/order.ts`**

```typescript
import type { Product } from './product';
import type { BaseEntity } from './index';

export interface Order extends BaseEntity {
  order_number: string;
  status: OrderStatus;
  
  // Customer information
  customer_email: string;
  customer_first_name?: string;
  customer_last_name?: string;
  customer_phone?: string;
  
  // Pricing
  subtotal: number;
  tax_amount?: number;
  shipping_cost?: number;
  discount_amount?: number;
  total_amount: number;
  currency: string;
  
  // Shipping address
  shipping_address_line_1?: string;
  shipping_address_line_2?: string;
  shipping_city?: string;
  shipping_state?: string;
  shipping_postal_code?: string;
  shipping_country?: string;
  
  // Payment information
  payment_status: PaymentStatus;
  payment_method: string;
  payment_transaction_id?: string;
  payment_completed_at?: string;
  
  // Stripe integration
  stripe_checkout_session_id?: string;
  stripe_payment_intent_id?: string;
  stripe_customer_id?: string;
  
  // Fulfillment
  shipped_at?: string;
  tracking_number?: string;
  tracking_url?: string;
  delivered_at?: string;
  
  // Relationships
  line_items?: LineItem[];
  
  // Computed properties
  formatted_total?: string;
  customer_name?: string;
  shipping_address?: string;
  can_ship?: boolean;
  can_refund?: boolean;
}

export interface LineItem extends BaseEntity {
  order_id: number;
  product_id?: number;
  
  // Product snapshot (at time of order)
  product_name: string;
  product_sku?: string;
  product_description?: string;
  product_image_url?: string;
  
  // Pricing
  quantity: number;
  unit_price: number;
  total_price: number;
  currency: string;
  
  // Stripe integration
  stripe_price_id: string;
  stripe_product_id: string;
  
  // Relationships
  order?: Order;
  product?: Product;
  
  // Computed properties
  formatted_unit_price?: string;
  formatted_total_price?: string;
}

export type OrderStatus = 
  | 'pending' 
  | 'processing' 
  | 'shipped' 
  | 'delivered' 
  | 'cancelled' 
  | 'refunded';

export type PaymentStatus = 
  | 'pending' 
  | 'paid' 
  | 'failed' 
  | 'cancelled' 
  | 'refunded';

// Order management types
export interface OrderFilters {
  status?: OrderStatus;
  payment_status?: PaymentStatus;
  customer_email?: string;
  date_from?: string;
  date_to?: string;
}

export interface OrderUpdateData {
  status?: OrderStatus;
  tracking_number?: string;
  tracking_url?: string;
  notes?: string;
}
```

### Cart and Checkout Types

**File: `types/cart.ts`**

```typescript
import type { Product, Price } from './product';

export interface CartItem {
  product: Product;
  price: Price;
  quantity: number;
}

export interface Cart {
  items: CartItem[];
  total_items: number;
  subtotal: number;
  tax_amount: number;
  total_amount: number;
  currency: string;
}

export interface CheckoutData {
  items: CheckoutItem[];
  customer_email?: string;
  shipping_address?: ShippingAddress;
}

export interface CheckoutItem {
  price_id: string;
  quantity: number;
}

export interface ShippingAddress {
  line1: string;
  line2?: string;
  city: string;
  state: string;
  postal_code: string;
  country: string;
}

// Cart composable types
export interface UseCartReturn {
  items: Ref<CartItem[]>;
  totalItems: ComputedRef<number>;
  subtotal: ComputedRef<number>;
  totalAmount: ComputedRef<number>;
  isEmpty: ComputedRef<boolean>;
  addItem: (product: Product, quantity?: number) => void;
  removeItem: (productId: number) => void;
  updateQuantity: (productId: number, quantity: number) => void;
  clearCart: () => void;
}
```

## Component Type Integration

### Props and Emits Patterns

Components define their interfaces in separate `.ts` files:

```typescript
// category-form.ts
import type { Category } from '@/types/category';

export interface CategoryFormProps {
  category?: Category;
  processing?: boolean;
  errors?: Record<string, string>;
}

export interface CategoryFormEmits {
  (event: 'submit', category: Partial<Category>): void;
  (event: 'cancel'): void;
  (event: 'delete'): void;
}

// Generic list component types
export interface GenericListProps<T> {
  items: T[];
  loading?: boolean;
  selectable?: boolean;
  keyField?: keyof T;
}

export interface GenericListEmits<T> {
  (event: 'select', item: T): void;
  (event: 'selectMultiple', items: T[]): void;
}
```

### Form Validation Types

```typescript
// Form error handling
export interface FormErrors {
  [key: string]: string | string[];
}

// Inertia form types
export interface InertiaForm<T> {
  data: T;
  errors: FormErrors;
  processing: boolean;
  hasErrors: boolean;
  reset: (...fields: (keyof T)[]) => void;
  setError: (field: keyof T, value: string) => void;
  clearErrors: (...fields: (keyof T)[]) => void;
  post: (url: string, options?: any) => void;
  put: (url: string, options?: any) => void;
  patch: (url: string, options?: any) => void;
  delete: (url: string, options?: any) => void;
}

// Contact form example
export interface ContactFormData {
  name: string;
  email: string;
  subject: string;
  message: string;
}

export type ContactForm = InertiaForm<ContactFormData>;
```

## UI Component Types

### Button Component Types

```typescript
// ui-button.ts
import type { LucideIcon } from 'lucide-vue-next';

export interface UiButtonProps {
  type?: HTMLButtonElement['type'];
  label?: string;
  variant?: ButtonVariant;
  size?: ButtonSize;
  fullWidth?: boolean;
  prefixIcon?: LucideIcon;
  suffixIcon?: LucideIcon;
  disabled?: boolean;
  loading?: boolean;
}

export type ButtonVariant = 
  | 'primary' 
  | 'secondary' 
  | 'outline' 
  | 'success' 
  | 'danger' 
  | 'warning' 
  | 'info';

export type ButtonSize = 'sm' | 'md' | 'lg' | 'xl';

export interface UiButtonEmits {
  (event: 'click', e: MouseEvent): void;
  (event: 'focus', e: FocusEvent): void;
  (event: 'blur', e: FocusEvent): void;
}
```

### Input Component Types

```typescript
// ui-input.ts
export interface UiInputProps {
  modelValue?: string | number;
  type?: HTMLInputElement['type'];
  label?: string;
  placeholder?: string;
  prefixIcon?: LucideIcon;
  suffixIcon?: LucideIcon;
  errorText?: string;
  helpText?: string;
  disabled?: boolean;
  readonly?: boolean;
  required?: boolean;
  fullWidth?: boolean;
  autocomplete?: string;
}

export interface UiInputEmits {
  (event: 'update:modelValue', value: string | number): void;
  (event: 'input', e: Event): void;
  (event: 'change', e: Event): void;
  (event: 'focus', e: FocusEvent): void;
  (event: 'blur', e: FocusEvent): void;
}
```

## Utility Types

### Common Helper Types

```typescript
// Global utility types
export type Optional<T, K extends keyof T> = Omit<T, K> & Partial<Pick<T, K>>;

export type RequiredOnly<T, K extends keyof T> = Partial<T> & Required<Pick<T, K>>;

export type WithoutId<T> = Omit<T, 'id'>;

export type CreateEntity<T> = Omit<T, 'id' | 'created_at' | 'updated_at'>;

export type UpdateEntity<T> = Partial<CreateEntity<T>>;

// API response types
export interface ApiResponse<T> {
  data: T;
  message?: string;
  errors?: FormErrors;
}

export interface PaginatedResponse<T> {
  data: T[];
  current_page: number;
  per_page: number;
  total: number;
  last_page: number;
  from: number;
  to: number;
  links: PaginationLink[];
}

export interface PaginationLink {
  url?: string;
  label: string;
  active: boolean;
}
```

### Event Handler Types

```typescript
// Event handling types
export type EventHandler<T = Event> = (event: T) => void;

export type AsyncEventHandler<T = Event> = (event: T) => Promise<void>;

export type ButtonClickHandler = EventHandler<MouseEvent>;

export type FormSubmitHandler = EventHandler<Event>;

export type InputChangeHandler = EventHandler<Event>;

// Async operation types
export interface AsyncOperation<T = any> {
  loading: boolean;
  error?: string;
  data?: T;
}

export type AsyncFunction<T = any, P = any> = (params?: P) => Promise<T>;
```

## Layout and Navigation Types

### Layout Configuration Types

```typescript
// navbar-layout.ts
export interface NavbarLayoutConfig {
  pageTitle: string;
  leftNavLinks: NavLink[];
  rightNavLinks: NavLink[];
  contactInfo: ContactInfo;
  navigationLinks: NavigationLinkGroup[];
  socialLinks: FooterSocialLink[];
}

export interface NavLink {
  name: string;
  href: string;
  active?: boolean;
  external?: boolean;
}

export interface NavigationLinkGroup {
  title: string;
  links: FooterLink[];
}

export interface FooterSocialLink {
  name: string;
  icon: LucideIcon;
  href: string;
}
```

### Sidebar Types

```typescript
// sidebar-layout.ts
export interface SidebarItem {
  label: string;
  route?: string;
  icon?: LucideIcon;
  children?: SidebarItem[];
  badge?: string;
  active?: boolean;
  disabled?: boolean;
}

export interface SidebarLayoutConfig {
  title: string;
  sidebarItems: SidebarItem[];
  profileMenu: ProfileMenu;
}

export interface ProfileMenu {
  userName: string;
  userEmail?: string;
  avatar?: string;
  menuItems: DropdownMenuItem[];
}

export interface DropdownMenuItem {
  id: string;
  label: string;
  icon?: LucideIcon;
  variant?: 'default' | 'danger';
  disabled?: boolean;
  action?: () => void;
  href?: string;
}
```

## Global Type Augmentations

### Vue 3 Augmentations

```typescript
// globals.d.ts
import '@vue/runtime-core';

declare module '@vue/runtime-core' {
  export interface GlobalProperties {
    route: typeof route;
    ziggy: typeof Ziggy;
    $page: InertiaPage;
  }
}

// Inertia.js types
export interface InertiaPage<T = Record<string, any>> {
  component: string;
  props: T;
  url: string;
  version: string;
}

// Laravel route helper types
declare global {
  function route(name?: string, params?: any, absolute?: boolean): string;
  
  const Ziggy: {
    routes: Record<string, any>;
    location: string;
    port?: number;
    defaults: Record<string, any>;
  };
}
```

### Environment Variable Types

```typescript
// env.d.ts
interface ImportMetaEnv {
  readonly VITE_APP_NAME: string;
  readonly VITE_APP_URL: string;
  readonly VITE_STRIPE_PUBLISHABLE_KEY: string;
  readonly VITE_GOOGLE_ANALYTICS_ID?: string;
}

interface ImportMeta {
  readonly env: ImportMetaEnv;
}
```

## Best Practices

### Type Organization

1. **Entity-Based Files** - One file per business entity
2. **Component Co-location** - Props/emits interfaces next to components
3. **Utility Types** - Common helper types in shared files
4. **Global Augmentations** - Framework extensions in globals.d.ts

### Type Design Principles

1. **Strict Typing** - No `any` types in production code
2. **Explicit Interfaces** - Clear, descriptive interface names
3. **Optional Properties** - Use `?` for truly optional properties
4. **Union Types** - Prefer unions over enums for string literals

### Performance Considerations

1. **Import Types** - Use `import type` for type-only imports
2. **Generic Constraints** - Add constraints to generic types
3. **Conditional Types** - Use conditional types sparingly
4. **Type Inference** - Let TypeScript infer when possible

### Error Handling

1. **Form Errors** - Consistent error type across forms
2. **API Responses** - Standardized response interfaces
3. **Loading States** - Common async operation types
4. **Validation** - Type-safe validation schemas

This comprehensive type system provides compile-time safety, excellent IDE support, and self-documenting code throughout the application.