<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Cache;

class codeValidate implements ValidationRule
{

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure( string ): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $code = Cache::get('verification_code_' . $this->user->phone_number);

        if (!$code) {
            $fail(__('auth.The code you entered is expired.'));
            return;
        }

        if ($code != $value) {
            $fail(__('auth.The code you entered is incorrect.'));
            return;
        }
    }
}
