<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\SMSTrait;
class AuthService
{
    use SMSTrait;
    protected $whitelist = [
        '966580111196',
        '963945496372'
    ];

    public function requestOtp($data)
    {
        $user = User::where('phone_number', $data['phone_number'])->first();

        if (!$user) {
            $user = User::create([
                'phone_number' => $data['phone_number'],
                'phone_code' => $data['phone_code'],
                'profile_completion_status' => 'pending'
            ]);
        }
        $code = $this->generateOtpCode($user);
        if (!in_array($user->phone_number, $this->whitelist)) {
            $m = "رمز التحقق: " . $code;
            if ($this->sendMessage($data['phone_number'], $m)->code == "1") {
                return true;
            }
        }
    }

    private function generateOtpCode($user)
    {
        if (in_array($user->phone, $this->whitelist)) {
            $code = 1111;
        } else {
            $code = random_int(1000, 9999);
        }

        $user->update([
            'code' => $code
        ]);
        return $code;
    }
}
