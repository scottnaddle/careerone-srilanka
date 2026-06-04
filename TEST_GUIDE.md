# CareerOne 사용자 기능 테스트 가이드

**프로젝트**: career-srilanka-product (Laravel 10)
**작성일**: 2026-06-03

---

## 📋 개요

이 문서는 CareerOne 플랫폼의 5가지 사용자 유형별 기능 테스트 시나리오를 제공합니다. 각 유형별로 로그인 → 주요 기능 → 마이페이지 → 로그아웃까지의 전체 플로우를 단계별로 테스트할 수 있도록 구성했습니다.

---

## 1. 👤 Trainee (교육생)

> **라우트**: `/trainee/*` (CAS SSO + 일반 로그인 병행)
> **API**: `/api/trainee/*` (모바일 앱)

### 1.1 Auth (인증)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| T-01 | `/trainee/auth/signin` 접속 → 로그인 폼 노출 확인 | 로그인 페이지 정상 로드, 이메일/비밀번호 입력 필드 표시 |
| T-02 | 유효한 자격증명으로 로그인 | 대시보드/메인 페이지로 리다이렉트 |
| T-03 | 잘못된 비밀번호 입력 | "Invalid credentials" 에러 메시지 표시 |
| T-04 | 존재하지 않는 이메일로 로그인 시도 | 에러 메시지 표시 |
| T-05 | `/trainee/auth/signup` 접속 → 회원가입 폼 | 정상 로드, NIC 중복체크 기능 동작 |
| T-06 | NIC 중복체크 (`/check-NIC`) — 신규 NIC | "Available" 메시지 |
| T-07 | NIC 중복체크 — 이미 등록된 NIC | "Already taken" 메시지 |
| T-08 | 회원가입 완료 → 이메일 인증 | 인증 이메일 발송, 링크 클릭 시 인증 완료 |
| T-09 | 비밀번호 찾기 (`forget-password`) | 비밀번호 재설정 이메일 발송 |
| T-10 | 비밀번호 재설정 링크 → 새 비밀번호 설정 | 재설정 성공, 새 비밀번호로 로그인 가능 |
| T-11 | 구글 로그인 버튼 숨김 확인 (2026-06-02 적용) | 구글 버튼이 `display: none` 상태로 DOM에 존재 |
| T-12 | CAS SSO 로그인 (`/trainee/cas/get-login`) | CAS 인증 페이지로 리다이렉트 후 자동 로그인 |

### 1.2 My Page (마이페이지)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| T-20 | `/trainee/my-page` 접속 | 마이페이지 대시보드 정상 로드 |
| T-21 | 개인정보 조회 (`personal-information`) | 저장된 개인정보 정상 표시 |
| T-22 | 개인정보 수정 (`POST personal-information`) | 수정 내용 DB 반영, 성공 메시지 |
| T-23 | Open to Work 토글 (`open-to-work`) | 상태 토글 성공, UI에 반영 |
| T-24 | Public Portfolio 토글 (`toggle-public-portfolio`) | 상태 토글 성공 |
| T-25 | 비밀번호 변경 (`change-password`) | 비밀번호 변경 성공 |
| T-26 | 회원탈퇴 (`deactive-account`) | 계정 비활성화, 로그아웃 처리 |
| T-27 | 프로필 완료 (`complete-profile`) | 추가 정보 입력 후 저장 성공 |

### 1.3 Career Guidance (진로지도)

#### 진로검사

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| T-30 | 진로검사 목록 (`career-test/`) | 등록된 검사 목록 표시 |
| T-31 | 검사 결과 업로드 (`career-test/upload`) | 파일 업로드 성공 |
| T-32 | 검사 결과 조회 (`view-result/{id}`) | 결과 페이지 정상 렌더링 |
| T-33 | 검사 결과 다운로드 (`download-result/{id}`) | PDF/파일 다운로드 |
| T-34 | 검사 결과 삭제 (`delete-result/{id}`) | 결과 삭제 성공, 목록에서 제거 |

#### 직업정보 / 진로정보

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| T-40 | 직업정보 목록 (`job-information`) | 직업 리스트 정상 표시 |
| T-41 | 직업 상세 (`job-details/{slug}`) | 상세 정보 표시 |
| T-42 | 진로전문가 인터뷰 (`career-expert-interview`) | 인터뷰 콘텐츠 정상 로드 |
| T-43 | 진로가이드 (`career-guide/`) | 가이드 콘텐츠 표시 |

