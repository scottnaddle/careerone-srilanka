# Oscar 통합 변경사항 리포트

> **대상 브랜치**: `fix/oscar-issues` (HEAD `0ecf69c`)
> **베이스라인**: `67a60a0` (`integrated-with-dev-20260603` — developer's 2026-05-27 소스 통합 직전)
> **백업 브랜치**: `backup/pre-refactor-2026-06-21` (origin 푸시 완료, 커밋 `3fbb37d`)
> **총 변경 규모**: **469 files changed, +25,367 / -7,681** (3 commits)

---

## 0. 백업 브랜치 확인

```bash
$ git ls-remote --heads origin | grep backup
3fbb37d…	refs/heads/backup/pre-refactor-2026-06-21   ← origin에 push 완료
```

리팩토링 시작 전 상태가 `backup/pre-refactor-2026-06-21` 브랜치로 보존되어 있습니다.
복구가 필요하면 `git switch backup/pre-refactor-2026-06-21` 또는
`git checkout backup/pre-refactor-2026-06-21 -- <path>` 로 가능합니다.

---

## 1. 커밋별 변경 요약

### 1.1 `9b9c246` — oscar update up to 2026/06/05
- **278 files, +12,810 / -10,501**
- 외부 개발자(oscar)가 6월 5일까지 작업한 소스 동기화
- 주된 변경 영역:
  - Blade 템플릿 전면 개편 (`homepage/index`, `trainee/auth/signup`, `homepage/career-test/*`, `portfolio/*` 등 대량 수정)
  - 라우트 (`admin.php`, `web.php`, `api.php`) 미들웨어/prefix 조정
  - Filament Resources 일부 페이지 UI 갱신
  - `database/seeders` 보강 (14 파일)

### 1.2 `f9b93a6` — updated: newest version and about 30% AI review processing
- **424 files, +25,625 / -10,255** (가장 큰 변경)
- **신규 추가 40+ 파일** (대부분 Policies)
- 주된 변경 영역:
  - **Policies 일괄 도입**: `app/Policies/` 39개 신규 (ActivityPolicy, AdminUserPolicy, CgoUserPolicy, CompanyPolicy, JobPolicy, MediaPolicy 등) — Filament 리소스 전반에 권한 게이트 도입
  - **Filament Resources 57개 수정**: AdministratorResource, CGOResource, CompanyResource, CounselingListResource, EventListResource, TraineeResource 등 화면/액션/필터 대량 변경
  - **Filament Widgets 15개 수정**: CounselingOverviewChart, JobVacancyChart, CGOApprovalList, CgoCounselingStats 등 위젯 데이터/표시 갱신
  - **Filament Pages 6개 수정**: Overview, PdmDashboard, ViewAdmin, ViewCGO, ViewOjt, ListCareerTests
  - **Export 4개**: TraineeExporter, TraineeListExportCgo, TraineeReportExportCgo, CareerTestExport 컬럼/포맷 변경
  - **Console Commands 7개**: SendInactiveCgoReminder, SendMonthlyReport, SyncApiData, UpdateActivityLogGuard 등 로직 수정
  - **API 컨트롤러 추가**: `app/Http/Controllers/Api/` 12개 신규 (Trainee/Portfolio 등 API 엔드포인트)
  - **미들웨어 추가**: `app/Http/Middleware/CheckAdminUserLoggedIn.php`
  - 다국어 리소스(`lang/en|sn|tm`) 8개씩 갱신
  - **테스트 추가**: `tests/Unit/TraineeExportCgoTest.php` (117 LOC, export 컬럼 회귀 테스트)

### 1.3 `0ecf69c` — fix: CGO/Admin security, login bugs, null-safety, dead code
- **14 files, +29 / -22** (자체 보안/버그 수정 오버레이)
- 상세 내역은 [`VERIFICATION_REPORT.md`](./VERIFICATION_REPORT.md) 참조
- 핵심:
  - CGO 콘텐츠 관리 5개 라우트에 `CheckCgoUserLoggedIn` 미들웨어 복구 (인증 우회 차단)
  - Company `getCVOfTrainee` 라우트 인증 면제 제거 (CV 누출 차단)
  - OJT 라우트 전수 인증 적용
  - `OJTMatchController` / `OJTController` 인증 체크 추가
  - `LoginRequest` 4종 (`Trainee`, `SchoolKid` ×2) input trim 적용 (공백 크리덴셜 통과 차단)
  - `PortfolioController` 파일 다운로드 null-safety + 인증 체크
  - `Overview` 페이지 위젯 캐스팅 보강
  - 사용되지 않는 import / dead controller action 정리
  - `routes/admin.php` 인증 누락 라우트 3건 미들웨어 적용
  - `routes/cgo.php` CGO 콘텐츠 라우트 10건 미들웨어 적용

---

## 2. 도메인별 변경 분포 (`67a60a0..0ecf69c` 전체)

| 영역 | 변경 파일 수 | 주요 내용 |
|------|---:|---------|
| `app/Filament/Resources` | 77 | admin/CGO/company 리소스 전반 개편 |
| `app/Policies` | 39 | 권한 정책 일괄 신규 (Oscar 측 AI 리뷰 산출물로 추정) |
| `app/Http` | 49 | Api 컨트롤러 12개 신규, 미들웨어/Requests 수정 |
| `resources/views` | 92 | Blade 템플릿 대량 개편 (홈, 회원가입, 포트폴리오 등) |
| `public/portfolio` | 32 | 정적 자산/이미지 갱신 |
| `public/files` | 29 | 첨부파일/문서 자산 갱신 |
| `resources/js` | 14 | 프론트엔드 번들 갱신 |
| `database/seeders` | 14 | 시드 데이터 보강 |
| `app/Services` | 12 | 서비스 레이어 갱신 |
| `lang/{en,sn,tm}` | 24 | 다국어 키 보강 |
| `app/Models` | 8 | 모델 캐스팅/관계 갱신 |
| `database/migrations` | 7 | 신규 컬럼/테이블 |
| `app/Console` | 7 | 스케줄/배치 명령 갱신 |
| `app/Exports` | 4 | export 컬럼/포맷 변경 |
| `routes/*` | 6 | admin/api/cgo/company/trainee/web 라우트 미들웨어/prefix 조정 |
| `tests/Unit` | 1 | 회귀 테스트 1건 추가 |
| **합계** | **469** | — |

---

## 3. 신규 파일 (주요)

### Policies (39개, `f9b93a6`에서 일괄 추가)
```
app/Policies/ActivityPolicy.php
app/Policies/AdminUserPolicy.php
app/Policies/BannerCategoryPolicy.php
app/Policies/BannerPolicy.php
app/Policies/CareerExpertInterviewPolicy.php
app/Policies/CareerGuidanceCategoryPolicy.php
app/Policies/CareerGuidancePolicy.php
app/Policies/CareerTestPolicy.php
app/Policies/CgoCounselingPolicy.php
app/Policies/CgoUserPolicy.php
app/Policies/CodeManagementPolicy.php
app/Policies/CompanyPolicy.php
app/Policies/CompanyRecruiterPolicy.php
app/Policies/ContentPolicy.php
app/Policies/EnterprisePolicy.php
app/Policies/EventPolicy.php
app/Policies/ExceptionPolicy.php
app/Policies/ExportPolicy.php
app/Policies/FaqArticlePolicy.php
app/Policies/FaqPolicy.php
app/Policies/FolderPolicy.php
app/Policies/InstitutePolicy.php
app/Policies/JobInformationPolicy.php
app/Policies/JobPolicy.php
app/Policies/MediaPolicy.php
app/Policies/MenuPolicy.php
app/Policies/NVQLevelPolicy.php
app/Policies/NewLetterPolicy.php
… (총 39개)
```

### Controllers / Middleware
```
app/Http/Middleware/CheckAdminUserLoggedIn.php     (신규)
app/Http/Controllers/Api/...                       (12개 신규, trainee API)
```

### Tests
```
tests/Unit/TraineeExportCgoTest.php               (신규, 117 LOC)
```

---

## 4. 자체 수정 오버레이 (`0ecf69c`) — 보안/안정성

`VERIFICATION_REPORT.md`에 검증 내역 상세. 변경 파일:

```
app/Filament/Pages/Dashboard/Overview.php
app/Http/Controllers/Admin/QuestionAndAnswerController.php
app/Http/Controllers/CGO/CounselingController.php
app/Http/Controllers/Company/JobSupportController.php
app/Http/Controllers/Company/RegisterNewCompany.php
app/Http/Controllers/OJTController.php
app/Http/Controllers/OJTMatchController.php
app/Http/Controllers/Trainee/PortfolioController.php
app/Http/Requests/SchoolKid/Auth/LoginRequest.php
app/Http/Requests/SchoolKid/Auth/ResetPasswordRequest.php
app/Http/Requests/Trainee/Auth/LoginRequest.php
app/Providers/Filament/AdminPanelProvider.php
routes/admin.php
routes/cgo.php
```

---

## 5. 후속 작업 안내

- **리팩토링 평가**: [`REFACTORING_ASSESSMENT.md`](./REFACTORING_ASSESSMENT.md) — Phase 1~4 우선순위 권고
- **이번 수정 검증**: [`VERIFICATION_REPORT.md`](./VERIFICATION_REPORT.md) — 14 파일 php -l PASS, 라우트 683개 등록 정상
- **백업 복구**:
  ```bash
  git switch backup/pre-refactor-2026-06-21
  git checkout backup/pre-refactor-2026-06-21 -- <path>
  git diff fix/oscar-issues..backup/pre-refactor-2026-06-21
  ```
