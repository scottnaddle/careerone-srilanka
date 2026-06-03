<?php

namespace App\Services\Trainee;

use App\Models\District;
use App\Models\DivisionalSecretariats;
use App\Models\Institute;
use App\Models\Job;
use App\Models\JobBookmark;
use App\Models\Province;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ProvincesDistrictsService
{
    protected object $provinceModel;
    protected object $districtModel;
    protected object $divisionalModel;

    /**
     * ProvincesDistrictsService constructor.
     * @param Province $provinceModel
     * @param District $districtModel
     */
    public function __construct(Province $provinceModel, District $districtModel, DivisionalSecretariats $divisionalSecretariat)
    {
        $this->provinceModel = $provinceModel;
        $this->districtModel = $districtModel;
        $this->divisionalModel = $divisionalSecretariat;
    }

    /**
     * Get the list of province and the list of districts of each province
     * @return mixed
     */
    public function getProvinces(): mixed
    {
        $provinces = $this->provinceModel->get();

        foreach ($provinces as $province) {
            $allProvinceInstitutes = collect();

            $province->districts = $this->districtModel->where('prov_id', (string)$province->id)->get();

            foreach ($province->districts as $district) {
                $allDistrictInstitutes = collect();

                $districtInstitutes = Institute::where('dist_id', $district->id)->get();
                $allDistrictInstitutes = $allDistrictInstitutes->merge($districtInstitutes);

                $district->divisionalSecretariats = DivisionalSecretariats::where('dist_id', $district->id)->get();

                foreach ($district->divisionalSecretariats as $divisionalSecretariat) {
                    $divisionalInstitutes = Institute::where('ds_id', $divisionalSecretariat->ds_code)->get();
                    $allDistrictInstitutes = $allDistrictInstitutes->merge($divisionalInstitutes);

                    $divisionalSecretariat->institutes = $divisionalInstitutes;
                }

                $district->institutes = $allDistrictInstitutes;

                $allProvinceInstitutes = $allProvinceInstitutes->merge($allDistrictInstitutes);
            }

            $province->institutes = $allProvinceInstitutes;
        }

        return $provinces;
    }





    /**
     * Get only list of provinces
     * @return array
     */
    public function getProvincesV2()
    {
        $provinces = $this->provinceModel->query()->select('id as value', 'name as label')->get();
        foreach ($provinces as $province) {
            $province->districts = $this->districtModel->where('prov_id', (string)$province->value)->select('id as value', 'name as label')->get();
        };
        return ['data' => $provinces];
    }

    /**
     * @param $provinceId
     * @return array
     */
    public function getDistrictsByProvinceId($provinceId): array
    {
        $districts = $this->districtModel->where('prov_id', (string)$provinceId)->with(['divisionalSecretariats'])->get();
        $res = [];
        foreach ($districts as $district) {
            $res[] = [
                'label' => $district->name,
                'value' => $district->id,
            ];
        };
        return [
            'data' => $res,
            'total' => count($res),
        ];
    }

    public function getDivisionalSecretariatByDistrictId($districtId) : array
    {
        $divisionals = $this->divisionalModel->where('dist_id', (string)$districtId)->get();
        $res = [];
        foreach ($divisionals as $divisional) {
            $res[] = [
                'label' => $divisional->ds_name,
                'value' => $divisional->ds_code,
            ];
        };
        return [
            'data' => $res,
            'total' => count($res),
        ];
    }

    public function getDistrictById($districtId)
    {
        $district = $district = District::with('divisionalSecretariats')->findOrFail($districtId);
        return $district;
    }

    public function getProvinceAndDistrictById($provinceId, $districtId, $divisionalId)
    {
        if (!$provinceId) {
            return [null, null, null];
        }

        $province = $this->provinceModel->with('districts')->findOrFail($provinceId);

        if (!$districtId) {

            return [$province, null, null];
        }

        $district = District::with('divisionalSecretariats')->findOrFail($districtId);

        if (!$divisionalId) return [$province, $district, null];

        $divisional = DivisionalSecretariats::where('id', $divisionalId)->firstOrFail();
        $language = app()->getLocale();
        $ownership = getCodeList('ownership', $language);
        // $activeStatus = getCodeList('active', $language);
        return [$province, $district, $divisional];
    }

    public function getInstituteByAnotherField($provinceId, $districtId, $divisionalId, $instituteId)
    {
        $language = app()->getLocale();

        if (!$provinceId) {
            return [null, null, null, null];
        }

        $province = $this->provinceModel->with('districts')->findOrFail($provinceId);

        if (!$districtId) {

            return [$province, null, null, null];
        }

        $district = District::with('divisionalSecretariats')->findOrFail($districtId);

        if (!$divisionalId) return [$province, $district, null, null];

        $divisional = DivisionalSecretariats::where('ds_code', $divisionalId)->firstOrFail();
//        $divisional = DivisionalSecretariats::where('id', $divisionalId)->firstOrFail();


        if (!$instituteId) {
            return  [$province, $district, $divisional, null];
        }

        $institute = Institute::where('id', $instituteId)->firstOrFail();

        return [$province, $district, $divisional, $institute];
    }
}
