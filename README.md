# Dandelines Design

Branding and store site for Dandelines Design.

## Overview

### What is Dandelines Design?

Dandelines Design is a creative business run by Michele Grotenhuis, offering a blend of artistic services including event planning, floral arrangements, and custom artwork. The platform showcases Michele's portfolio, allows clients to request quotes, browse available products, and stay updated through blog posts and newsletters.

### Key Features

- **E-commerce Store**: Allows customers to browse and purchase available products.
- **Blog Platform**: Features articles and updates about Dandelines Design's work and industry insights.
- **Quote Request System**: Enables potential clients to request custom quotes for services.
- **Newsletter Subscription**: Keeps customers informed about new products, services, and promotions.
- **Admin Dashboard**: Provides comprehensive tools for content management, order processing, and customer engagement.

## Getting Started

### Prerequisites

Ensure you have the following prerequisites installed on your system. You can verify each installation by running the provided commands in your terminal.

1. **PHP** is required for the application. Check if PHP is installed by running:

   ```bash
   php --version
   ```

2. **Composer** is necessary for managing PHP dependencies. Verify its installation with:

   ```bash
   composer --version
   ```

3. **Docker** is used for containerization. Confirm Docker is installed by running:

   ```bash
   docker --version
   ```

4. **Node** and **NPM** (Node Package Manager) are needed for managing frontend dependencies. Check their installations with:

   ```bash
   node --version
   npm --version
   ```

### Installation

1. Duplicate the example environment file and configure it with your settings:

   ```bash
   cp .env.example .env
   ```

2. Install PHP and JavaScript dependencies:

   ```bash
   composer install
   npm install
   ```

3. Generate a new PHP application key:

   ```bash
   php artisan key:generate
   ```

4. Use Sail to build and start the application:

   ```bash
   ./vendor/bin/sail up -d
   ```

5. Apply database migrations:

   ```bash
   sail artisan migrate
   ```

6. Seed the database with test data:

   ```bash
    sail artisan db:seed
   ```

7. Compile assets and run the Vue frontend:

   ```bash
   npm run dev
   ```
