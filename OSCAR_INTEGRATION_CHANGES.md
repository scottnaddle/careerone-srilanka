# Oscar Source Integration — Detailed Change Report

> **Target branch**: `fix/oscar-issues` (HEAD `0ecf69c`)
> **Baseline**: `67a60a0` (`integrated-with-dev-20260603`, just before Oscar sync)
> **Backup branch**: `backup/pre-refactor-2026-06-21` (pushed to `origin`, commit `3fbb37d`)
> **Total scope**: **469 files changed, +25,367 / -7,681** across 3 commits
> **Report date**: 2026-06-21

---

## 1. Executive Summary

This report documents every meaningful change introduced into `fix/oscar-issues` by the
integration of Oscar's (external developer) source plus the local security/stability
overlay that followed.

| Commit | Author | Theme | Files | +/− |
|--------|--------|-------|------:|----:|
| `9b9c246` | Oscar | Sync up to 2026-06-05 (Blade overhaul, route tweaks) | 278 | +12,810 / −10,501 |
| `f9b93a6` | Oscar | Newest source + ~30% AI review pass (Policies, Filament, API) | 424 | +25,625 / −10,255 |
| `0ecf69c` | Local | Security/login/null-safety overlay | 14 | +29 / −22 |
| **Total** | — | — | **469** | **+25,367 / −7,681** |

### What arrived from Oscar

- **39 new Policies** (`app/Policies/*`) — Filament admin resources backed by `can('…')` permission gates
- **1 new middleware** — `CheckAdminUserLoggedIn`
- **13 new API controllers** under `app/Http/Controllers/Api/Trainee/*` (mobile trainee API surface)
- **8 new Vue components** under `resources/js/` (portfolio wizard + step components)
- **1 new Filament widget** — `GoogleAnalyticsWidget`
- **1 new service** — `GoogleAnalyticsService`
- **1 new PHPUnit test** — `tests/Unit/TraineeExportCgoTest.php`
- **2 new blade partials** — `firebase-messaging.blade.php`, `google-analytics-widget.blade.php`
- **7 new migrations** (banners, soft-deletes, NVQ column type, performance indexes)
- **14 seeders** modified
- **77 Filament Resources / Pages / Widgets** modified (admin/CGO/company UI)
- **92 Blade templates** rewritten (homepage, signup, portfolio, auth)
- **All four route files** rewritten (`admin.php`, `cgo.php`, `api.php`, `web.php` + `trainee.php`/`company.php` touched)

### What the local overlay added

- **5 CGO content-management routes** lost `withoutMiddleware('cgo.auth')` → authentication restored
- **Company CV download** re-added to authenticated middleware set
- **OJT controllers** received `company.auth` constructor middleware (with CGO exceptions)
- **3 broken login flows** restored (Trainee `school_kids` → `trainee_users`, SchoolKid `schoolkids` → `school_kids`)
- **2 latent 500s** null-safety fixed (Counseling `show`, Overview widget)
- **Dead `dd()` debug calls** removed from 2 controller methods
- **Filament Admin** darkMode + globalSearch enabled by default
- **Portfolio IDOR** closed (`public_portfolio` ownership check)

---

## 2. Detailed Change Log

### 2.1 Commit `9b9c246` — `oscar update up to 2026/06/05`

> External sync of Oscar's working copy up to 2026-06-05. Frontend-heavy release.

#### Routes changed

**`routes/admin.php`** — refactored imports to FQCN style; moved QNA / career-test groups
inside the `auth:admin` middleware group; added a localized user-manual download route:

```diff
- use App\Http\Controllers\Admin\Auth\RegisterController;
- Route::controller(RegisterController::class)->group(function(){
+ Route::controller(\App\Http\Controllers\Admin\Auth\RegisterController::class)->group(function(){
      Route::group(['prefix'=>'auth','as'=>'auth.'], function(){
          Route::get('/register', 'register')->name('register');
          ...
      });
- });
-
- Route::controller(LoginController::class)->group(function(){
-     Route::group(['prefix'=>'auth','as'=>'auth.'], function(){
-         Route::post('/login', 'postLogin')->name('login-post');
-         ...
-     });
- });
+ Route::middleware('auth:admin')->group(function(){
      Route::group(['prefix' => 'career-test', 'as' => 'career-test.'], function(){
          ...
      });
+     Route::group(['prefix' => 'qnas', 'as' => 'qnas.'], function() {
+         ...
+     });
+     Route::get('/download-user-manual', function () {
+         $language = App::getLocale();
+         $filePath = match ($language) {
+             'en' => public_path('files/CareerPlatform_UserManual(Administrator)(en)_v1.0.pdf'),
+             'tm' => public_path('files/CareerPlatform_UserManual(Administrator)(en)_v1.0.pdf'),
+             'sn' => public_path('files/CareerPlatform_UserManual(Administrator)(sin)_v1.0.pdf'),
+             ...
+         };
+         ...
+     });
```

**`routes/web.php`** — moved `auth:admin` middleware off bare utility routes (`/admins`,
`/deploy/run`) and consolidated them as public; commented-out the
`/filament/exports/{export}/download` route that bypassed `auth` (later reinstated in `f9b93a6`).
Also added a `/dispatch-portfolios-job` route later removed in `f9b93a6`. SMS debug helper
`/test-sms-simple` had its hard-coded phone number and loop count swapped.

**`routes/api.php`** — uncommented the trainee API login route:

```diff
- // Route::post('/login', [App\Http\Controllers\Api\Trainee\AuthController::class, 'login'])->name('login');
+ Route::post('/login', [App\Http\Controllers\Api\Trainee\AuthController::class, 'login'])->name('login');
```

#### Blade template overhaul (largest single area)

- `resources/views/homepage/index.blade.php` — +582 / −(comparable) — major homepage
  re-skin: hero, sector tiles, news, career guidance cards.
- `resources/views/homepage/layouts/master.blade.php` — header/footer restructure.
- `resources/views/trainee/auth/signup.blade.php` — full rewrite (+891 lines) with multi-step form.
- `resources/views/trainee/auth/signup-manual.blade.php` — companion manual signup template.
- `resources/views/portfolio/create.blade.php`, `portfolio/show.blade.php`, `portfolio/preview.blade.php` — all rebuilt.
- `resources/views/homepage/career-test/career-interest-test.blade.php`, `career-key-test.blade.php` — rewritten.
- `resources/views/homepage/accessibility/accessibility-pc.blade.php` — accessibility statement page.
- `resources/views/homepage/partials/{news,sector}.blade.php` — homepage partials.
- `resources/views/informations/events/{create,edit}.blade.php` — event forms.
- `resources/views/informations/qnas/reply.blade.php` — QNA reply view.
- `resources/views/livewire/{carrer-test,counseling-all-search}.blade.php` — Livewire templates.
- `resources/views/schoolkid/auth/{signin,signup}.blade.php` and `forgot-password/{change-password,enter-mail}.blade.php` — auth flow updates.

#### Other

- `routes/cgo.php` — added CGO `my-page.trainee-report.export` route.
- `app/Filament/Resources/*` — initial round of resource page UI tweaks.
- `database/seeders` — initial seeder bumps.

#### Side-effect assessment

- ⚠️ **QNA / career-test admin routes** moved into the `auth:admin` group — affected URLs
  are now auth-gated (intended).
- ✅ Trainee API login endpoint re-enabled.
- ⚠️ `/admins` and `/deploy/run` lost `auth:admin` middleware (became public). The deploy
  route is sensitive — this was later re-evaluated, but not fixed until further commits.

---

### 2.2 Commit `f9b93a6` — `updated: newest version and about 30% AI review processing`

> Oscar's main delivery: source upgrade + first round of an AI-review pass that
> generated Policies for every Filament resource and rewrote a large share of admin screens.
> **424 files, +25,625 / −10,255, 61 new files.**

#### 2.2.1 New Policies (39 files)

A standard `App\Policies\*Policy` class generated for each Filament resource, all
implementing the Filament `HandlesAuthorization` trait and delegating to permission
strings (e.g. `view_any_career::test`). Pattern (sample from `CareerTestPolicy`):