#### 상담

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| T-50 | 상담 내역 조회 (`counseling-history`) | 과거 상담 내역 목록 표시 |
| T-51 | 상담 상세 (`counseling-list/{id}`) | 상담 내용, 첨부파일 표시 |
| T-52 | 상담 신청 (`counseling-request`) | 신청 폼 정상 로드 |
| T-53 | 상담 신청 제출 (`POST counseling-request`) | 상담 생성 성공, CGO에게 알림 |
| T-54 | 상담 신청 수정 (`counseling-edit/{id}`) | 수정 폼 정상 로드, 수정 성공 |
| T-55 | 상담 피드백 제출 (`storeFeedback`) | 피드백 저장 성공 |
| T-56 | 첨부파일 다운로드 (`attachments/{id}/download`) | 파일 다운로드 정상 |

#### 고용정책

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| T-60 | 고용정책 페이지 (`employment-policy`) | 정책 내용 표시 |
| T-61 | 뉴스레터 (`newsletter`) | 뉴스레터 목록 표시 |

### 1.4 Portfolio (포트폴리오)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| T-70 | 포트폴리오 생성 (`portfolios/create`) | 포트폴리오 작성 폼 표시 |
| T-71 | 포트폴리오 저장 (`POST portfolios`) | 저장 성공, 목록에 표시 |
| T-72 | 포트폴리오 수정 (`portfolios/edit`) | 수정 폼에 기존 데이터 로드 |
| T-73 | 포트폴리오 업데이트 (`PUT portfolios/{portfolio}`) | 수정 내용 저장 |
| T-74 | 이미지 업로드 (배경/아바타) | 이미지 업로드 성공, 미리보기 표시 |
| T-75 | 증빙자료 업로드 (evidence) | 파일 업로드 성공 |
| T-76 | 포트폴리오 미리보기 (`preview`) | 포트폴리오 뷰 정상 렌더링 |
| T-77 | 포트폴리오 내보내기 (`export-portfolio`) | PDF/파일로 내보내기 성공 |
| T-78 | 이력서 업로드 (`upload-resume`) | 파일 업로드 성공 |
| T-79 | 이력서 미리보기 (`preview-resume`) | 이력서 뷰 정상 |
| T-80 | 이력서 삭제 (`delete-resume`) | 삭제 성공 |
| T-81 | CV 미리보기 (`preview-cv`) | CV 페이지 정상 로드 |
| T-82 | 포트폴리오 삭제 (`delete-portfolio/{id}`) | 삭제 성공 |

### 1.5 Job Support (취업지원)

#### 채용공고

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| T-90 | 채용공고 목록 (`job-list/job-list`) | 공고 리스트 정상 표시, 필터/검색 동작 |
| T-91 | 채용공고 상세 (`job-list/job-detail/{id}/{slug}`) | 상세 정보 표시 |
| T-92 | 채용공고 북마크 (`mark-job`) | 북마크 토글 성공 |
| T-93 | 채용공고 지원 (`toggleApply`) | 지원 성공/취소 토글 |
| T-94 | 채용공고 매칭 (`match-job`) | 매칭 요청 성공 |

#### 기업

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| T-100 | 기업 목록 (`company/company-list`) | 기업 리스트 표시 |
| T-101 | 기업 북마크 (`mark-company`) | 북마크 토글 성공 |
| T-102 | 기업 상세 (`company/details/{id}/{slug}`) | 기업 정보 표시 |
| T-103 | 기업 이벤트 목록 (`company/events/{id}/{slug}`) | 해당 기업 이벤트 목록 표시 |
| T-104 | 기업 채용공고 (`company/job-post/{id}/{slug}`) | 해당 기업 채용공고 표시 |

#### OJT (현장실습)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| T-110 | OJT 목록 (`ojt/list`) | OJT 리스트 정상 표시 |
| T-111 | OJT 북마크 (`mark-ojt`) | 북마크 토글 성공 |
| T-112 | OJT 상세 (`ojt/ojt-detail/{id}/{slug}`) | 상세 정보 표시 |
| T-113 | OJT 지원 (`ojt-apply`) | 지원 성공 |
| T-114 | OJT 지원 취소 (`ojt-unapply`) | 지원 취소 성공 |

