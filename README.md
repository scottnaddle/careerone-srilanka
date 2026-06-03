# CareerOne — TVET Career Platform (Sri Lanka)

A comprehensive career guidance and job matching platform for Sri Lanka's TVET sector, connecting Trainees, Companies, Career Guidance Officers (CGOs), and Administrators.

## Tech Stack

- **Backend**: Laravel 11, PHP 8.2
- **Admin Panel**: Filament 3.3.36
- **Database**: PostgreSQL (production) / SQLite (development)
- **Frontend**: Blade + Tailwind CSS + Vite
- **Auth**: Multi-guard (trainee, company, cgo, admin)

## Key Features

- 4 user types: Trainee, Company, CGO, Administrator
- Career guidance & counseling system
- OJT and Job matching with CGO recommendations
- Portfolio management for trainees
- Career tests (4 types including Career Key Test)
- Content management (videos, documents) with TVEC approval workflow
- Multi-language support (English, Sinhala, Korean)
- Dark mode support
- Google OAuth social login
- Magic Link passwordless login

## Recent Improvements (105 commits)

### Auth & Registration Modernization (Phase 7)
- Progressive Trainee signup: email + password only (75% field reduction)
- Real-time password strength meter
- Magic Link login (passwordless email-based auth)
- Google OAuth social login for all 3 user types
- Company Wizard 3-step unified registration
- Floating label inputs

### Homepage Redesign (Phase 8)
- Complete hero section with dark gradient + wave divider
- "Who Are You?" 3-card user type navigation
- Trust statistics bar with live DB counts
- 2-tier header (utility bar + main nav)
- Distinct login screens per user type
- Vanilla JS dropdown menus

### Admin Panel Modernization (Phase 9-10)
- CareerOne Admin branding (name, logo, favicon)
- Dark mode, global search, language switcher
- Full-width content (maxContentWidth: Full)
- Collapsible sidebar, unsaved changes alerts
- Striped tables on all resources
- ILIKE→LIKE (SQLite/PostgreSQL compatibility)
- Cumulative filter narrowing (Province→District→Divisional)
- DatePicker filters on all main resources
- Admin filter audit & fixes (72 resources checked)

### PDM Dashboard
- 8 key metrics: Career Tests, Trainees, Portfolios, Companies, Institutes, CGO, Content
- OJT + Job Vacancy detail sections with matched/company stats
- All cards clickable → detail pages
- Counts synced with Dashboard Overview criteria

## Quick Start

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
```

## PDM Dashboard

`/admin/pdm-dashboard` — Platform Development Metrics:
- Career Tests: **3,292(1,211) / 1,771(807)** [all types / Career Key Test]
- Trainees: 12,264 | Portfolios: 1,535 | Companies: 243
- Institutes: 4,140 | CGO: 305
- Content: Videos 29, Documents 183 (TVEC approved)
- OJT: 11 total (5 matched) | Jobs: 41 total (32 matched)

## Documentation

- `IMPROVEMENTS.md` — full quality improvements report
- `UI_UX_MODERNIZATION.md` — UI/UX analysis & recommendations
- `SIGNUP_MODERNIZATION.md` — signup modernization plan
- `HOMEPAGE_IA_ANALYSIS.md` — homepage IA analysis
- `COMPANY_REG_REFACTOR.md` — company registration refactoring

## Repository

https://github.com/scottnaddle/careerone-srilanka (private)
