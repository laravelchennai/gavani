<?php

namespace App\Rules\Site;

use Illuminate\Contracts\Validation\Rule;

class DomainMustBeValid implements Rule
{
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute is not valid';
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
        return checkdnsrr($value, 'A');
    }
}