### 1.6 기타

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| T-120 | 사용자 매뉴얼 다운로드 (`download-user-manual/{language}`) | 언어별 PDF 다운로드 |
| T-121 | 로그아웃 | 세션 종료, 로그인 페이지로 리다이렉트 |

---

## 2. 🏢 Company (기업)

> **라우트**: `/company/*` (일반 로그인)
> **특징**: 채용공고 등록, OJT 등록, 지원자 관리

### 2.1 Auth (인증)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| C-01 | `/company/auth/signin` 접속 → 로그인 폼 확인 | 로그인 페이지 정상 로드 |
| C-02 | 유효한 회사 계정으로 로그인 | 대시보드로 리다이렉트 |
| C-03 | 잘못된 비밀번호 | 에러 메시지 |
| C-04 | 회원가입 (Wizard 방식) — `/company/auth/signup` | 회원가입 Wizard 정상 동작, 단계별 입력 |
| C-05 | 회원가입 완료 → 이메일 인증 | 인증 메일 발송, 인증 완료 |
| C-06 | 회사 등록 (`/company/register`) | 신규 회사 정보 등록 폼 제출 |
| C-07 | 회사 검색 (`/company/search/{keyword}`) | 검색 결과 반환 |
| C-08 | 비밀번호 찾기 → 재설정 | 이메일 발송 → 재설정 성공 |
| C-09 | 구글 로그인 버튼 숨김 확인 | 버튼 `hidden` 상태 |

### 2.2 My Page (마이페이지)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| C-20 | 대시보드 (`my-page/`) | 대시보드 정보 정상 표시 |
| C-21 | 개인정보 조회 (`personal-information`) | 개인정보 표시 |
| C-22 | 개인정보 수정 (`POST personal-information`) | 수정 성공 |
| C-23 | 회사정보 조회 (`company-information/{id}`) | 회사 상세정보 표시 |
| C-24 | 회사정보 수정 (`POST company-information`) | 수정 성공 |
| C-25 | 첨부파일 삭제 (`remove-attachment`) | 파일 삭제 성공 |
| C-26 | DS 구분 조회 (`get-ds-divisions`) | DS 구분 리스트 반환 |
| C-27 | 비밀번호 변경 | 변경 성공 |
| C-28 | 회원탈퇴 | 계정 비활성화 |

### 2.3 채용공고 관리 (Job Vacancy)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| C-30 | 채용공고 목록 (`job-support/job-vacancy/`) | 등록된 공고 리스트 표시 |
| C-31 | 채용공고 등록 (`job-support/job-vacancy/create`) | 작성 폼 정상 로드 |
| C-32 | 채용공고 저장 (`POST job-support/job-vacancy/`) | 공고 생성 성공 |
| C-33 | 채용공고 수정 (`{job_id}/edit`) | 수정 폼에 기존 데이터 로드 |
| C-34 | 채용공고 업데이트 (`PUT {job_id}`) | 수정 내용 반영 |
| C-35 | 채용공고 상세 (`{job_id}/{slug}`) | 상세 페이지 정상 |
| C-36 | 채용공고 삭제 (`DELETE {job_id}`) | 삭제 성공 (소프트/하드) |
| C-37 | 첨부파일 다운로드 (`download/{filename}`) | 파일 다운로드 |

### 2.4 지원자 관리 (Candidate)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| C-40 | 지원자 목록 (`candidate-list/`) | 전체 지원자 리스트 |
| C-41 | 특정 공고 지원자 목록 (`{job_id}/{slug}`) | 해당 공고 지원자만 필터링 |
| C-42 | 지원자 CV 조회 (`cv/{trainee_user_id}`) | CV/이력서 페이지 표시 |
| C-43 | 지원 상태 → "열람함" (`update-read`) | 상태 업데이트 성공 |
| C-44 | 지원자 선정 (`update-selected`) | 선정 상태 변경 |
| C-45 | 선정 취소 (`unselected`) | 선정 취소 |
| C-46 | 채용 완료 (`employeed`) | 채용 완료 처리 |

