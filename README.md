# Dandelines Design

Simplify your budgeting.

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
