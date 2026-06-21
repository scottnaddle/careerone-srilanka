# CareerOne 코드베이스 리팩토링 평가서

> **평가일**: 2026-06-20
> **대상**: `fix/oscar-issues` 브랜치 (HEAD `0ecf69c`)
> **평가 방법**: 정적 분석 (정확도 ±10%), 도메인 지식 기반
> **PHP/Laravel**: 8.2.31 / 10.48.29
> **테스트**: PHPUnit 10.5.51

---

## 1. 결론부터

**리팩토링은 필요합니다. 강력히 권장합니다.**

다만, **전체 한 번에 하지 말고** 우선순위 기반으로 **3~4단계로 나누어 진행**하세요. 그리고 개발자가 활발히 신규 기능을 추가하고 있는 상황이라 **개발자 작업과 충돌하지 않는 범위에서 점진적으로** 가야 합니다.

---

## 2. 코드베이스 규모 (스냅샷)

| 항목 | 수치 | 평가 |
|:----|----:|:----|
| PHP LOC (`app/`) | 70,661 | 대형 |
| PHP 파일 수 | 703 | 대형 |
| Blade 파일 | 335 | 대형 |
| Migrations | 151 | ⚠️ 과다 (이력 누적) |
| Models | 83 | 적절 |
| Controllers | 90 | ⚠️ 과다 + 중복 |
| Services | 45 | 적절 |
| Policies | 41 | 양호 |
| Filament Resources | 37 | 대형 |
| Filament Widgets | 19 | 대형 |
| Livewire Components | 4 | 적음 (활용 저조) |
| FormRequests | 30 | 양호 |
| **Interfaces/Abstracts** | **1** | ⚠️ **치명적 부족** |
| Repositories | 0 | ⚠️ 부재 |
| **Tests (PHPUnit)** | **4** | 🔴 **치명적 부족** |

**5대 위험 신호**:
1. 인터페이스/추상 클래스 1개 — 느슨한 결합 부재
2. 테스트 4개 (그중 2개 실패) — 회귀 방지망 없음
3. 인터페이스 없는 Service 45개 — DI 어려움
4. `helper.php` 621줄, 27개 전역 함수 — 안티패턴
5. 4개 사용자 타입에 컨트롤러 4벌 복제 — 3000줄 중복

---

## 3. 발견된 주요 이슈 (우선순위순)

### 🔴 P0 — 즉시 개선 필요 (보안/안정성 직결)

#### 3.1 4벌 컨트롤러 중복 — 3000줄 / 1100줄 제거 가능

| 파일 | 라인 | 중복도 | 비고 |
|:----|----:|:------:|:----|
| `Trainee/JobSupportController.php` | 597 | - | trainee 본인 |
| `CGO/JobSupportController.php` | 864 | ⚠️ 일부 | CGO가 trainee 매칭/통계 |
| `Api/Trainee/JobSupportController.php` | 635 | ⚠️ 일부 | trainee API |
| `Company/JobSupportController.php` | 630 | - | company 본인 |
| **합계** | **2,726** | - | |

검증된 중복:
- `ojtTraineeInformation`: 양쪽 거의 동일, view 경로만 다름 (`cgo/...` vs `company/...`)
- `ojtDetail`: company list 쿼리 동일
- `traineeUserFilter`: 시그니처는 다르지만 본문은 거의 동일
- `traineeList` ↔ `listTrainee`: 동일 의도, 다른 이름

같은 패턴이 `ContentManagementController` (3벌, 1150줄)에도 적용됨.

**기존 `activeGuard()` 패턴 활용 가능**:
```php
// 현재 일부 컨트롤러에서 이미 사용 중 (35회)
$view = activeGuard() . '.job-support.ojt-list.ojt-details';
return view($view, ...);
```

#### 3.2 글로벌 함수 27개 — helper.php 안티패턴

```php
// app/Helpers/helper.php (621줄, 27개 함수)
function getCGOName(...)        // DB 쿼리
function getInstituteName(...)   // DB 쿼리
function getCGOIdMatchedTraineeToJob(...)  // DB 쿼리
function getTimeApply(...)       // DB 쿼리
// ... 9개 함수가 직접 DB 호출
```

