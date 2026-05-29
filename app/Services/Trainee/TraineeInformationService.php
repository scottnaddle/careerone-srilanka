<?php

namespace App\Services\Trainee;

use App\Models\TraineeUser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TraineeInformationService
{
    protected $username;
    protected $password;
    protected $url;
    protected $url1;
    protected $url2;
    protected $url3;


    public function __construct()
    {
        $this->username = env('API_USERNAME') ?? "tvec_Au_4_nvq";
        $this->password = env('API_PASSWORD') ?? "Al24#GwyZp";
        $this->url1 = env('API_URL1') ?? 'https://www.nvq.gov.lk/api/api1_applicant.php';
        $this->url2 = env('API_URL2') ?? 'https://www.nvq.gov.lk/api/api2_trainee.php';
        $this->url3 = env('API_URL3') ?? 'https://www.nvq.gov.lk/api/api3_skills_passport.php';
        $this->url7 = env('API_URL7') ?? 'https://www.nvq.gov.lk/api/api7_trainee_certificates.php';
    }

    public function getTraineeInformation($nic)
    {
        try {
            $response = Http::withBasicAuth($this->username, $this->password)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->withoutVerifying()
                ->post($this->url1, [
                    'NIC' => $nic,
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error retrieving trainee information: ' . $e->getMessage());
            return ['error' => 'An error occurred while retrieving trainee information.'];
        }
    }

    public function getTrainingHistoryInformation($nic)
    {
        try {
            $response = Http::withBasicAuth($this->username, $this->password)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->withoutVerifying()
                ->post($this->url2, [
                    'NIC' => $nic,
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error retrieving training history information: ' . $e->getMessage());
            return ['error' => 'An error occurred while retrieving training history information.'];
        }
    }
    public function checkSkillPassportInformation($nic)
    {
        try {
            $response = Http::withBasicAuth($this->username, $this->password)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->withoutVerifying()
                ->post($this->url3, [
                    'NIC' => $nic,
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error retrieving training history information: ' . $e->getMessage());
            return ['error' => 'An error occurred while retrieving training history information.'];
        }
    }

    public function syncTrainingInfomationOfTraineeToDB($nic)
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->withoutVerifying()
            ->post($this->url, [
                'NIC' => $nic,
            ]);
        return $response->json();
    }

    public function getTrainingHistoryCertificates($nic)
    {
        try {
            $response = Http::withBasicAuth($this->username, $this->password)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->withoutVerifying()
                ->post($this->url7, [
                    'NIC' => $nic,
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error retrieving training history certificate: ' . $e->getMessage());
            return ['error' => 'An error occurred while retrieving training history certificate.'];
        }
    }
}
