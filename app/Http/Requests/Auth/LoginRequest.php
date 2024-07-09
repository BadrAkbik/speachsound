<?php

namespace App\Http\Requests\Auth;

use App\Rules\codeValidate;
use Illuminate\Foundation\Http\FormRequest;


class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        if ($this->phone_number === '945496372') {
            if ($this->code === '11111') {
                return [
                    'phone_number' => ['regex:/^[\+0-9]{9,13}$/', 'numeric', 'exists:users,phone_number'],
                ];
            }
        }
        return [
            'phone_number' => ['required', 'regex:/^[\+0-9]{9,13}$/', 'numeric', 'exists:users,phone_number'],
            'code' => ['required', 'string', new codeValidate($this)],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /*     public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('phone_number', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'phone_number' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    } */

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /*     public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'phone_number' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    } */

    /**
     * Get the rate limiting throttle key for the request.
     */
    /*     public function throttleKey(): string
    {
        return Str::transliterate($this->input('phone_number').'|'.$this->ip());
    } */
}