### 2.5 OJT (현장실습) 관리

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| C-50 | OJT 목록 (`ojt-list/`) | 등록된 OJT 리스트 |
| C-51 | OJT 등록 (`ojt-registration`) | 등록 폼 정상 로드 |
| C-52 | OJT 저장 (`POST ojt-registration`) | OJT 생성 성공 |
| C-53 | OJT 상세 (`ojt-detail/{slug}`) | 상세 정보 표시 |
| C-54 | OJT 수정 (`ojt-edit/{slug}`) | 수정 폼 → 저장 성공 |
| C-55 | OJT 삭제 (`delete/{id}`) | 삭제 성공 |
| C-56 | OJT 지원자 목록 (`candidate-list/{slug}`) | 지원자 리스트 표시 |
| C-57 | OJT 교육생 매칭 (`trainee-match`) | 매칭 저장 성공 |
| C-58 | 교육생 정보 조회 (`trainee-information/{slug}/{trainee}`) | 교육생 상세 정보 표시 |
| C-59 | OJT 지원자 상태 업데이트 (read/selected/unselected/employeed) | 각 상태 변경 정상 |
| C-60 | OJT 첨부파일 다운로드 | 파일 다운로드 |
| C-61 | OJT 첨부파일 삭제 | 파일 삭제 |

### 2.6 이벤트 관리

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| C-70 | 이벤트 목록 (`informations/events`) | 등록된 이벤트 리스트 |
| C-71 | 이벤트 생성 (`events/create`) | 생성 폼 정상 |
| C-72 | 이벤트 저장 (`POST events/create`) | 생성 성공 |
| C-73 | 이벤트 수정 (`events/{event}/edit`) | 수정 폼 → 저장 |
| C-74 | 이벤트 상세 (`events/detail/{slug}`) | 상세 정보 |
| C-75 | 이벤트 삭제 (`DELETE events/{event}`) | 삭제 성공 |
| C-76 | 이벤트 검색/필터 (`events/search`) | 조건별 검색 결과 |

### 2.7 콘텐츠 관리

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| C-80 | 비디오 목록 (`content-management/videos/`) | 업로드된 비디오 리스트 |
| C-81 | 비디오 업로드 (`POST videos/post`) | 업로드 성공 |
| C-82 | 비디오 삭제 (`videos/delete/{slug}`) | 삭제 성공 |
| C-83 | 문서 목록 (`content-management/documents/`) | 문서 리스트 |
| C-84 | 문서 업로드 (`POST documents/post`) | 업로드 성공 |
| C-85 | 문서 다운로드 (`documents/download/{id}`) | 파일 다운로드 |

### 2.8 기타

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| C-90 | 교육생 목록 (`trainee-list/list`) | 교육생 리스트 |
| C-91 | 사용자 매뉴얼 다운로드 | PDF 다운로드 |
| C-92 | 로그아웃 | 세션 종료 |

---

## 3. 🛡️ CGO (진로지도관)

> **라우트**: `/cgo/*` (일반 로그인)
> **특징**: 교육생 관리, 상담 관리, 취업 매칭, OJT 등록

### 3.1 Auth (인증)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| G-01 | `/cgo/auth/signin` 접속 | 로그인 페이지 정상 |
| G-02 | 유효한 CGO 계정 로그인 | 대시보드 리다이렉트 |
| G-03 | 회원가입 (`signup`) | 등록 폼 정상, NIC 중복체크 |
| G-04 | 비밀번호 찾기 → 재설정 | 이메일 발송 → 재설정 |
| G-05 | 구글 로그인 버튼 숨김 확인 | 버튼 숨김 처리 |

### 3.2 My Page

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| G-20 | 대시보드 (`my-page/`) | 정보 정상 표시 |
| G-21 | 개인정보 조회/수정 | 조회/수정 성공 |
| G-22 | 비밀번호 확인 (`verify-password`) | 비밀번호 일치 확인 |
| G-23 | 회원탈퇴 | 계정 비활성화 |

### 3.3 상담 관리

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| G-30 | 내 일정 (`career-guidance/counseling/my-schedule`) | 상담 일정 캘린더/리스트 |
| G-31 | 상담 목록 (`counseling-list`) | 전체 상담 리스트 (상태별 필터) |
| G-32 | 상담 상세 (`counseling-list/{id}`) | 상담 내용, 첨부파일, 상태 변경 UI |
| G-33 | 상담 상태 업데이트 (`PUT counseling-list/{id}`) | 진행 상태 변경 성공 |
| G-34 | 상담 거절 (`reject/{id}`) | 거절 사유 입력 → 거절 처리 |
| G-35 | 상담 결과 저장 (`store-result-counseling`) | 상담 결과/메모 저장 |
| G-36 | 오프라인 상담 생성 (`create-offline`) | 폼 정상 로드 |
| G-37 | 오프라인 상담 저장 (`store-offline`) | 생성 성공 |
| G-38 | 상담자 변경 (`change-cgo`) | 다른 CGO로 변경 |
| G-39 | NIC으로 교육생 정보 조회 (`get-trainee-info/{nic}`) | 교육생 정보 반환 |
| G-40 | 중복 상담 체크 (`check-duplicate`) | 중복 여부 확인 |
| G-41 | 첨부파일 다운로드 | 파일 다운로드 |

