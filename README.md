# Dandelines Design

Branding and store site for Dandelines Design.

## Overview

### What is Dandelines Design?

Dandelines Design is a comprehensive branding and e-commerce platform specializing in digital budget planners and
financial planning tools. We combine beautiful design with practical functionality to help individuals and businesses
better manage their finances through customizable planning solutions.

### Why Use Dandelines Design?

Dandelines Design offers several compelling benefits. We create premium branded solutions that elevate your financial
planning experience through customizable tools, clear documentation, and dedicated support. Our cost-effective digital
approach makes professional financial planning accessible to everyone.

### Key Features

- **Branding**: Professional branding elements including logo, colors, typography, and brand guidelines.
- **Contact**: Contact form and business contact information for inquiries and support.
- **Blog**: Articles and updates about budgeting, financial tips, and company news.
- **Store**: Shop for digital budget planners, templates, and financial planning tools.


## Getting Started

### Prerequisites

Ensure you have the following prerequisites installed on your system:

1. **PHP 8.2+**
2. **Composer**
3. **PostgreSQL**
4. **Node.js** and **NPM**

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

4. Create a new PostgreSQL database:

   ```sql
   CREATE DATABASE dandelines
   ```

5. Apply database migrations:

	```bash
	php artisan artisan migrate
	```

6. Seed the database with test data:

   ```bash
    php artisan artisan db:seed
   ```
   
7. Serve the PHP application:

    ```bash
    php artisan serve
    ```

8. Compile assets and run the Vue frontend:

   ```bash
   npm run dev
   ```