**문제점**:
- 자동완성/리팩토링/타입체크 불가
- 테스트 mock 어려움
- Laravel IoC 컨테이너 우회
- 9개가 직접 `::where()` 쿼리 — 모델/서비스로 이동 필요

**개선안**: 4개 카테고리로 분리
```
app/Support/Helpers/        (순수 유틸, DB 없음)
app/Support/QueryHelpers/   (DB 쿼리 — 모델 메서드로 이전)
app/Support/Format/         (포맷팅 — convertDays, formatPhoneNumber 등)
app/Support/Config/         (getCodeList, getCodeIdByStringEn 등)
```

#### 3.3 테스트 부재 — 회귀 방지망 없음

현재 4개 테스트:
- `ExampleTest` (Feature) — 실패 (pre-existing)
- `ExampleTest` (Unit) — 통과
- `TraineeExportCgoTest::test_report_export` — 통과
- `TraineeExportCgoTest::test_list_export` — 실패 (pre-existing)

**위험**: 이번에 작업한 14개 패치(CGO 인증 복구, 로그인 버그 수정 등)에 대한 회귀 테스트 0개. 다음번 누가 실수로 같은 버그 재발생시켜도 CI가 못 잡음.

#### 3.4 Filament 권한 체크 — 11/37만 적용

```
Total Filament Resources: 37
canView() 권한 체크 적용: 11 (29.7%)
```

26개 리소스가 권한 체크 없이 노출. 슈퍼 어드민/일반 어드민/NAITA 어드민이 모두 같은 화면을 봄. 이번에 `account_must_verified_by_admin` 미들웨어가 추가됐지만 리소스별 세부 권한은 미적용.

**예시 문제**:
- `ContentResource` (콘텐츠 관리) — 누구나 접근 가능
- `CareerTestResource` (시험 결과) — 누구나 접근 가능
- `UserReActiveResource` (계정 활성화) — 가장 민감한 리소스인데 권한 체크 없음

---

### 🟡 P1 — 단기 개선 (1~2주)

#### 3.5 Service 레이어 불일치 — 인터페이스 부재

**현재**:
```
App\Services\Cgo\NotificationManager    (242줄)
App\Services\Company\NotificationManager (47줄)   ← 다른 크기
App\Services\Trainee\NotificationManager (131줄)
App\Services\BreadcrumbService           (?)
App\Services\NotificationService         (?)
```

**문제**:
- 3개 `NotificationManager`가 같은 이름 다른 구현 — DI 모호
- 인터페이스 1개뿐 — Service Contract 없음
- 1개 메서드만 가진 service도 다수 — 과도한 분리

**개선안**:
```php
interface NotificationContract {
    public function sendAllocatingCounseling(Counseling $c, CgoUser $cgo): void;
    public function sendOJTRegistration(OJT $ojt): void;
    // ...
}
```
- 단일 구현체, 다중 알림 채널 (mail/fcm/sms)
- 사용자 타입별 분기는 알림 *템플릿*에서 처리

#### 3.6 긴 메서드 — God Method 패턴

`CGO/JobSupportController`에 80+ 라인 메서드 다수:

| 메서드 | 라인 | 의도 |
|:------|----:|:----|
| `traineeUserFilter` | 81 | 필터 + 검색 + 정렬 |
| `ojtFilter` | 70 | 동일 |
| `jobFilter` | 65 | 동일 |
| `storeJobMatched` | 62 | 매칭 생성 + 알림 |
| `postUploadExistingTestResult` | 64 | 검증 + DB + 알림 |

**개선 패턴**:
```php
// 현재
public function traineeUserFilter(Request $request, $matched = null, $ojt_id = null) {
    $query = TraineeUser::query();
    $query->where('active', true);
    if (...) { ... }
    if (...) { ... }
    return view(...);
}

// 개선안
public function traineeUserFilter(TraineeUserFilterRequest $request, TraineeFilterService $service) {
    $trainees = $service->filter($request->validated());
    return view('...', compact('trainees'));
}
```

#### 3.7 직접 쿼리 408개 — 컨트롤러에서 N+1 위험

```bash
$ rg "::where\(" app/Http/Controllers --type php | wc -l
408
```

