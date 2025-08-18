# Layout System

The Dandelines Design application uses a configuration-driven layout system that provides consistent navigation and structure across different page types.

## Layout Architecture

### Two Main Layout Types

1. **Navbar Layout** - Public-facing pages with horizontal navigation
2. **Sidebar Layout** - Admin pages with collapsible sidebar navigation

### Layout Selection Strategy

- **Public Pages** (`web.php` routes) → Navbar Layout
- **Admin Pages** (`admin.php` routes) → Sidebar Layout
- **Auth Pages** → Auth Layout (minimal)

## Navbar Layout

### Configuration-Based Approach

The navbar layout uses a centralized configuration file that defines all navigation elements:

**File: `resources/js/layouts/navbar/navbar-layout.config.ts`**

```typescript
export interface NavbarLayoutConfig {
    pageTitle: string;
    leftNavLinks: NavLink[];
    rightNavLinks: NavLink[];
    contactInfo: ContactInfo;
    navigationLinks: NavigationLinkGroup[];
    socialLinks: FooterSocialLink[];
}

const config: NavbarLayoutConfig = {
    pageTitle: 'Dandelines Design',
    leftNavLinks: [
        { name: 'Home', href: '/' },
        { name: 'About', href: '/about' },
        { name: 'Services', href: '/services' },
    ],
    rightNavLinks: [
        { name: 'Store', href: '/store' },
        { name: 'Blog', href: '/blog' },
        { name: 'Contact', href: '/contact' },
    ],
    contactInfo: {
        email: 'dandelinesdesign@gmail.com',
        phone: '(816) 509-9824',
        address: 'Independence, MO, USA',
    },
    socialLinks: [
        { name: 'Instagram', icon: Instagram, href: 'https://instagram.com/...' },
        { name: 'Facebook', icon: Facebook, href: 'https://facebook.com/...' },
    ],
};
```

### Layout Implementation

**File: `resources/js/layouts/navbar/navbar-layout.vue`**

```vue
<script setup lang="ts">
import UiFooter from '@/components/ui/footer/ui-footer.vue';
import UiNavbar from '@/components/ui/navigation/navbar/ui-navbar.vue';
import { Head as InertiaHead } from '@inertiajs/vue3';
import defaultConfig from './navbar-layout.config';

interface Props {
    pageTitle?: string;
}

const props = withDefaults(defineProps<Props>(), {
    pageTitle: 'Dandelines Design',
});
</script>

<template>
    <inertia-head :title="props.pageTitle" />
    
    <ui-navbar 
        :left-nav-links="defaultConfig.leftNavLinks" 
        :right-nav-links="defaultConfig.rightNavLinks" 
    />
    
    <main>
        <slot />
    </main>
    
    <ui-footer
        :contact-info="defaultConfig.contactInfo"
        :navigation-links="defaultConfig.navigationLinks"
        :social-links="defaultConfig.socialLinks"
    />
</template>
```

### Usage in Pages

```vue
<!-- resources/js/pages/home/home-index.vue -->
<script setup lang="ts">
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
</script>

<template>
  <navbar-layout page-title="Home - Dandelines Design">
    <!-- Page content -->
  </navbar-layout>
</template>
```

## Sidebar Layout

### Admin-Focused Configuration

The sidebar layout is designed for admin interfaces with hierarchical navigation:

**File: `resources/js/layouts/sidebar/sidebar-layout.config.ts`**

