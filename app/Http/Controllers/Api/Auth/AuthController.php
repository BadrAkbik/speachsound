<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthController extends BaseController
{
    public function login(LoginRequest $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        $token = $user->createToken($request->phone_number)->plainTextToken;

        $this->forgetOtpCode($user->phone_number);
        return $this->withSuccess([
            'profile_completion_status' => $user->profile_completion_status,
            'user_subscription' => $user->subscription,
            'token' => $token
        ]);
    }

    public function otpRequest(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => ['required', 'regex:/^[\+0-9]{9,13}$/', 'numeric'],
            'phone_code' => ['required', 'regex:/^[\+0-9]{1,5}$/', 'numeric'],
        ]);

        $user = User::where('phone_number', $validated['phone_number'])->first();

        if (!$user) {
            $user = User::create([
                'phone_number' => $request->phone_number,
                'phone_code' => $request->phone_code,
                'profile_completion_status' => 'pending'
            ]);
        }
        $this->generateOtpCode($user->phone_number);
        // $user->notify(new SendVerifySMS());
        return $this->withSuccess(message: __('api.otp_sent'));
    }

    public function generateOtpCode($phone_number)
    {
        $code = mt_rand(1000, 9999);
        Cache::put('verification_code_' . $phone_number, now()->minutes(10));
        return $code;
    }

    public function forgetOtpCode($phone_number)
    {
        Cache::forget('verification_code_' . $phone_number);
    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->withSuccess(message: __('api.logged_out'));
    }
}
