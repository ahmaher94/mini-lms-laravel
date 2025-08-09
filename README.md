# Mini LMS Laravel

## Architecture Overview

This project follows a **Modular Monolithic architecture**, where each domain (such as `Course`, `User`, `Session`) is encapsulated in its own module inside the `app/Modules` directory.

Each module maintains separation of concerns using a mix of:

### Layered Architecture

-   `Controllers` → `Services` → `Repositories`

### and follows Onion dependency principles for maintainability and testability.

-   **Infrastructure code** exists on the outer layers
-   **Dependencies point inward** (e.g., services depend on interfaces, not implementations)

This structure promotes decoupling, testability, and maintainability.

```
app/Modules/<ModuleName>/
├── Domain/
│   ├── Models/          # Eloquent models for the domain
│   └── Contracts/       # Repository interfaces
├── Repositories/        # DB implementations (Eloquent)
├── Services/           # Business logic / use-cases
├── Http/               # Controllers, FormRequests, Resources
└── Database/           # Module-specific migrations/seeders/factories
```

## Key Features

-   Dockerized Laravel setup with MySQL and Redis with seeded data
-   Complete CRUD operations for Courses with role-based access
-   Clean architecture using Service/Repository pattern
-   RESTful API with Laravel Sanctum authentication
-   Feature test for course operations

## Technology Stack

-   **Backend Framework:** Laravel 12.x
-   **Language:** PHP 8.2+
-   **Database:** MySQL 8+
-   **Cache:** Redis
-   **Authentication:** Laravel Sanctum
-   **Containerization:** Docker & Docker Compose
-   **Testing:** PHPUnit

## Prerequisites (only needed for traditional setup)

-   PHP >= 8.2
-   Composer
-   MySQL 8+
-   Docker & Docker Compose (for containerized development)

## Installation

### Option 1: Traditional Setup

1. **Clone the repository**

    ```bash
    git clone https://github.com/ahmaher94/mini-lms-laravel.git
    cd mini-lms-laravel
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. \*\*Configure `.env`

    - Set `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

5. **Run migrations**

    ```bash
    php artisan migrate --seed
    ```

6. **Start the Laravel server**
    ```bash
    php artisan serve
    ```

### Option 2: Docker Setup

1. **Clone the repository**

    ```bash
    git clone https://github.com/ahmaher94/mini-lms-laravel.git
    cd mini-lms-laravel
    ```

2. **Build and start containers**

    ```bash
    docker-compose up -d --build
    ```

3. **Install dependencies and generate app key**

    ```bash
    docker-compose exec app composer install
    docker-compose exec app cp .env.example .env
    docker-compose exec app php artisan key:generate
    ```

4. **Configure `.env` for Docker services**

    Update your `.env` file to match the services defined in `docker-compose.yml`:

5. **Run migrations**

    ```bash
    docker-compose exec app php artisan migrate --seed
    ```

6. **Fix permissions (if needed)**
    ```bash
    docker-compose exec app chmod -R 775 storage bootstrap/cache
    ```

## Running Tests

-   **Traditional setup:**

    ```bash
    php artisan test
    ```

-   **Docker setup:**
    ```bash
    docker-compose exec app php artisan test
    ```

## Seeded User Credentials

After running migrations with seeds, you can use these test credentials:

| Role        | Email               | Password   |
| ----------- | ------------------- | ---------- |
| **Admin**   | `admin@gmail.com`   | `password` |
| **Teacher** | `teacher@gmail.com` | `password` |
| **Student** | `student@gmail.com` | `password` |

### API Usage

-   **Login endpoint:** `POST /api/v1/login`

    Example request body:

    ```json
    {
        "email": "teacher@gmail.com",
        "password": "password"
    }
    ```

## Postman Collection

For easier API testing, a Postman collection is included in the repository with:

-   Pre-configured requests for all endpoints
-   Environment variables for base URL and authentication tokens
-   Test credentials already set up for quick testing

    -   **Postman Collection:** [`postman-collection.json`](./postman_collection.json) - Ready-to-import collection with all endpoints
