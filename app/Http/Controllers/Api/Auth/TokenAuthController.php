<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Notifications\SendVerifySMS;
use Illuminate\Http\Request;

class TokenAuthController extends Controller
{
    public function store(LoginRequest $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        return $user->createToken($request->phone_number)->plainTextToken;
    }

    public function sendsms(Request $request)
    {
        $validated = $request->validate(['phone_number' => ['required', 'regex:/^[\+0-9]{9,13}$/', 'numeric'],]);
        $user = User::where('phone_number', $validated['phone_number'])->first();
        if (!$user) {
            return response()->json([
                'message' => __('auth.not_registered')
            ], 422);
        }

        $user->notify(new SendVerifySMS());
        return response()->json([
            'message' => __('api.login successfully, but code is needed')
        ]);
    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->sendMessage(__('api.Logged out'), 200);
    }
}
