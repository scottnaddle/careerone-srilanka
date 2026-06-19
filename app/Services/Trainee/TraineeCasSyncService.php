<?php

namespace App\Services\Trainee;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class TraineeCasSyncService
{
    protected $token;
    protected $url;


    public function __construct()
    {
        $this->token = env('SECRET_KEY');
        $this->url = env('CAS_SYNC_URL');
    }

    public function signUp($data)
    {
        $logData = $data;
        if (isset($logData['password'])) {
            $logData['password'] = '******';
        }

        Log::channel('cas_sync')->info('CAS Sync [signUp] - Initiating signup.', [
            'url' => $this->url . "/create",
            'payload' => $logData
        ]);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'token' => $this->token
            ])
                ->withoutVerifying()
                ->post($this->url . "/create", [
                    'data' => $data,
                ]);

            $status = $response->status();
            $body = $response->body();
            $json = $response->json();

            if ($response->successful()) {
                Log::channel('cas_sync')->info('CAS Sync [signUp] - Success.', [
                    'status' => $status,
                    'response' => $json
                ]);
            } else {
                Log::channel('cas_sync')->error('CAS Sync [signUp] - Failed.', [
                    'status' => $status,
                    'response' => $body
                ]);
            }

            return $json;
        } catch (\Exception $e) {
            Log::channel('cas_sync')->error('Error during sign up: ' . $e->getMessage());
            return ['error' => 'An error occurred while signing up.'];
        }
    }

    public function updateUser($data) {
        $payload = is_object($data) ? (method_exists($data, 'toArray') ? $data->toArray() : (array) $data) : $data;
        if (isset($payload['password'])) {
            $payload['password'] = '******';
        }

        Log::channel('cas_sync')->info('CAS Sync [updateUser] - Initiating user update.', [
            'url' => $this->url . "/update",
            'payload' => $payload
        ]);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'token' => $this->token
            ])
                ->withoutVerifying()
                ->post($this->url . "/update", [
                    'data' => $data,
                ]);

            $status = $response->status();
            $body = $response->body();
            $json = $response->json();

            if ($response->successful()) {
                Log::channel('cas_sync')->info('CAS Sync [updateUser] - Success.', [
                    'status' => $status,
                    'response' => $json
                ]);
            } else {
                Log::channel('cas_sync')->error('CAS Sync [updateUser] - Failed.', [
                    'status' => $status,
                    'response' => $body
                ]);
            }

            return $json;
        } catch (\Exception $e) {
            Log::channel('cas_sync')->error('Error during user update: ' . $e->getMessage());
            return ['error' => 'An error occurred while updating the user.'];
        }
    }

    public function changePassword($data) {
        $payload = $data;
        if (isset($payload['password'])) { $payload['password'] = '******'; }
        if (isset($payload['new_password'])) { $payload['new_password'] = '******'; }
        if (isset($payload['old_password'])) { $payload['old_password'] = '******'; }

        Log::channel('cas_sync')->info('CAS Sync [changePassword] - Initiating password change.', [
            'url' => $this->url . "/change-password",
            'payload' => $payload
        ]);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'token' => $this->token
            ])
                ->withoutVerifying()
                ->post($this->url . "/change-password", [
                    'data' => $data,
                ]);

            $status = $response->status();
            $body = $response->body();
            $json = $response->json();

            if ($response->successful()) {
                Log::channel('cas_sync')->info('CAS Sync [changePassword] - Success.', [
                    'status' => $status,
                    'response' => $json
                ]);
            } else {
                Log::channel('cas_sync')->error('CAS Sync [changePassword] - Failed.', [
                    'status' => $status,
                    'response' => $body
                ]);
            }

            return $json;
        } catch (\Exception $e) {
            Log::channel('cas_sync')->error('Error during password change: ' . $e->getMessage());
            return ['error' => 'An error occurred while changing the password.'];
        }
    }
    public function deleteUser($nic) {
        Log::channel('cas_sync')->info('CAS Sync [deleteUser] - Initiating user deletion.', [
            'url' => $this->url . "/delete",
            'nic' => $nic
        ]);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'token' => $this->token
            ])
                ->withoutVerifying()
                ->post($this->url . "/delete", [
                    'data' => $nic,
                ]);

            $status = $response->status();
            $body = $response->body();
            $json = $response->json();

            if ($response->successful()) {
                Log::channel('cas_sync')->info('CAS Sync [deleteUser] - Success.', [
                    'status' => $status,
                    'response' => $json
                ]);
            } else {
                Log::channel('cas_sync')->error('CAS Sync [deleteUser] - Failed.', [
                    'status' => $status,
                    'response' => $body
                ]);
            }

            return $json;
        } catch (\Exception $e) {
            Log::channel('cas_sync')->error('Error during user deletion: ' . $e->getMessage());
            return ['error' => 'An error occurred while deleting the user.'];
        }
    }
}