```php
class CareerTestPolicy
{
    use HandlesAuthorization;

    public function viewAny(AdminUser $adminUser): bool
    {
        return $adminUser->can('view_any_career::test');
    }

    public function view(AdminUser $adminUser, CareerTest $careerTest): bool
    {
        return $adminUser->can('view_career::test');
    }

    public function create(AdminUser $adminUser): bool   { return $adminUser->can('create_career::test'); }
    public function update(AdminUser $adminUser, CareerTest $careerTest): bool { return $adminUser->can('update_career::test'); }
    public function delete(AdminUser $adminUser, CareerTest $careerTest): bool { return $adminUser->can('delete_career::test'); }
    ...
}
```

Full list (39 new files):

```
ActivityPolicy            AdminUserPolicy        BannerCategoryPolicy
BannerPolicy              CareerExpertInterviewPolicy   CareerGuidanceCategoryPolicy
CareerGuidancePolicy      CareerTestPolicy       CgoCounselingPolicy
CgoUserPolicy             CodeManagementPolicy   CompanyPolicy
CompanyRecruiterPolicy    ContentPolicy          EnterprisePolicy
EventPolicy               ExceptionPolicy        ExportPolicy
FaqArticlePolicy          FaqPolicy              FolderPolicy
InstitutePolicy           JobInformationPolicy   JobPolicy
MediaPolicy               MenuPolicy             NVQLevelPolicy
NewLetterPolicy           NewsletterCategoryPolicy   NoticePolicy
NvqCoursesPolicy          OJTPolicy              PolicyCategoryPolicy
PolicyPolicy              PortfolioPolicy        QNAPolicy
ReqCoursePolicy           RolePolicy             TraineeUserPolicy
```

#### 2.2.2 New middleware

`app/Http/Middleware/CheckAdminUserLoggedIn.php`

```php
class CheckAdminUserLoggedIn
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('filament.admin.auth.login');
        }
        return $next($request);
    }
}
```

Companion to the existing `CheckCgoUserLoggedIn` and `CheckCompanyUserLoggedIn`.

#### 2.2.3 New API controllers (13 under `Api/Trainee/`)

```
Api/Trainee/AuthController.php          (re-enabled, see 2.2.5 below)
Api/Trainee/BaseController.php
Api/Trainee/CareerGuidanceController.php
Api/Trainee/CommonController.php
Api/Trainee/EmploymentController.php
Api/Trainee/HomeController.php
Api/Trainee/InformationController.php
Api/Trainee/JobSupportController.php
Api/Trainee/MobileAppVersionController.php
Api/Trainee/MyPageController.php
Api/Trainee/NotificationController.php
Api/Trainee/PortfolioController.php
Api/Trainee/TraineeCounselingController.php
```

Plus at top level: `Api/KeepTraineeController.php`, `Api/NotificationController.php`,
`Api/TraineeMatchController.php`. The mobile-app API surface is fully wired up in this commit.

#### 2.2.4 New Vue / Blade / Service / Widget / Test assets

| File | Purpose |
|------|---------|
| `resources/js/components/PortfolioWizard.vue` | Multi-step portfolio wizard |
| `resources/js/components/Step*.vue` (×8) | `StepProfileBasics`, `StepEducationBackground`, `StepExperience`, `StepGoalType`, `StepOjtQuestion`, `StepTechnicalSkills`, `StepWorkEnvironment`, `StepCareerFields`, `StepReview`, `FlowbiteDatepicker` |
| `resources/views/components/firebase-messaging.blade.php` | FCM push partial |
| `resources/views/components/google-analytics-widget.blade.php` | GA widget partial |
| `app/Filament/Widgets/GoogleAnalyticsWidget.php` | Live GA widget for admin |
| `app/Services/GoogleAnalyticsService.php` | GA data fetcher |
| `tests/Unit/TraineeExportCgoTest.php` | Export translatable-array mapping tests (117 LOC) |
| `public/files/premium_resume_template.rtf` | New resume template |

#### 2.2.5 Routes rewritten

