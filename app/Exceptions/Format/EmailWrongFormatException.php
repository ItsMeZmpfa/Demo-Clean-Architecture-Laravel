<?php

namespace App\Exceptions\Format;

use App\Exceptions\Base\ApplicationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EmailWrongFormatException extends ApplicationException
{

    public function help(): string
    {
        return trans("Check if the email format is correct");
    }

    public function error(): string
    {
        return trans("Email format is invalid");
    }

    public function errorCode(): int
    {
        return ResponseAlias::HTTP_BAD_REQUEST;
    }
}