```typescript
export interface SidebarLayoutConfig {
    title: string;
    sidebarItems: SidebarItem[];
    profileMenu: {
        userName: string;
        menuItems: DropdownMenuItem[];
    };
}

const config: SidebarLayoutConfig = {
    title: 'Dandeline Designs',
    sidebarItems: [
        { label: 'Dashboard', route: '/admin', icon: Home },
        {
            label: 'Customer Relations',
            icon: Users,
            children: [
                { label: 'Messages', route: '/admin/messages', icon: Mail },
                { label: 'Quotes', route: '/admin/quotes', icon: MessageSquare },
                { label: 'Leads', route: '/admin/leads', icon: UserCheck },
            ],
        },
        {
            label: 'Ecommerce',
            icon: ShoppingBag,
            children: [
                { label: 'Orders', route: '/admin/orders', icon: ShoppingBag },
                { label: 'Products', route: '/admin/products', icon: Package },
                { label: 'Categories', route: '/admin/categories', icon: Tag },
            ],
        },
    ],
    profileMenu: {
        userName: 'Admin User',
        menuItems: [
            {
                label: 'Log Out',
                icon: LogOut,
                variant: 'danger',
                action: () => router.delete(route('auth.login.destroy')),
            },
        ],
    },
};
```

### Hierarchical Navigation Structure

The sidebar supports nested navigation with:
- **Top-level items** - Direct routes (Dashboard)
- **Grouped items** - Categories with children (Customer Relations)
- **Child items** - Nested routes within groups

### Usage in Admin Pages

```vue
<!-- resources/js/pages/admin/admin-dashboard.vue -->
<script setup lang="ts">
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
</script>

<template>
  <sidebar-layout>
    <!-- Admin page content -->
  </sidebar-layout>
</template>
```

## Configuration Benefits

### Easy Maintenance

- **Single Source of Truth** - All navigation in config files
- **Type Safety** - TypeScript interfaces ensure consistency
- **Hot Updates** - Changes reflect immediately in development

### Scalability

- **Add New Routes** - Just update configuration arrays
- **Reorganize Navigation** - Move items without touching components
- **Rebrand** - Update titles, logos, and links in one place

### Consistency

- **Uniform Structure** - All pages use same navigation patterns
- **Shared Components** - Navbar and sidebar use common UI components
- **Design System** - Consistent styling and interactions

## Layout Components

### UI Component Integration

Both layouts leverage the UI component library:

- `ui-navbar` - Horizontal navigation component
- `ui-sidebar` - Collapsible sidebar component
- `ui-footer` - Site footer with links and contact info
- `ui-dropdown` - Profile menu and mobile navigation

### Responsive Design

- **Mobile-First** - Layouts adapt to screen size
- **Collapsible Sidebar** - Admin layout collapses on mobile
- **Touch-Friendly** - Navigation optimized for touch devices

## Advanced Features

### Dynamic Configuration

Configurations can be modified at runtime:

```typescript
// Example: Hide certain navigation items based on user permissions
const filteredItems = config.sidebarItems.filter(item => 
  userHasPermission(item.route)
);
```

### Theme Support

Layouts support theming through CSS custom properties:

```css
:root {
  --navbar-bg: #ffffff;
  --sidebar-bg: #f8f9fa;
  --nav-text: #374151;
}
```

### SEO Integration

Both layouts integrate with Inertia's Head component:

```vue
<inertia-head :title="props.pageTitle" />
```

## Best Practices

### Configuration Management

1. **Keep configs focused** - Separate navbar and sidebar configs
2. **Use TypeScript** - Define interfaces for type safety
3. **Document routes** - Comment complex navigation structures
4. **Test navigation** - Ensure all routes are accessible

### Layout Selection

1. **Public pages** → Navbar layout
2. **Admin pages** → Sidebar layout  
3. **Auth pages** → Auth layout
4. **Consider user context** - Choose appropriate layout for user type

### Performance

1. **Lazy load icons** - Import only needed Lucide icons
2. **Optimize images** - Use appropriate formats for logos
3. **Cache configs** - Avoid recreating config objects

## Integration Examples

### Page with Custom Title

```vue
<template>
  <navbar-layout page-title="Custom Page Title">
    <!-- Content -->
  </navbar-layout>
</template>
```

### Admin Page with Sidebar

```vue
<template>
  <sidebar-layout>
    <common-page-header title="Admin Dashboard" />
    <!-- Admin content -->
  </sidebar-layout>
</template>
```

This layout system provides a solid foundation for consistent navigation while remaining flexible enough for future expansion and customization.