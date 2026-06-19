<?php
namespace App\Services\Admin\api;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalApiService
{
    private function callApi(array $body)
{
    $apiUrl = env('API_URL');
    $username = env('API_USERNAME');
    $password = env('API_PASSWORD');
    $response = Http::withBasicAuth($username, $password)->withoutVerifying()->post($apiUrl, $body);

    if ($response->successful()) {
        $responseBody = $response->body();
        $patterns = '/(?<=\})(?=\{)/';
        $objects = preg_split($patterns, $responseBody);

        $data = [];

        foreach ($objects as $object) {
            $jsonData = json_decode($object, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Skip malformed fragments instead of halting the whole sync.
                Log::warning('ExternalApiService JSON decode error: ' . json_last_error_msg(), ['fragment' => $object]);
                continue;
            }
            $data[] = $jsonData;
        }

        return $data;
    }

    return null;
}

    public function getApiDataInstitute()
    {
        $body = [
            'MASTER' => 'INSTITUTE',
        ];
        return $this->callApi($body);
    }
    public function getApiDataREGCOURSES()
    {
        $body = [
            'MASTER' => 'REG_COURSES',
        ];
        return $this->callApi($body);
    }
    public function getApiDataNVQCOURSES()
    {
        $body = [
            'MASTER' => 'NVQ_COURSES',
        ];
        return $this->callApi($body);
    }
    public function getApiDataPACKAGES()
    {
        $body = [
            'MASTER' => 'PACKAGES',
        ];
        return $this->callApi($body);
    }
    public function getApiDataHeadOffices()
    {
        $body = [
            'MASTER' => 'HEAD_OFFICE',
        ];
        return $this->callApi($body);
    }
}
