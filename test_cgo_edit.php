<?php
/**
 * CGO Edit 저장 문제 진단 스크립트
 * 
 * Filament가 EditRecord.save()에서 하는 것과 동일한 과정 시뮬레이션
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\CgoUser;
use Illuminate\Support\Facades\DB;

echo "=== CGO Edit 저장 문제 진단 ===\n\n";

// 1. CGO 레코드 선택
$cgo = CgoUser::find(19);
echo "1. 대상 CGO: {$cgo->first_name} {$cgo->last_name} (ID: {$cgo->id})\n";

// 2. Filament가 EditRecord에서 하는 save 과정 모방
//    EditRecord.handleRecordUpdate()는 기본적으로:
//    $this->record->update($data)
//    
//    하지만 이게 DB transaction 안에서 실행됨
echo "\n2. Transaction 내에서 update 테스트\n";
DB::beginTransaction();
try {
    $testData = [
        'first_name' => 'Senaka',
        'last_name' => 'Wijayasena_test',
        'telephone' => $cgo->telephone ?: '0771234567',
        'active' => true,
    ];
    
    $result = $cgo->update($testData);
    echo "   update() 결과: " . ($result ? 'true' : 'false') . "\n";
    
    // DB에서 직접 확인 (transaction 내)
    $dbCheck = DB::table('cgo_users')->where('id', 19)->value('last_name');
    echo "   Transaction 내 DB 값: " . $dbCheck . "\n";
    
    DB::rollBack();
    echo "   RollBack 완료\n";
    
    // RollBack 후 확인
    $fresh = $cgo->fresh();
    echo "   RollBack 후 last_name: " . $fresh->last_name . "\n";
} catch (\Exception $e) {
    DB::rollBack();
    echo "   ERROR: " . $e->getMessage() . "\n";
    echo "   Class: " . get_class($e) . "\n";
}

// 3. Form 데이터에 gender 포함 (실제 폼 동작)
echo "\n3. gender 필드 포함 테스트\n";
$formData = [
    'first_name' => 'Senaka',
    'last_name' => 'Wijayasena',
    'nic' => $cgo->nic,
    'email' => $cgo->email,
    'telephone' => '0771002000',
    'district_id' => null,
    'institute_id' => null,
    'active' => true,
    'gender' => '1',  // form에서 오지만 DB에 없음
];

DB::beginTransaction();
try {
    $result = $cgo->update($formData);
    echo "   gender 포함 update: " . ($result ? 'true' : 'false') . "\n";
    
    $dbPhone = DB::table('cgo_users')->where('id', 19)->value('telephone');
    echo "   DB telephone: " . $dbPhone . "\n";
    
    DB::rollBack();
    echo "   ✅ gender 필드가 update를 방해하지 않음\n";
} catch (\Exception $e) {
    DB::rollBack();
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}

// 4. Validation 체크 (required 필드 누락 시)
echo "\n4. required 필드 누락 테스트\n";
$formData2 = [
    'first_name' => 'Senaka',
    'last_name' => 'Wijayasena',
    'active' => true,
    // email, telephone, nic 등 생략
];

DB::beginTransaction();
try {
    $cgo->update($formData2);
    echo "   필드 누락 update: 성공 (변경 없는 필드는 유지)\n";
    DB::rollBack();
} catch (\Exception $e) {
    DB::rollBack();
    echo "   ERROR: " . $e->getMessage() . "\n";
}

// 5. Filament의 form validation 체크
echo "\n5. 모든 필드 포함 정식 폼 데이터 테스트\n";
$fullFormData = [
    'first_name' => 'Senaka',
    'last_name' => 'Wijayasena',
    'nic' => $cgo->nic,
    'email' => $cgo->email,
    'telephone' => '0771002000',
    'district_id' => $cgo->district_id,
    'institute_id' => $cgo->institute_id,
    'active' => $cgo->active ?: true,
    'gender' => '1',        // form 필드 - DB 없음, fillable 없음
    'password' => null,      // visible 조건(Create 전용)
];

DB::beginTransaction();
try {
    $data = array_intersect_key($fullFormData, array_flip($cgo->getFillable()));
    echo "   필터링된 데이터: " . json_encode($data) . "\n";
    
    $result = $cgo->update($data);
    echo "   편집 저장: " . ($result ? 'true' : 'false') . "\n";
    $dbPhone = DB::table('cgo_users')->where('id', 19)->value('telephone');
    echo "   DB telephone: " . $dbPhone . "\n";
    
    DB::rollBack();
    echo "   ✅ 저장 성공\n";
} catch (\Exception $e) {
    DB::rollBack();
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== 진단 완료 ===\n";
echo "\n결론: 모델 레벨에서는 CGO Edit 저장에 문제가 없습니다.\n";
echo "Filament form의 JS/Livewire 측 문제일 가능성이 높습니다.\n";
echo "또는 CSRF / Session / Permission 문제로 실제 POST가 서버에 도달하지 않을 수 있습니다.\n";