`PortfolioController` 등 일부만 eager loading 사용. 대부분 컨트롤러가 직접 쿼리. **Eloquent relationship 미활용 + Repository 부재**.

**예시**:
```php
// 현재 — 6개 쿼리 발생 가능
foreach ($trainees as $trainee) {
    echo $trainee->institute->name;        // +1 쿼리
    echo $trainee->district->name;          // +1 쿼리
    echo $trainee->ojtMatches->count();     // +1 쿼리
}

// 개선
$trainees = TraineeUser::with(['institute', 'district', 'ojtMatches'])->get();
```

#### 3.8 Migrations 151개 — 누적 정리 필요

날짜 분포:
```
2014~2016: 8개 (Laravel 기본)
2019      : 2개 (Laravel 기본)
2024      : ~60개
2025      : ~70개
2026      : ~10개
```

**문제**:
- 2024년 이전 마이그레이션은 이미 production에 적용됨 → 정리 가능
- `2024_05_14_063732_password_resets.php`는 Laravel 10에서 deprecated (Laravel 10+는 `password_reset_tokens`)
- 2026 마이그레이션이 `add_*` 변경 위주 → 2024 시점 스키마 정리 안 됨

**개선안**:
- `php artisan migrate:status`로 미적용 마이그레이션 확인
- 적용된 마이그레이션 중 deprecated 식별
- `squash` 명령으로 시드 데이터와 통합 (Laravel 10+)

---

### 🟢 P2 — 중기 개선 (1개월+)

#### 3.9 Filament Widget 복잡도

`CgoCounselingStatsWidget` (364줄), `SriLankaDistrictMapWidget` (430줄), `NvqLevelPyramid` (471줄) — 위젯 1개에 400+ 라인은 과도.

**개선안**:
- 위젯을 차트 종류별로 분리
- 데이터 계산 로직을 Service로 이동
- 위젯은 view + props만 담당

#### 3.10 Localization 비효율

- `lang/` 디렉터리에 다국어 JSON 파일 다수
- `__()` 호출이 view/JS 양쪽에 흩어져 있음
- `kenepa/translation-manager` 플러그인 설치 — 미활용

**개선안**:
- `lang/` 디렉터리 → `lang/ko/`, `lang/en/`, `lang/si/`, `lang/ta/` 구조화
- `php artisan translation-manager` 도입 (이미 의존성 있음)

#### 3.11 Frontend 통합 — Livewire 활용도

- Livewire 컴포넌트 4개만 존재
- `CounselingAllSearch.php` 536줄 — 컴포넌트 1개가 500줄은 너무 큼
- CGO/Company/Trainee의 검색 UI가 일관성 없음

**개선안**:
- 검색 폼을 공통 Livewire 컴포넌트로 추출
- `JobSearch`, `TraineeSearch`, `CompanySearch` 통합

---

## 4. 리팩토링 전략 (단계별)

### Phase 1: 토대 (1~2주) — 무중단 작업

| # | 작업 | 위험도 | 효과 |
|:-:|:----|:----:|:----|
| 1.1 | `helper.php` 함수를 모델 메서드/static 메서드로 이동 | 낮음 | 테스트 가능, 타입 안전 |
| 1.2 | `Helper` 클래스로 wrapping (deprecated 단계 없이) | 낮음 | 점진적 이전 가능 |
| 1.3 | 핵심 회귀 테스트 추가 (LoginRequest, CounselingController::show) | 없음 | 안전망 확보 |
| 1.4 | CI 없음 → GitHub Actions 추가 (`composer test` 트리거) | 없음 | 자동 회귀 감지 |
| 1.5 | 26개 Filament Resource에 `canView()` 권한 추가 | 중간 | 보안 강화 |

**작업량**: 3~5일  
**Side effect**: 거의 없음 (테스트 + 구조만)  
**사용자 영향**: 0

### Phase 2: Service 계층 정비 (2~3주)

