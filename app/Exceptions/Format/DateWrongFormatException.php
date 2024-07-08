<?php

namespace App\Exceptions\Format;

use App\Exceptions\Base\ApplicationException;
use Symfony\Component\HttpFoundation\Response;

class DateWrongFormatException extends ApplicationException
{

    public function help(): string
    {
        return trans("Check if the given Date is valid");
    }

    public function error(): string
    {
        return trans("The given Date is not valid");
    }

    public function errorCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
