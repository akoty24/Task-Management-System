# Task Management System

## Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd task-management-system
   ```
2. **Install PHP dependencies**
   ```bash
   composer install
   ```
3. **Install frontend assets (if using Vite)**
   ```bash
   npm install
   npm run dev
   ```
4. **Generate application key**
   ```bash
   php artisan key:generate
   ```
5. **Run database migrations**
   ```bash
   php artisan migrate
   ```
6. **Seed the database with sample data**
   ```bash
   php artisan db:seed
   ```
7. **Start the development server**
   ```bash
   php artisan serve
   ```

## Environment Setup

Create a copy of the example environment file and configure your environment variables:
```bash
cp .env.example .env
```
Edit `.env` and set the following variables as needed:

- `APP_NAME` – Application name.
- `APP_ENV` – `local` for development.
- `APP_KEY` – Generated in step 4.
- `APP_DEBUG` – `true` for local development.
- `APP_URL` – URL where the app will be accessed (e.g., `http://localhost:8000`).
- `DB_CONNECTION` – Database driver (e.g., `mysql`).
- `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` – Your database credentials.
- `MAIL_MAILER`, `MAIL_HOST`, etc. – Mail configuration if you need email notifications.

After updating the file, run:
```bash
php artisan config:cache
```

## API Documentation

All API routes are defined in `routes/api.php` and are prefixed with `/api`.

### Authentication
- The API expects an authenticated user (via Laravel Sanctum or Passport). Adjust middleware as needed.

### Endpoints
| Method | URI | Description |
|--------|-----|-------------|
| `GET` | `/api/projects` | List all projects (supports pagination via `?page=` and `?per_page=`). |
| `POST` | `/api/projects` | Create a new project.
| `GET` | `/api/projects/{id}` | Retrieve a single project.
| `PUT/PATCH` | `/api/projects/{id}` | Update a project.
| `DELETE` | `/api/projects/{id}` | Soft‑delete a project.
| `GET` | `/api/projects/{projectId}/tasks` | List tasks for a project (supports pagination and filters: `status`, `priority`, `search`, `per_page`). |
| `POST` | `/api/projects/{projectId}/tasks` | Create a new task under a project.
| `GET` | `/api/tasks/{id}` | Retrieve a single task.
| `PUT/PATCH` | `/api/tasks/{id}` | Update a task.
| `DELETE` | `/api/tasks/{id}` | Soft‑delete a task.

All responses follow a unified JSON structure provided by the `ApiResponse` helper, e.g.:
```json
{
  "success": true,
  "message": "Tasks retrieved successfully",
  "data": [...],
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 73,
    "from": 1,
    "to": 15
  }
}
```
Error responses contain `success: false`, `message`, and optionally `errors` and `error_code`.

---
*Feel free to expand this documentation with request payload schemas and additional details.*

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

## Postman Collection

The Postman collection for this API is available in the project root: [task_mangament_system.postman_collection.json](file:///c:/Mohamed%20Saber/New%20folder/task-management-system/task_mangament_system.postman_collection.json)

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