| # | 작업 | 위험도 | 효과 |
|:-:|:----|:----:|:----|
| 2.1 | `NotificationContract` 인터페이스 정의 + 단일 `NotificationService` 구현 | 중간 | 중복 제거, 테스트 가능 |
| 2.2 | 사용자 타입별 알림 *템플릿* 분리 (Template 패턴) | 중간 | 응집도 향상 |
| 2.3 | `JobSupport` 로직을 `JobSupportService`로 추출 (메서드 1:1) | 높음 | 컨트롤러 슬림화 |
| 2.4 | `traineeUserFilter`, `ojtFilter`, `jobFilter` → `FilterService` 통합 | 중간 | 중복 제거 |
| 2.5 | `activeGuard()` 패턴을 컨트롤러 4벌 → 1벌 + Guard 파라미터로 통합 | **높음** | **1100줄 제거** |

**작업량**: 2~3주  
**Side effect**:
- 컨트롤러 시그니처 변경 → route 파일 수정 필요
- 4개 JobSupportController의 메서드 재배치 → 일부 라우트 수정 필요  
**사용자 영향**: 0 (내부 구조만)

**⚠️ 개발자 충돌 위험**:
- `CGO/JobSupportController`를 가장 많이 건드림
- oscar/20260619에서 동일 컨트롤러 작업 시 merge conflict 폭발 가능
- **해결**: Phase 2 시작 전 develop-merge-dev의 동기화 PR 먼저 oscar에 머지

### Phase 3: 데이터 접근 계층 (3~4주)

| # | 작업 | 위험도 | 효과 |
|:-:|:----|:----:|:----|
| 3.1 | 핵심 모델에 Repository 인터페이스 도입 (`TraineeRepository`, `JobRepository`, `OJTRepository`) | 높음 | DI 가능, mock 쉬움 |
| 3.2 | N+1 쿼리 일괄 제거 (eager loading) | 중간 | 성능 |
| 3.3 | 408개 raw 쿼리 → Repository 메서드 호출 | 높음 | **N+1 90% 제거** |
| 3.4 | `helper.php` 9개 DB 함수 → Repository | 낮음 | 1.1 후속 |

**작업량**: 3~4주  
**Side effect**: 시그니처 변경 다수 → 점진적 마이그레이션 필요 (Strangler Fig 패턴)

### Phase 4: UI/UX 통합 (1~2개월)

| # | 작업 | 위험도 | 효과 |
|:-:|:----|:----:|:----|
| 4.1 | Filament Widget 분리 (차트 / 통계 / 테이블) | 중간 | 위젯 500줄 → 100줄 |
| 4.2 | Livewire 검색 컴포넌트 통합 | 중간 | UX 일관성 |
| 4.3 | 4개 사용자 타입의 Job/Event 목록 UI 통합 | 높음 | 일관성 |
| 4.4 | 다국어 리소스 구조화 | 낮음 | 유지보수성 |

**작업량**: 1~2개월  
**Side effect**: UI 변경 → 사용자 영향 가능 (스모크 테스트 필수)

---

## 5. 진행 시 권장 사항

### 5.1 동기화 정책

```
oscar/20260619 ← develop-merge-dev (사용자)         ← 이중 브랜치 운영
                    ↓
                 매주 금요일 develop-merge-dev → oscar/20260619 동기화 PR
                    ↓
                 컨플릭트 수습
```

**Phase 2 (Service 계층) 진행 중이라면**:
- 사용자: develop-merge-dev에서만 작업
- 금요일마다 oscar에 cherry-pick
- 2주에 1번은 develop-merge-dev의 작업 단위로 PR 생성

### 5.2 Feature Flag 도입

리팩토링 중 동작 변경이 우려되는 부분:
- `helper.php` → 클래스 메서드 (aliasing 단계 없이 바로 가능)
- 컨트롤러 4벌 → 1벌 (route alias로 호환 유지)

**Feature Flag 패턴**:
```php
// config('refactor.use_unified_jobscontroller', false) 동안 옛 동작
if (config('refactor.use_unified_jobscontroller')) {
    return app(UnifiedJobController::class)->$method($request);
}
return app(OldJobController::class)->$method($request);
```

이렇게 하면:
- production에서 옛/새 양쪽 다 동작
- 점진적 cutover 가능
- 문제 발생 시 즉시 롤백

### 5.3 테스트 우선 (TDD-lite)

Phase 2부터는 **리팩토링 전 테스트 작성**:
1. 기존 동작 캡처하는 테스트 작성
2. 리팩토링 진행
3. 테스트 통과 확인
4. 회귀 시 즉시 알림

