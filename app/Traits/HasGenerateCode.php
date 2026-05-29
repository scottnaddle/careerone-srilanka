<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\VerificationCode;
use Nette\Utils\Random;

trait HasGenerateCode
{

    /**
     * Generate a *0-9* code of a given length
     */
    public function generateCode(int $lenght = 6): string
    {
        return Random::generate($lenght, "0-9");
    }

    /**
     * Generate a verification code for a given user
     */
    public function generateVerificationCodeFor(
        object $user,
        string $modelRegistered,
        bool $isResetCode = false
    ): VerificationCode {
        $code = $this->generateCode();
        while (
            VerificationCode::where("code", $code)->first() ||
            strlen($code) !== 6
        ) {
            $code = $this->generateCode();
        }

        $verification_code = VerificationCode::where(['email' => $user->email, 'u_type' => $modelRegistered])->first();
        if ($verification_code) {
            $verification_code->code = $code;
            $verification_code->expired_at = now()->addMinutes(5);
            $verification_code->is_reset_code = true;
            $verification_code->save();
            return $verification_code;
        } else {
            return VerificationCode::create([
                'email' => $user->email,
                'code' => $this->generateCode(),
                'u_type' => $modelRegistered,
                'expired_at' => now()->addMinutes(5),
                'is_reset_code' => $isResetCode
            ]);
        }
    }
}
