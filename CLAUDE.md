# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Install PHP dependencies
composer install

# Install JS dependencies and build assets
npm install && npm run build

# Development asset watching
npm run dev

# Run all tests
php artisan test

# Run a single test file
php artisan test tests/Feature/SomeTest.php

# Run a specific test method
php artisan test --filter=testMethodName

# Database migrations
php artisan migrate

# Clear caches
php artisan optimize:clear
```

## Architecture Overview

This is a **Laravel 10** application — a Sri Lanka government career guidance platform with three distinct user-facing interfaces and a shared admin panel.

### User Roles & Route Files

| Route file | Audience | Auth mechanism |
|---|---|---|
| `routes/api.php` | Mobile/SPA trainees | Laravel Passport/Sanctum tokens |
| `routes/trainee.php` | Trainees (web) | CAS SSO (`apereo/phpcas`) |
| `routes/company.php` | Company recruiters | Standard Laravel auth |
| `routes/cgo.php` | Career Guidance Officers | Standard Laravel auth |
| `routes/admin.php` | Admins | Filament auth |
| `routes/web.php` | Public pages | None |

### Admin Panel — Filament v3

`app/Filament/` contains the entire admin UI built with [Filament](https://filamentphp.com/):
- `Resources/` — CRUD resource classes (each paired with a `*Resource/` directory containing Pages)
- `Pages/` — standalone admin pages
- `Widgets/` — dashboard widgets
- Shield (`bezhansalleh/filament-shield`) handles role-based access; roles/permissions are managed via `AdminRoleResource`

### API Layer

`app/Http/Controllers/Api/Trainee/` contains all trainee mobile API controllers, organized by domain (Auth, Information, JobSupport, CareerGuidance, MyPage, Counseling, Notifications). CGO-specific API controllers live in `Api/Cgo/`.

### Services

`app/Services/` is grouped by actor:
- `Trainee/`, `Cgo/`, `Company/`, `Admin/` — domain-specific business logic
- `EmailService.php`, `ESMSService.php` — transactional comms
- `NotificationService.php` — multi-channel notifications (Firebase push via `kreait/firebase-php` + Pusher)

### Key Integrations

- **Firebase** (`config/firebase.php`) — push notifications to mobile
- **CAS SSO** — trainee web login via institutional SSO
- **Spatie Media Library** — file/image management for all entities
- **Spatie Permission** — role/permission enforcement
- **Maatwebsite Excel** — imports/exports in `app/Imports/` and `app/Exports/`
- **DomPDF + Spatie PDF** — PDF generation
- **Redis** (`predis/predis`) — cache and queues

### Frontend

Blade + Livewire for web views (`resources/views/`, `app/Livewire/`). Tailwind CSS compiled via Vite (`vite.config.js`). Livewire components are minimal — most interactive UI is in Filament.

### Testing

Tests use the actual configured database (SQLite in-memory is commented out in `phpunit.xml`). Ensure a test database is configured before running the suite.
