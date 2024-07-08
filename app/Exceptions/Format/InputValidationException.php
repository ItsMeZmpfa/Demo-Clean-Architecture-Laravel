<?php

namespace App\Exceptions\Format;

use App\Exceptions\Base\ApplicationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class InputValidationException extends ApplicationException
{

    public function help(): string
    {
        return trans("Check if the given input is valid");
    }

    public function error(): string
    {
        return trans("Something went wrong with Input Your provide");
    }

    public function errorCode(): int
    {
        return ResponseAlias::HTTP_BAD_REQUEST;
    }
}