### 3.4 진로검사

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| G-50 | 진로검사 결과 목록 (`career-test/`) | 교육생 검사 결과 리스트 |
| G-51 | 결과 조회 (`view-result/{id}`) | 상세 결과 표시 |
| G-52 | 결과 다운로드 | 파일 다운로드 |

### 3.5 콘텐츠 관리

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| G-60 | 비디오 목록/업로드/삭제 | CRUD 정상 동작 |
| G-61 | 문서 목록/업로드/삭제/다운로드 | CRUD 정상 동작 |
| G-62 | 동료 검토 목록 (`peer-review/`) | 검토 요청 리스트 |
| G-63 | 동료 검토 상세 (`peer-review/{id}/{peer_id}`) | 콘텐츠 + 검토 폼 |
| G-64 | 동료 검토 제출 (`submitResponse`) | 검토 의견 저장 |
| G-65 | 리소스 자료실 (`resource/`) | 자료 리스트, 다운로드 |

### 3.6 취업지원 — 교육생

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| G-70 | 교육생 목록 (`job-support/trainee-list/`) | 교육생 리스트 (검색/필터) |
| G-71 | 교육생 내보내기 (`export`) | CSV/Excel 내보내기 |
| G-72 | 교육생 정보 상세 (`information/{id}`) | 교육생 개인정보, 이력 등 |
| G-73 | 교육생→OJT 매칭 (`ojt-match/{trainee}`) | 매칭 가능 OJT 리스트 |
| G-74 | OJT 상세 (매칭 화면) (`ojt-match/ojt-details/{trainee_id}/{slug}`) | OJT 상세 정보 |
| G-75 | 교육생→채용 매칭 (`job-match/{trainee}`) | 매칭 가능 채용공고 리스트 |
| G-76 | 채용 상세 (매칭 화면) (`job-match/job-details/{trainee}/{slug}`) | 채용 상세 정보 |
| G-77 | 교육생-채용 매칭 저장 (`trainee-match`) | 매칭 정보 저장 성공 |

### 3.7 취업지원 — 기업

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| G-80 | 기업 목록 (`company-list/`) | 기업 리스트 |
| G-81 | 기업별 채용공고 (`job-list/{company}`) | 해당 기업 공고 리스트 |
| G-82 | 기업 채용 상세 (`job-list/job-details/{slug}`) | 채용 상세 정보 |

### 3.8 취업지원 — 채용공고

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| G-90 | 채용공고 목록 (`job-list/`) | 전체 공고 리스트 |
| G-91 | 공고 상세 (`job-details/{slug}`) | 상세 정보 |
| G-92 | 공고별 지원자 목록 (`candidate-list/{job_id}/{slug}`) | 지원자 리스트 |
| G-93 | 매칭된 목록 (`matched-list/{job_id}/{slug}`) | CGO 매칭 리스트 |
| G-94 | 지원자 목록 (`applied-list/{job_id}/{slug}`) | 교육생 직접 지원 리스트 |
| G-95 | 교육생 매칭 (`trainee-match`) | 매칭 처리 |
| G-96 | 교육생 정보 (매칭) (`trainee-information/{slug}/{trainee}`) | 교육생 정보 표시 |
| G-97 | 지원자 정보 (`trainee-applied-information/{slug}/{trainee}`) | 지원자 정보 표시 |
| G-98 | 교육생 매칭 페이지 (`trainee-match/{slug}`) | 매칭 후보 리스트 |

