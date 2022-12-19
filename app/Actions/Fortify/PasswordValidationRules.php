<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Password as FacadesPassword;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return ['required', 'string', (new Password)->length(10), 'confirmed'];
    }
}
