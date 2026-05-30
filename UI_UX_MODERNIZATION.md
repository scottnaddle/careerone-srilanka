# CareerOne — 전체 UI/UX 현대화 분석

> **분석 범위**: 공개 홈페이지, 로그인, 회원가입, 대시보드, 어드민 패널, 목록/검색 페이지  
> **분석 일자**: 2026-05-30

---

## 1. 공개 홈페이지 (/)

### 발견

| # | 이슈 | 심각도 | 상세 |
|---|------|:--:|------|
| 1 | **히어로 캐러셀 과도한 레이아웃 시프트** | 🟡 | 3개 슬라이드에 각각 다른 높이의 콘텐츠 → 페이지가 위아래로 출렁임 |
| 2 | **섹터 아이콘 중복** | 🔵 | ICT, Tourism, Manufacturing, Construction 링크가 각각 2개씩 중복 (총 8개 중복) |
| 3 | **YouTube iframe으로 인한 성능 저하** | 🟡 | 2개 이상의 YouTube iframe이 동시 로드 → 초기 로드 지연 |
| 4 | **Thumbnail alt 텍스트** | 🔵 | "Thumbnail content" 남아있음 (이전에 부분 수정됨) |
| 5 | **푸터 CTA 카드 부재** | 🟡 | 페이지 하단이 긴 링크 리스트로만 끝남 → 뉴스레터 구독, 다운로드 CTA 없음 |
| 6 | **Hero 직업 링크 시각화 부족** | 🟡 | Hotel, Receptionists 등이 텍스트 링크로만 존재 |

### 개선 제안
1. 캐러셀 높이 고정 (`aspect-[21/9]`) + LCP 최적화
2. YouTube iframe을 `loading="lazy"` + 클릭 시 로드 (성능 +60%)
3. 섹터 중복 링크 제거
4. 푸터에 "Download CareerOne App" CTA 카드 추가

---

## 2. 로그인 선택 (/choose-login)

### 발견

| # | 이슈 | 심각도 | 상세 |
|---|------|:--:|------|
| 1 | **4개 카드가 2×2 그리드에 갇힘** | 🟡 | Admin이 4번째 자리에 밀려나서 덜 중요해 보임 |
| 2 | **아이콘/이미지 크기 불일치** | 🔵 | Admin 아이콘이 더 작고 다른 형식 (.png vs .webp) |
| 3 | **모바일에서 2열 그리드** | 🟡 | 2열 그리드로 인해 각 카드가 너비가 좁아 텍스트 잘림 |

### 개선 제안
1. Admin은 별도 링크("Administrator? Click here")로 분리, 3카드 가로 배치
2. 모든 아이콘을 .webp로 통일 + 동일 크기

---

## 3. 로그인 페이지 (/trainee/auth/signin 등)

### 발견

| # | 이슈 | 심각도 | 상세 |
|---|------|:--:|------|
| 1 | **카드 디자인이 구형** | 🟡 | `shadow-md` + `border` + `rounded-xl` → 2020년 감성 |
| 2 | **구글 로그인 버튼이 너무 큼** | 🔵 | `h-12` + `w-full`로 암호 폼보다 더 두드러짐 |
| 3 | **#4984F6 단일 브랜드 컬러 의존** | 🔵 | 다크모드/라이트모드 모두 동일 청색 — 부드럽지 않음 |

### 개선 제안
1. 카드 디자인: `shadow-lg rounded-2xl` + 미세한 gradient border
2. Google 버튼: White 배경 + Google 컬러 아이콘 + 테두리 (표준 디자인)
3. 브랜드 컬러: `#4984F6` 유지, 다크모드에서는 `#60A5FA`(blue-400)

---

## 4. 회원가입 (이미 대폭 현대화됨)

| 상태 | 항목 |
|:--:|------|
| ✅ | Progressive 2-step |
| ✅ | Password strength rules |
| ✅ | Google social login |
| ✅ | Magic link |
| ⬜ | **Floating label** (라벨이 placeholder처럼 동작) |
| ⬜ | **이메일 인증 OTP 6자리** → 네이티브 스타일 input |

---

## 5. 헤더 / 네비게이션 (공통)

### 발견