**`routes/web.php`** — re-added `Filament\Actions\Exports\Http\Controllers\DownloadExport`
route (without `auth` middleware, matching Filament's expectation):

```diff
+ Route::get('/filament/exports/{export}/download', DownloadExport::class)
+     ->name('filament.exports.download')
+     ->withoutMiddleware(['auth']);
```

Removed `/dispatch-portfolios-job` (now triggered via scheduler instead).
SMS debug helper restored to original phone number (`+94762766230`) and loop count
(`200` iterations).

**`routes/admin.php`** — added a duplicate `career-tests/export` route (later cleaned up
by the local overlay):

```diff
  Route::group(['prefix' => 'career-test', 'as' => 'career-test.'], function(){
      Route::get('/view-result/{id}', ...);
      Route::get('/download-result/{id}', ...);
-     });
+     Route::get('/export', [CareerTestController::class, 'export'])->name('career-tests.export');
+ })->withoutMiddleware('admin');
+ Route::get('/career-tests/export', [CareerTestController::class, 'export'])->name('career-tests.export');
```

**`routes/cgo.php`** — added `cgo.auth` middleware to the `job-support` group
(protecting all `/cgo/job-support/*` routes):

```diff
- Route::group(['prefix' => 'job-support', 'as' => 'job-support.'], function () {
+ Route::group(['prefix' => 'job-support', 'as' => 'job-support.', 'middleware' => ['cgo.auth']], function () {
```

**`routes/api.php`** — minor: `/login` route confirmed active.

#### 2.2.6 Console / Scheduler

`app/Console/Kernel.php` — registered `\App\Console\Commands\SendMonthlyReport::class`,
added scheduling for `cgo:send-inactive-reminder`, `report:monthly`, and `appendOutputTo`
log files for all jobs:

```php
$schedule->command('cgo:send-inactive-reminder --days=30')
    ->dailyAt('09:00')
    ->withoutOverlapping()
    ->appendOutputTo(storage_path("logs/cgo-reminder-{$today}.log"));

$schedule->command('report:monthly')
    ->monthlyOn(1, '00:00')
    ->timezone('Asia/Colombo')
    ->appendOutputTo(storage_path("logs/monthly-report-{$today}.log"))
    ->emailOutputOnFailure('admin@yourdomain.com');
```

Modified commands: `SendInactiveCgoReminder`, `SendMonthlyReport`, `SendRecruiterEmails`,
`SyncApiData`, `SyncTraineeDataFromTVEC`, `UpdateActivityLogGuard`.

#### 2.2.7 Exports

| File | Change |
|------|--------|
| `app/Exports/CareerTestExport.php` | +269 LOC — column mapping for career test export |
| `app/Exports/TraineeExporter.php` | +8 — general trainee export |
| `app/Exports/TraineeListExportCgo.php` | +156 — CGO trainee list export with translatable columns |
| `app/Exports/TraineeReportExportCgo.php` | +20 — CGO trainee report export |

#### 2.2.8 Filament Resources / Pages / Widgets modified (57 resources, 8 pages, 16 widgets)

Notable resources (each +/− 100s of lines):

- `AdministratorResource.php` (+355 LOC) — full admin CRUD UI rebuild
- `CGOResource.php` (+416 LOC) — CGO management UI overhaul
- `CompanyResource.php` (+460 LOC) — company management overhaul
- `CounselingListResource.php` (+401 LOC)
- `EventListResource.php` (+468 LOC)
- `TraineeResource.php` (+593 LOC)
- `ApprovedCGODetailResource.php` (+377 LOC)
- `CareerTestResource/Pages/CareerTestLists.php` (+477 / −129) — large page rebuild
- `ComapnyUserListResource.php` (+131), `CompanyJobResource.php` (+57),
  `CompanyRecruiterApprovalResource.php` (+53)
- `AdministratorApprovalDetail.php` (+142 / −replaced)
- `OJTResource.php` (+43), `JobResource.php` (+53), `PopupResource.php` (+10)

Filament Pages modified (8):

- `Auth/EditProfile.php` (-75), `Auth/Login.php` (+7)
- `Dashboard/{Overview, CgoPerformance, InstitutePerformance}.php` (+41 / +29 / +31)
- `PdmDashboard.php` (+196)
- `EmergencyUserReset.php` (+6)
- `AdministratorApprovalListResource/AdministratorApprovalDetail.php` (+142)

Filament Widgets modified (16):

`AdministratorApprovalListtable`, `CGOApprovalListtable` (+339), `CgoCounselingStatsWidget`,
`CgoUserHeatmapWidget`, `GoogleAnalyticsWidget` (new), `GuidanceCompletionWidget`,
`JobAppliesAndMatchesChart`, `MemberSignupChartWidget`, `MemberSignupTableWidget`,
`MonthlyJobsAndOjtsChart`, `NaitaOverview`, `NvqLevelPyramid`, `OjtAppliesAndMatchesChart`,
`OverviewWidgets`, `ShowCountInformation`, `SriLankaDistrictMapWidget`.

#### 2.2.9 Filament Resources created (new View pages)

Several resources got new `View` pages:

- `AdministratorResource/Pages/{ViewAdmin.php, EditAdministrator.php}`
- `CGOResource/Pages/ViewCGO.php`
- `ComapnyUserListResource/Pages/{CreateComapnyUserList.php, ListComapnyUserLists.php, ViewComapnyUserList.php}`
- `CompanyResource/Pages/{CreateCompany.php, EditCompany.php, ListCompanies.php, ViewCompany.php}`
- `CompanyJobResource/Pages/ViewJobCandidate.php`
- `CompanyRecruiterApprovalResource/Pages/{ListCompanyRecruiterApprovals.php, ViewCompanyRecruiterApproval.php}`
- `DocumentResource/Pages/ViewDocument.php`, `VideoResource/Pages/ViewVideo.php`
- `ResourceResource/Pages/ViewResource.php`
- `CounselingResource/Pages/ListCounselings.php`
- `CareerTestResource/Pages/ListCareerTests.php`
- `PopupResource/Pages/ListPopups.php`

#### 2.2.10 Migrations added (7)

```
2024_02_18_024959_create_banner_categories_table.php
2024_02_18_043023_create_banners_table.php
2024_09_26_091814_create_activity_log_table.php
2026_06_02_070858_add_soft_deletes_to_companies_table.php
2026_06_10_133339_alter_trainee_n_v_q_s_nvq_id_column_type.php
2026_06_10_141112_change_nvq_id_type_in_trainee_n_v_q_s_table.php
2026_06_19_000000_add_performance_indexes.php
```

The last migration adds DB indexes for performance. Migration timestamps span pre-2024
through June 2026 (deliberate re-numbering).

#### 2.2.11 Seeders modified (14)

`BannersTableSeeder`, `BlogCategoriesTableSeeder`, `CareerGuidanceCategorySeeder`,
`CategorySystemSeeder`, `CompanySeeder`, `ContentSeeder`, `EventsTableSeeder`,
`JobInformationSeeder`, `JobSeeder`, `MenuTableSeeder`, `NaitaRecruiterSeederTest`,
`PermissionSeeder`, `QnASeeder`, `RegisterCompany`.

#### 2.2.12 Services modified (12)

`Admin/{ContentService, CounselingService, JobService, SearchComponentAdminService,
api/ExternalApiService}`, `Company/JobVacancyService`, `ESMSService`,
`GoogleAnalyticsService` (new), `Trainee/{NotificationManager, ProvincesDistrictsService,
TraineeCasSyncService, TraineeJobService}`.

#### 2.2.13 Models modified (8)

`AdminUser`, `CgoUser`, `CodeManagement`, `Company`, `District`, `Event`, `SchoolKid`,
`TraineeUser` — mostly cast / relation / fillable adjustments.

#### 2.2.14 Models deleted / renamed

No files were deleted or renamed in the Oscar sync window. All changes are
additive or in-place modifications.

#### 2.2.15 Side-effect assessment for `f9b93a6`

- ✅ Admin policy gating now goes through Filament permission system (requires
  permissions seeded by `PermissionSeeder`).
- ⚠️ `/admin/career-test/export` is duplicated (under two different route names); no
  immediate user impact, but flagged for cleanup.
- ⚠️ `/filament/exports/{export}/download` runs without `auth` — required by Filament's
  signed-URL flow, but worth confirming exports are signed.
- ⚠️ `/admin` and `/deploy/run` are still public from `9b9c246` change — flagged.
- ✅ CGO `/job-support/*` is now fully authenticated.
- ✅ Mobile trainee API surface complete (13 controllers).
- ⚠️ Performance indexes migration must be reviewed for FK ordering on production.

---

### 2.3 Commit `0ecf69c` — `fix: CGO/Admin security, login bugs, null-safety, dead code`

> Local security/stability overlay applied on top of Oscar's integration.
> **14 files, +29 / −22.** This commit fixed real security holes and broken user flows
> introduced (or revealed) by Oscar's sync.

#### 2.3.1 Security — CGO content management routes

`routes/cgo.php` — removed 5 `withoutMiddleware('cgo.auth')` flags that bypassed
authentication on CGO content-management endpoints:

| URL | Method | Was | Now |
|-----|--------|-----|-----|
| `/cgo/informations/content-management/videos/post` | POST | `web` only | `web` + `CheckCgoUserLoggedIn` |
| `/cgo/informations/content-management/videos/show/{slug}` | GET | `web` only | `web` + `CheckCgoUserLoggedIn` |
| `/cgo/informations/content-management/documents/show/{id}` | GET | `web` only | `web` + `CheckCgoUserLoggedIn` |
| `/cgo/informations/content-management/documents/download/{id}` | GET | `web` only | `web` + `CheckCgoUserLoggedIn` |
| `/cgo/informations/content-management/resource/download/{id}` | GET | `web` only | `web` + `CheckCgoUserLoggedIn` |

```diff
- Route::post('post', [ContentManagementController::class, 'postVideos'])->name('post')->withoutMiddleware('cgo.auth');
+ Route::post('post', [ContentManagementController::class, 'postVideos'])->name('post');
- Route::get('show/{slug}', [ContentManagementController::class, 'getVideos'])->name('show')->withoutMiddleware('cgo.auth');
+ Route::get('show/{slug}', [ContentManagementController::class, 'getVideos'])->name('show');
- Route::get('show/{id}', [ContentManagementController::class, 'getDocuments'])->name('show')->withoutMiddleware('cgo.auth');
+ Route::get('show/{id}', [ContentManagementController::class, 'getDocuments'])->name('show');
- Route::get('download/{id}', [ContentManagementController::class, 'downloadDocument'])->name('download')->withoutMiddleware('cgo.auth');
+ Route::get('download/{id}', [ContentManagementController::class, 'downloadDocument'])->name('download');
- Route::get('download/{id}', [\App\Http\Controllers\CGO\ResourceController::class, 'downloadDocument'])->name('download')->withoutMiddleware('cgo.auth');
+ Route::get('download/{id}', [\App\Http\Controllers\CGO\ResourceController::class, 'downloadDocument'])->name('download');
```

#### 2.3.2 Security — Company CV download

`app/Http/Controllers/Company/JobSupportController.php` — re-added `getCVOfTrainee` to
the authenticated route group (it had been excluded from auth, allowing CV leak):

```diff
- Route::middleware('auth:company')->except(['downloadFile', 'getCVOfTrainee']);
+ Route::middleware('auth:company')->except(['downloadFile']);
```

#### 2.3.3 Security — OJT controllers

`app/Http/Controllers/OJTController.php` — added `company.auth` constructor middleware:

```php
$this->middleware('company.auth')->except(['show']);
```

(`show` is also reachable via CGO routes under `cgo.auth`.)

`app/Http/Controllers/OJTMatchController.php`:

```php
$this->middleware('company.auth')->except(['store']);
```

(`store` is shared between Company and CGO flows.)

#### 2.3.4 Login bugs

| File | Before | After | Effect |
|------|--------|-------|--------|
| `app/Http/Requests/Trainee/Auth/LoginRequest.php` | `exists:school_kids,email` | `exists:trainee_users,email` | Trainee login was completely broken — wrong table |
| `app/Http/Requests/SchoolKid/Auth/LoginRequest.php` | `exists:schoolkids,email` (typo, missing underscore) | `exists:school_kids,email` | SchoolKid login was broken |
| `app/Http/Requests/SchoolKid/Auth/ResetPasswordRequest.php` | `exists:schoolkids,email` | `exists:school_kids,email` | SchoolKid password reset was broken |

#### 2.3.5 Null-safety / runtime crashes

`app/Http/Controllers/CGO/CounselingController.php` — `show()` accessed
`$objectCounselingList[0]` which raised "Undefined array key 0" 500 when
`cgoCounselingAssignHistory` was empty. Replaced with `->first()` + null-safe fallback.

`app/Filament/Pages/Dashboard/Overview.php` — guarded
`auth('admin')->user()->hasRole('super_admin')` with a null check so dashboard widgets
don't fatal when the user is not loaded yet.

#### 2.3.6 Admin UI polish

`app/Providers/Filament/AdminPanelProvider.php` — removed
`->darkMode(false)` and `->globalSearch(false)`, enabling both features by default.
Removed default `FilamentInfoWidget`.

#### 2.3.7 Dead-code cleanup

`app/Http/Controllers/Admin/QuestionAndAnswerController.php` — removed
`dd($id);` debug line in `destroy()`.

`app/Http/Controllers/Company/RegisterNewCompany.php` — removed
`dd($request->all());` debug line in `postRegister()`.

#### 2.3.8 Route cleanup

`routes/admin.php` — removed a no-op `->withoutMiddleware('admin')` on the
`career-test` group and the duplicate `career-tests.export` route:

```diff
  Route::group(['prefix' => 'career-test', 'as' => 'career-test.'], function(){
      Route::get('/view-result/{id}', [CareerTestController::class, 'viewResult'])->name('view-result');
      Route::get('/download-result/{id}', [CareerTestController::class, 'downloadResult'])->name('download-result');
-     Route::get('/export', [CareerTestController::class, 'export'])->name('career-tests.export');
- })->withoutMiddleware('admin');
+ });
  Route::get('/career-tests/export', [CareerTestController::class, 'export'])->name('career-tests.export');
```

Verified: no code or view references `admin.career-test.career-tests.export` —
safe to drop.

#### 2.3.9 IDOR fix

`app/Http/Controllers/Trainee/PortfolioController.php` —
`previewPortfolio()` now enforces ownership: only the owner or a portfolio with
`public_portfolio = 1` may be viewed. Previously any visitor could open any portfolio
by ID.

#### 2.3.10 Side-effect assessment for `0ecf69c`

| Item | Side effect |
|------|-------------|
| CGO content-management auth restored | Non-authenticated users are redirected to login (intended) |
| Company CV auth restored | Same |
| OJT controller middleware | `company.auth` applied in addition to group middleware; Laravel dedups safely |
| `OJTMatchController::store` exempted | Required because both Company and CGO call it via separate groups |
| Login bug fixes | Previously-broken login flows now succeed |
| Portfolio ownership check | Non-public + non-owner previews now error (intended) |
| `routes/admin.php` cleanup | Dropped route name `admin.career-test.career-tests.export` — confirmed unused |
| Dead `dd()` removed | No behavioral change |

---

## 3. New File Inventory (61 files in `f9b93a6`)

| Category | Count | Files |
|----------|-----:|-------|
| Policies | 39 | (full list in §2.2.1) |
| Vue components | 9 | `PortfolioWizard.vue` + 8 `Step*.vue` + `FlowbiteDatepicker.vue` |
| Blade partials | 2 | `firebase-messaging.blade.php`, `google-analytics-widget.blade.php` |
| Middleware | 1 | `CheckAdminUserLoggedIn.php` |
| API controllers | 13 | (listed in §2.2.3) |
| Filament Widget | 1 | `GoogleAnalyticsWidget.php` |
| Service | 1 | `GoogleAnalyticsService.php` |
| Migrations | 7 | (listed in §2.2.10) |
| Filament View pages | ~12 | (listed in §2.2.9) |
| PHPUnit test | 1 | `TraineeExportCgoTest.php` |
| Static asset | 1 | `premium_resume_template.rtf` |

---

## 4. Routes Touched — Summary

| File | Oscar-9b9c246 | Oscar-f9b93a6 | Local-0ecf69c |
|------|:---:|:---:|:---:|
| `routes/admin.php` | ✓ (refactor + new group + manual download) | ✓ (duplicate export) | ✓ (cleanup) |
| `routes/api.php` | ✓ (login re-enabled) | ✓ | — |
| `routes/cgo.php` | ✓ (trainee-report.export) | ✓ (job-support middleware) | ✓ (5x withoutMiddleware removed) |
| `routes/company.php` | — | ✓ | — |
| `routes/trainee.php` | — | ✓ | — |
| `routes/web.php` | ✓ (deploy/run public, dispatch-portfolios) | ✓ (filament exports restored, dispatch removed) | — |

---

## 5. Domain Distribution

| Area | Files | Notes |
|------|------:|-------|
| `app/Filament/Resources` | 77 | Admin UI rebuild (largest) |
| `resources/views` | 92 | Blade templates (home, signup, portfolio, auth) |
| `app/Http` | 49 | 13 new API controllers + middleware + Requests |
| `app/Policies` | 39 | New permission classes (Filament gating) |
| `public/portfolio` | 32 | Static assets |
| `public/files` | 29 | Documents / downloads |
| `resources/js` | 14 | Portfolio wizard + step components |
| `database/seeders` | 14 | Seed data |
| `lang/{en,sn,tm}` | 24 | i18n keys (8 each) |
| `app/Services` | 12 | Service layer updates |
| `app/Models` | 8 | Casts / relations |
| `database/migrations` | 7 | New tables / indexes |
| `app/Console` | 7 | Scheduler + commands |
| `app/Exports` | 4 | Excel/CSV exporters |
| `routes/*` | 6 | All four route files touched |
| `tests/Unit` | 1 | Export translatable-array tests |
| **Total** | **469** | — |

---

## 6. Verification Performed

| Check | Tool | Result |
|-------|------|--------|
| PHP 8.2 syntax (14 overlay files) | `php -l` | ✅ 14/14 PASS |
| Laravel bootstrap | `artisan --version` | ✅ PASS |
| Route registration (683) | `artisan route:list` | ✅ PASS |
| Middleware integrity | `artisan route:list -v` | ✅ PASS |
| Blade compile | `artisan view:cache` | ✅ PASS |
| Config cache | `artisan config:cache` | ✅ PASS |
| PHPUnit regression | `vendor/bin/phpunit --testdox` | ✅ No new failures (pre-existing 2 unchanged) |
| Diff stats | `git diff --stat 67a60a0..0ecf69c` | 469 files, +25,367 / −7,681 |

---

## 7. Files Touched by Overlay (`0ecf69c`) — 14

```
app/Filament/Pages/Dashboard/Overview.php                       (null guard on auth('admin'))
app/Http/Controllers/Admin/QuestionAndAnswerController.php     (removed dd($id))
app/Http/Controllers/CGO/CounselingController.php              (show() first() + null-safe)
app/Http/Controllers/Company/JobSupportController.php          (getCVOfTrainee re-auth)
app/Http/Controllers/Company/RegisterNewCompany.php            (removed dd($request->all()))
app/Http/Controllers/OJTController.php                         (+company.auth, except show)
app/Http/Controllers/OJTMatchController.php                    (+company.auth, except store)
app/Http/Controllers/Trainee/PortfolioController.php           (portfolio ownership check)
app/Http/Requests/SchoolKid/Auth/LoginRequest.php              (schoolkids → school_kids)
app/Http/Requests/SchoolKid/Auth/ResetPasswordRequest.php      (schoolkids → school_kids)
app/Http/Requests/Trainee/Auth/LoginRequest.php                (school_kids → trainee_users)
app/Providers/Filament/AdminPanelProvider.php                  (darkMode/globalSearch on, drop FilamentInfoWidget)
routes/admin.php                                               (drop no-op withoutMiddleware, drop duplicate export)
routes/cgo.php                                                 (drop 5x withoutMiddleware('cgo.auth'))
```

---

## 8. How to Restore the Pre-Oscar-Sync State

```bash
# Restore the backup branch
git switch backup/pre-refactor-2026-06-21

# Or restore individual files
git checkout backup/pre-refactor-2026-06-21 -- <path>

# Or diff against the backup
git diff fix/oscar-issues..backup/pre-refactor-2026-06-21
```

`backup/pre-refactor-2026-06-21` (commit `3fbb37d`) sits on top of `0ecf69c` and
adds the pre-refactor documentation/scaffolding — to roll back the Oscar sync itself,
target `67a60a0`:

```bash
git switch 67a60a0   # pre-Oscar baseline (integrated-with-dev-20260603)
```
