<?php

namespace App\Exceptions\Format;

use App\Exceptions\Base\ApplicationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class JsonEncodeException extends ApplicationException
{
    public function help(): string
    {
        return trans('exception.json_not_encoded.help');
    }

    public function error(): string
    {
        return trans('exception.json_not_encoded.error');
    }

    public function errorCode(): int
    {
        return ResponseAlias::HTTP_BAD_REQUEST;
    }
}