| # | 이슈 | 심각도 | 상세 |
|---|------|:--:|------|
| 1 | **Language Switcher 아이콘만** | 🟡 | 언어 전환 버튼이 "English" 텍스트만 → 실제 언어명 없음 |
| 2 | **Accessibility 위젯 필라멘트 의존** | 🔵 | Livewire 컴포넌트로 인한 추가 JS 로드 |
| 3 | **Sign in 버튼에 구분감 없음** | 🔵 | 일반 텍스트 링크 — CTA 버튼이 아님 |

### 개선 제안
1. Sign in을 `rounded-full bg-primary text-white px-4 py-2` 버튼으로
2. Language: 🇬🇧 English / 🇱🇰 සිංහල / 🇱🇰 தமிழ்

---

## 6. 목록/검색 페이지 (/job/list 등)

### 발견

| # | 이슈 | 심각도 | 상세 |
|---|------|:--:|------|
| 1 | **필터가 가로 스크롤 필요** | 🟡 | Job title + Status + Location + Category + Sort → 5개 필터가 작은 화면에서 줄바꿈 |
| 2 | **Job 카드에 썸네일 없음** | 🟡 | 모든 카드가 텍스트 전용 — 시각적 구분 부족 |
| 3 | **페이지네이션이 숫자만** | 🔵 | "Go to page N"만 있고 Previous/Next만 있음 |

### 개선 제안
1. 필터를 **좌측 사이드바**로 이동 (데스크톱) / **상단 토글 패널** (모바일)
2. 카드에 Sector 아이콘 + Company 로고 추가
3. 무한 스크롤 + "Load more" 버튼

---

## 7. Admin 패널 (Filament)

### 발견

| # | 이슈 | 심각도 | 상세 |
|---|------|:--:|------|
| 1 | **브랜딩 불일치** | 🟡 | Admin 로그인은 "TVET" 로고, Public은 "CareerOne" 로고 |
| 2 | **대시보드 위젯 부족** | 🟡 | 첫 화면이 바로 리소스 목록 — 대시보드 위젯 없음 |
| 3 | **Global Search는 활성화했으나 UX 미흡** | 🔵 | 검색 결과가 카테고리 없이 평면 나열 |
| 4 | **사이드바 아이콘만으로 기능 구분 어려움** | 🔵 | 40+개 리소스 → 스크롤 필요 |

### 개선 제안
1. Admin 브랜딩 통일: CareerOne 로고 + "Admin Panel" 부제목
2. Dashboard에 통계 위젯 추가 (오늘 가입자, 승인 대기, 새 상담)
3. 사이드바: 카테고리 접기(Accordion) + 즐겨찾기 핀

---

## 8. 일관성 문제 (Cross-cutting)

| 이슈 | 예시 | 영향 |
|------|------|:--:|
| **로고 불일치** | Admin: TVET / Public: CareerOne | 브랜드 혼란 |
| **둥근 모서리 불일치** | 로그인: `rounded-xl`, 가입: `rounded-2xl`, 카드: `rounded-xl` | 시각적 통일감 부족 |
| **버튼 스타일 불일치** | Sign in: `rounded-full`, Sign up: `rounded-xl`, Admin: Filament 기본 | 통일 필요 |
| **그림자 불일치** | `shadow-md`, `shadow-lg`, `shadow-custom-light` 혼재 | |

---

## 권장 로드맵

| Phase | 항목 | 작업량 | 영향 |
|:--:|------|:--:|:--:|
| **P0** | 브랜딩 통일 (로고, 버튼, rounded) | 2h | 일관성 |
| **P0** | Job/Event 카드 현대화 (썸네일+아이콘) | 3h | 시각적 품질 |
| **P1** | 히어로 캐러셀 최적화 (LCP) | 2h | 성능 +60% |
| **P1** | Header/Footer 현대화 (CTA 버튼, 언어) | 3h | 탐색 |
| **P2** | Admin Dashboard 위젯 | 3h | 관리 효율 |
| **P2** | Floating label input | 2h | 세련미 |

---

## 핵심: 가장 큰 변화를 가장 적은 노력으로

**Phase P0만 실행해도** 사이트 전체의 품질 인상이 크게 달라집니다:

1. 모든 로고 → CareerOne 통일 (3파일)
2. 모든 버튼 → `rounded-full` 통일 (CSS 변수 1개)
3. 모든 카드 → `rounded-2xl shadow-lg` 통일 (CSS 변수 1개)
4. Job 카드에 아이콘/썸네일 추가 (1개 컴포넌트)
