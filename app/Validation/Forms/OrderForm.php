<?php

namespace Cart\Validation\Forms;

use Respect\Validation\Validator;

class OrderForm
{
    public static function rules(): array
    {
        return [
            'email' => Validator::email(),
            'name' => Validator::alpha(' '),
            'address1' => Validator::alnum(' -'),
            'address2' => Validator::optional(Validator::alnum(' -')),
            'city' => Validator::alnum(' '),
            'postal_code' => Validator::alnum(' ')
        ];
    }
}