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
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'token' => $this->token
            ])
                ->withoutVerifying()
                ->post($this->url . "/create", [
                    'data' => $data,
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error during sign up: ' . $e->getMessage());
            return ['error' => 'An error occurred while signing up.'];
        }
    }

    public function updateUser($data) {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'token' => $this->token
            ])
                ->withoutVerifying()
                ->post($this->url . "/update", [
                    'data' => $data,
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error during user update: ' . $e->getMessage());
            return ['error' => 'An error occurred while updating the user.'];
        }
    }

    public function changePassword($data) {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'token' => $this->token
            ])
                ->withoutVerifying()
                ->post($this->url . "/change-password", [
                    'data' => $data,
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error during password change: ' . $e->getMessage());
            return ['error' => 'An error occurred while changing the password.'];
        }
    }
    public function deleteUser($nic) {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'token' => $this->token
            ])
                ->withoutVerifying()
                ->post($this->url . "/delete", [
                    'data' => $nic,
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error during user deletion: ' . $e->getMessage());
            return ['error' => 'An error occurred while deleting the user.'];
        }
    }




}