### 3.9 취업지원 — OJT

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| G-100 | OJT 목록 (`ojt-list/`) | 전체 OJT 리스트 |
| G-101 | OJT 등록 (`ojt-registration`) | 등록 폼 → 저장 |
| G-102 | OJT 매칭 목록 (`list-matched/{slug}`) | CGO 매칭 리스트 |
| G-103 | OJT 지원 목록 (`list-applied/{slug}`) | 교육생 지원 리스트 |
| G-104 | OJT 교육생 매칭 (`trainee-match/{slug}`) | 매칭 페이지 |
| G-105 | 교육생 정보 (OJT) (`trainee-information/{slug}/{trainee}`) | 정보 표시 |
| G-106 | OJT 매칭 저장 (`POST trainee-match`) | 매칭 정보 저장 |
| G-107 | OJT 상세 (`ojt-details/{id}`) | OJT 상세 정보 |

### 3.10 기타

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| G-110 | 사용자 매뉴얼 다운로드 | PDF 다운로드 |
| G-111 | 트레이닝 문서 다운로드 | PDF 다운로드 |
| G-112 | 로그아웃 | 세션 종료 |

---

## 4. 🔐 Admin (관리자/운영자)

> **라우트**: `/admin/*` (Filament v3 패널)
> **인증**: Filament auth + Shield 역할 기반 접근 제어

### 4.1 Auth (인증)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| A-01 | `/admin/auth/login` 접속 | Filament 로그인 페이지 |
| A-02 | super_admin 계정 로그인 | Filament 대시보드 리다이렉트 |
| A-03 | 잘못된 비밀번호 | "Invalid credentials" |
| A-04 | 관리자 등록 (`auth/register`) | 신규 관리자 생성 |
| A-05 | 로그아웃 | 세션 종료 |

### 4.2 Filament 리소스 CRUD

| 리소스 | # | 테스트 시나리오 |
|---|---|---|
| **Trainee** (`TraineeResource`) | A-10 | 교육생 목록 조회, 검색, 필터 |
| | A-11 | 교육생 생성/수정/삭제 |
| | A-12 | 교육생 상세 정보 열람 |
| **Company** (`CompanyResource`) | A-20 | 기업 목록 조회, 검색 |
| | A-21 | 기업 승인/거절 (`verified_at` 설정) |
| | A-22 | 기업 등록/수정/삭제 |
| **CGO** (`CGOResource`) | A-30 | CGO 목록 조회 |
| | A-31 | CGO 승인/거절 |
| | A-32 | CGO 등록/수정/삭제 |
| **SchoolKid** (`SchoolKidResource`) | A-35 | 학생 목록/CRUD |
| **Company Recruiter** (`CompanyRecruiterResource`) | A-40 | 리크루터 목록 |
| | A-41 | 리크루터 승인/거절 (`CompanyRecruiterApprovalResource`) |
| **Job** (`JobResource`/`JobCompanyResource`) | A-50 | 채용공고 목록/CRUD |
| **OJT** (`OJTResource`) | A-55 | OJT 목록/CRUD |
| **Event** (`EventResource`) | A-60 | 이벤트 목록/CRUD |
| **Counseling** (`CounselingResource`) | A-65 | 상담 내역 조회/관리 |
| | A-66 | 상담 목록 (`CounselingListResource`) |
| **Career Test** (`CareerTestResource`) | A-70 | 진로검사 결과 관리 |
| **Banner** (`BannerResource`) | A-75 | 배너 관리 (이미지/링크) |
| **Popup** (`PopupResource`) | A-76 | 팝업 관리 |
| **Content** (`ContentResource`) | A-80 | 콘텐츠 관리 |
| **Q&A** (`QuestionsAndAnswersResource`) | A-85 | Q&A 게시판 관리 |
| **Menu** (`MenuResource`) | A-90 | 메뉴 설정 |
| **Policy** (`PolicyResource`) | A-95 | 정책 관리 |
| **Newsletter** (`NewsletterResource`) | A-96 | 뉴스레터 관리 |
| **Resource** (`ResourceResource`) | A-97 | 자료실 관리 |
| **Code Management** (`CodeManagementResource`) | A-98 | 코드 관리 |
| **Banner Category** | A-99 | 배너 카테고리 관리 |

### 4.3 Shield (권한 관리)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| A-100 | Shield 대시보드 → Role 목록 | 역할 리스트 표시 |
| A-101 | Role 생성 (이름, 권한 선택) | 생성 성공 |
| A-102 | Role 수정 (권한 추가/제거) | 권한 변경 반영 |
| A-103 | Role 삭제 | 삭제 성공 (연결된 관리자 없을 시) |
| A-104 | 관리자 Role 할당 변경 | 권한에 따라 리소스 접근 제어 |
| A-105 | 권한 없는 리소스 접근 시도 | "Forbidden" 에러 페이지 |

