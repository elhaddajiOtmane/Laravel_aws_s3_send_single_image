<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64Rule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Regular expression to validate Base64 string
        $pattern = '/^data:image\/(\w+);base64,/';

        // Check if the value matches the Base64 pattern
        return preg_match($pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid Base64-encoded image.';
    }
}
