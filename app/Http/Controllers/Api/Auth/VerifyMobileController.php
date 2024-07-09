<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MobileVerificationRequest;
use Illuminate\Auth\Events\Verified;

class VerifyMobileController extends Controller
{

    public function __invoke(MobileVerificationRequest $request)
    {
        if ($request->user()->markMobileAsVerified()) {
            event(new Verified($request->user()));
        }

        return response()->json([
            'message' => __('auth.Your phone number has been verified successfully')
        ]);
    }
}
