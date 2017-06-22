<?php

namespace Cart\Validation;

use Cart\Validation\Contracts\ValidatorInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator implements ValidatorInterface
{
    protected $errors = [];

    public function validate(Request $request, array $rules)
    {
        foreach ($rules as $filed => $rule) {
            try {
                $rule->setName(ucfirst($filed))->assert($request->getParam($filed));
            } catch (NestedValidationException $e) {
                $this->errors[$filed] = $e->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    public function fails()
    {
        return !empty($this->errors);
    }
}