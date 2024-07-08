<?php

namespace App\Models;

use Illuminate\Validation\ValidationException;

class EmailValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException();
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function isEqualTo(self $email): bool
    {
        return $this->value == $email->value;
    }
}
