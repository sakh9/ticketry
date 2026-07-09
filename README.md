 
File: README.md

```markdown
# ticketry.

A Laravel-based event ticketing platform connecting organizers and visitors.

---

## Features

### Organizer
- Create event proposals with multiple ticket types
- Upload venue permits and event plans
- Real-time location availability checking
- Sales dashboard with revenue breakdown
- Monthly income reports
- Banking information management
- Profile with logo, social media, and category

### Visitor
- Browse events with search and filters (category, city, online/offline)
- Purchase tickets (max 4 per order)
- Free tickets skip payment, paid tickets via virtual account
- Download PDF tickets with QR codes
- Order history with status tracking

### Admin
- Review proposals with checklist system
- Approve/reject with reviewer tracking
- Monthly reports with PDF download
- User management with ban system
- Location management
- Admin management (create/delete other admins)
- RBAC via Spatie Laravel Permission

---

## Tech Stack

- **Backend:** Laravel 13, PHP 8.3
- **Database:** PostgreSQL
- **Frontend:** Bootstrap 5, JavaScript
- **PDF:** barryvdh/laravel-dompdf
- **RBAC:** spatie/laravel-permission
- **QR Code:** simplesoftwareio/simple-qrcode

---

## Installation

1. Clone the repository
```bash
git clone https://github.com/sakh9/ticketry.git
cd ticketry
```

2. Install dependencies

```bash
composer install
```

3. Copy environment file

```bash
cp .env.example .env
```

4. Configure your database in .env

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ticketryDB
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

5. Generate application key

```bash
php artisan key:generate
```

6. Run migrations and seeders

```bash
php artisan migrate --seed
```

7. Assign roles to users

```bash
php artisan cikieto:assign-roles
```

8. Start the server

```bash
php artisan serve
```

9. Access the application at http://127.0.0.1:8000

---

Default Credentials

Role Email Password
Admin admin@ticketry.com password123
Organizer Register at /register -
Visitor Register at /register -

---

Scheduled Tasks

Run the scheduler for auto-closing past events:

```bash
php artisan schedule:run
```

Or add to crontab:

```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

---

Commands

Command Description
php artisan events:close-past Close events past end time
php artisan tickets:release-expired Release expired reservations
php artisan cikieto:assign-roles Assign roles to all users
php artisan cikieto:create-admin Create new admin via CLI

---

License

This project is for educational purposes.

```

---

Then push to GitHub:

```bash
git add README.md
git commit -m "Add README"
git push
```



<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

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

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
