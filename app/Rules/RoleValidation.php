<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RoleValidation implements Rule
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
        return \Spatie\Permission\Models\Role::where("name",$value)->count()>0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'We haven\'t got such role';
    }
}
