<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Filter implements ValidationRule
{
    protected $bloked;
    public function __construct($bloked)
    {
        $this->bloked = $bloked;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(in_array(strtolower($value) , $this->bloked)){
            $fail('This value is blocked!!!');
        }
    }
}