### 4.4 기타

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| A-110 | 사용자 재활성화 요청 목록 (`UserReActiveResource`) | 요청 목록, 승인/거절 |
| A-111 | 거절된 CGO 목록 (`CgoRejectListResource`) | 거절 사유, 재승인 가능 |
| A-112 | 사용자 매뉴얼 다운로드 | PDF 다운로드 |

---

## 5. 🎓 SchoolKid (학생)

> **라우트**: `/schoolkid/*` (일반 로그인)
> **특징**: Trainee의 하위 개념, 기능 범위가 좁음

### 5.1 Auth

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| S-01 | `/schoolkid/auth/signin` 접속 | 로그인 페이지 정상 |
| S-02 | 회원가입 (`signup`) | NIC 중복체크, 등록 성공 |
| S-03 | 비밀번호 찾기/재설정 | 이메일 발송 → 재설정 |
| S-04 | 로그인 → 대시보드 | 정상 리다이렉트 |

### 5.2 My Page

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| S-20 | 마이페이지 (`my-page/`) | 정보 표시 |
| S-21 | 개인정보 조회/수정 | 조회/수정 성공 |
| S-22 | 회원탈퇴 | 계정 비활성화 |

### 5.3 Career Guidance

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| S-30 | 진로검사 목록 | 검사 리스트 표시 |
| S-31 | 검사 결과 업로드 | 파일 업로드 성공 |
| S-32 | 결과 조회/다운로드/삭제 | 각 기능 정상 동작 |

---

## 6. 🌐 Public (비로그인)

> **라우트**: `routes/web.php`

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| P-01 | 메인 페이지 (`/`) | 히어로 섹션, 3개 유형 선택 카드 정상 |
| P-02 | About Us (`/about-us`) | About 페이지 로드 |
| P-03 | Contact Us (`/contact-us`) | 문의 폼 정상 |
| P-04 | 공개 채용공고 목록 (`/job/list`) | 공고 리스트 (비로그인) |
| P-05 | 공개 채용공고 상세 (`/job/details/{job_id}/{slug}`) | 상세 정보 표시 (지원 버튼은 로그인 유도) |
| P-06 | 공개 기업 상세 (`/company/details/{id}/{slug}`) | 기업 정보 표시 |
| P-07 | 로그인 선택 페이지 (`/choose-login`) | 5개 유형 로그인 선택 화면 |
| P-08 | 진로검사 바로보기 (`/attempt-to-test/`) | 공개 진로검사 목록 |
| P-09 | 진로검사 응시 (`/attempt-to-test/test/{id}`) | 검사 진행, 결과 저장 |
| P-10 | 공지사항 (`/notices`) | 공지 리스트 |
| P-11 | FAQ (`/faqs/{id}`) | FAQ 내용 표시 |
| P-12 | 사이트맵 (`/sitemap.xml`) | XML 사이트맵 정상 |
| P-13 | 가이드라인 (`/guideline/`) | 가이드 페이지 |
| P-14 | 정책 페이지 (`/trainee-policy`) | 정책 내용 표시 |
| P-15 | 이메일 인증 (`/verfication/verify/{u_type}/{token}`) | 토큰 유효 → 인증 완료 |
| P-16 | 계정 재활성화 요청 (`/request-reactive-account`) | 요청 폼 → 제출 성공 |

---

## 7. 📱 API (모바일 앱)

> **라우트**: `/api/*` (Sanctum/Passport 토큰 인증)

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| API-01 | Health Check (`/api/health-check`) | `{"status": "ok"}` 반환 |
| API-02 | 지역 정보 (`/api/get-provinces`) | Province 리스트 반환 |
| API-03 | 교육기관 정보 (`/api/get-institutes`) | Institute 리스트 반환 |
| API-04 | Trainee Auth — 로그인/회원가입/토큰 발급 | JWT/Sanctum 토큰 정상 |
| API-05 | Trainee 채용공고 목록 | JSON 응답, 페이지네이션 |
| API-06 | Trainee 진로검사 결과 | JSON 응답 |
| API-07 | Trainee 상담 내역 | JSON 응답 |
| API-08 | Trainee 알림 목록 | JSON 응답 |
| API-09 | Trainee 마이페이지 정보 | JSON 응답 |
| API-10 | CGO API — 교육생 목록 | JSON 응답 |

