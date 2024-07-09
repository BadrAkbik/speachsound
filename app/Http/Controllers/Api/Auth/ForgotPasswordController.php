<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetCode;
use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class ForgotPasswordController extends Controller
{

    public function store(Request $request): JsonResponse
    {
        $request->validate( [
            'phone_number' => [ 'required', 'regex:/^[\+0-9]{9,13}$/', 'numeric', 'exists:users,phone_number'],
        ] );

        $user = User::Where( 'phone_number', $request->phone_number )->first();

        // $user->notify( new SendVerifySMS() );
      /*   $user->sendMobileVerificationNotification(); */

        
        return response()->json(['message' => 'password verification code is sent to your email'], 200);
    }
}