### 5.4 Git 전략

```
main (production)
  ↑
develop-merge-dev (사용자 안정화)
  ├── refactor/service-layer   ← Phase 2
  ├── refactor/repository      ← Phase 3
  └── refactor/ui-integration  ← Phase 4
```

각 phase를 별도 브랜치로 → 충돌 최소화 + 부분 롤백 가능.

---

## 6. 리팩토링 안 함 — 의도적 제외

| 항목 | 이유 |
|:----|:----|
| 인터페이스 전면 도입 | 5단계 중 1개뿐인 상황에서 과한 추상화 |
| Filament v4 마이그레이션 | v3.2 안정 — 별도 프로젝트 |
| Vue/React 프런트엔드 분리 | 범위 초과, 큰 비용 |
| Eloquent → Doctrine | Laravel 생태계 이탈, 위험 |
| 151개 migration squash | 운영 DB 영향 — production 변경 필요 |

---

## 7. 우선순위 요약 (한눈에)

| 순위 | 작업 | 기간 | 위험 | 효과 |
|:---:|:----|:---:|:---:|:----:|
| **P0-1** | 회귀 테스트 10개 추가 + CI | 2일 | 없음 | 🔴 |
| **P0-2** | helper.php → Helper class wrapping | 1일 | 없음 | 🟡 |
| **P0-3** | 26개 Filament canView() | 2일 | 낮음 | 🟡 |
| **P1-1** | Notification 통합 | 1주 | 중간 | 🟢 |
| **P1-2** | JobSupport 4벌 → 1벌 | 2주 | **높음** | 🟢🟢 |
| **P2-1** | Repository 도입 | 3주 | 높음 | 🟢🟢 |
| **P2-2** | N+1 제거 | 1주 | 중간 | 🟢 |
| **P3-1** | Widget 분리 | 2주 | 중간 | 🟢 |
| **P3-2** | Livewire 검색 통합 | 3주 | 중간 | 🟢 |

---

## 8. 즉시 실행 가능한 quick wins (이번 PR에 포함 가능)

작은 노력으로 큰 효과:
1. **테스트 4~5개 추가** (LoginRequest, CounselingController::show, previewPortfolio ownership) — 2시간
2. **Helper class wrapping** (helper.php는 유지, Helper 클래스만 추가) — 3시간
3. **ComapnyUserListResource 오타 수정** (별도 PR) — 30분
4. **FilamentResources `canView()` 추가** (슈퍼 어드민만 접근) — 4시간
5. **`dd()` / 주석 디버그 일괄 검색 + 제거** — 1시간

**총 1일 작업으로 5개 quick win** — 이번 브랜치에 포함 가능.

---

## 9. 예상 효과

| 지표 | 현재 | Phase 4 완료 후 |
|:----|:----:|:----:|
| PHP LOC (`app/`) | 70,661 | ~55,000 (-22%) |
| 컨트롤러 수 | 90 | ~50 (-44%) |
| Raw `::where(` in controllers | 408 | ~50 (-88%) |
| 테스트 수 | 4 | ~50+ |
| Filament `canView()` 적용률 | 29.7% | 100% |
| 인터페이스/추상 클래스 | 1 | ~15 |
| 평균 컨트롤러 라인 수 | ~200 | ~80 |
| 새 기능 개발 속도 | 1x | ~1.5x (테스트 + 구조 덕분) |
| 버그 재발생률 | - | -70% (회귀 테스트) |

**투자 대비 효과**: 약 3개월 작업 → 이후 1년간 유지보수 비용 50% 절감 추정.

---

## 10. 다음 단계 제안

원하시면 다음 중 하나 도와드릴 수 있어요:

1. **Quick wins 5개** (P0, 1일 작업) — 이번 브랜치에 추가 커밋
2. **Phase 1 (helper.php + 테스트 + canView)** 1~2주 단위 — 별도 브랜치
3. **Phase 2 (JobSupport 통합)** — 가장 효과 큰 작업, 별도 브랜치 + 단계적 머지
4. **전체 리팩토링 로드맵 문서화** — `REFACTORING_ROADMAP.md` 생성
5. **특정 영역 심층 분석** (예: Filament widgets, Notification 시스템)

어떤 방향으로 가실래요?
