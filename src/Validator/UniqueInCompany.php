<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueInCompany extends Constraint
{
    public string $message = 'La valeur "{{ string }}" est déjà utilisée.';

    public function __construct(string $message = null, array $options = [], array $groups = [], mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->message = $message ?? $this->message;
    }
}