---

## 8. ⚡ 크로스 커팅 테스트

### 8.1 권한 경계 테스트

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| X-01 | Trainee가 `/company/*` URL 직접 접속 | 접근 거부 (401/403) |
| X-02 | Company가 `/cgo/*` URL 직접 접속 | 접근 거부 |
| X-03 | CGO가 `/admin/*` URL 직접 접속 | 접근 거부 |
| X-04 | SchoolKid가 `/trainee/job-support/*` 접속 | 접근 거부 (별도 guard) |
| X-05 | 비로그인 사용자가 로그인 필요 페이지 접속 | 로그인 페이지로 리다이렉트 |

### 8.2 다국어 테스트

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| X-10 | 영어(en) ↔ 싱할라어(sn) ↔ 타밀어(tm) 전환 | UI 문자열 언어 변경 |
| X-11 | 언어 전환 후에도 데이터 CRUD 정상 동작 | 기능에 영향 없음 |

### 8.3 파일 업로드 테스트

| # | 테스트 시나리오 | 예상 결과 |
|---|---|---|
| X-20 | 허용된 확장자 업로드 (jpg, png, pdf 등) | 업로드 성공 |
| X-21 | 허용되지 않은 확장자 업로드 시도 (exe, php 등) | 유효성 검사 에러 |
| X-22 | 2MB/5MB 초과 파일 업로드 | 용량 초과 에러 |
| X-23 | 이미지 리사이징/썸네일 생성 확인 | 정상 생성 |

### 8.4 포괄 시나리오

| # | 플로우 | 참여 유저 |
|---|---|---|
| F-01 | **채용 전체 플로우**: Company가 공고 등록 → Trainee 지원 → Company가 선정/채용 완료 | Company, Trainee |
| F-02 | **OJT 전체 플로우**: Company가 OJT 등록 → CGO가 교육생 매칭 → Trainee가 OJT 확인 | Company, CGO, Trainee |
| F-03 | **상담 전체 플로우**: Trainee가 상담 신청 → CGO가 수락/일정 조율 → 상담 완료 → 피드백 | Trainee, CGO |
| F-04 | **진로검사 플로우**: 비로그인 검사 응시 → 결과 저장 → Trainee 로그인 후 확인 | Public, Trainee |
| F-05 | **계정 활성화 플로우**: 회원가입 → 이메일 인증 → 로그인 → 회원탈퇴 → 재활성화 요청 → Admin 승인 | 모든 유형 |

---

## 9. 🐛 알려진 이슈 & 체크포인트

| # | 영역 | 이슈 |
|---|---|---|
| K-01 | CGO Edit | CGO 수정 폼은 표시되나 DB 저장 안 되는 버그 (2026-06 작업 중) |
| K-02 | 구글 로그인 | 2026-06-02 모든 로그인 페이지에서 구글 로그인 버튼 `hidden` 처리 |
| K-03 | CGO 상담 | `CAS_GracefullTerminationException`이 `exit()` 호출 → `throwInsteadOfExiting()` 필요 |
| K-04 | SQLite | 999개 이상의 param이 들어가는 쿼리는 `array_chunk` 필요 |
| K-05 | Filament | 모든 TextColumn에 `->wrap()` 추가 필요 (줄바꿈 이슈) |
| K-06 | CGO 인스티튜트 | CGO 생성 시 `institute_id` 필수 — 누락 시 상세 페이지 크래시 |
| K-07 | DB 상담 생성 | `assign_history` row가 없으면 상세 페이지 오류 |
| K-08 | CGO 비밀번호 | Mutator가 자동 bcrypt 처리 → 원본 문자열 전달 필요 |
| K-09 | Laravel Blade | `write_file`이 따옴표 이스케이프 — Python3 사용 권장 |
| K-10 | jQuery AJAX | `browser_click` 실패 시 `fetch()` + CSRF meta 태그로 대체 |

---

> **참고**: 각 시나리오는 독립적으로 수행 가능합니다. 특정 유저 유형의 테스트만 진행하려면 해당 섹션만 선택하세요.
> **테스트 계정 정보**: Admin super_admin — manjula@tvec.gov.lk / Videa@2024
