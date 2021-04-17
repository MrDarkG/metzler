<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumberValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ( $value[0]=="+" && is_numeric(substr($value,1)) );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must start with "+" and other characters must be numbers ';
    }
}
