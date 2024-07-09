<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(NewPasswordRequest $request): JsonResponse
    {
        $user = User::firstWhere('phone_number', $request->phone_number);

        $user->update($request->safe()->only('password'));

        event(new PasswordReset($user));

        return response()->json(['message' => __('auth.password has been successfully reseted')], 200);
    }
}
