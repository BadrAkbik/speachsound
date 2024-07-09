<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MobileVerificationNotificationController extends Controller
{
    public function store(Request $request): JsonResponse|RedirectResponse
    {

        if ($request->user()->hasVerifiedMobile()) {
            return response()->json(['message' => 'ُMobile is already verified']);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status' => 'Verification code has been sent to your Mobile']);
    }
}
