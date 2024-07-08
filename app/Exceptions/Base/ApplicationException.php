<?php

namespace App\Exceptions\Base;

use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class ApplicationException extends Exception
{
    public function render(Request $request): Response
    {
        $error = new Error($this->help(), $this->error());
        return response($error, $this->errorCode());
    }

    abstract public function help(): string;

    abstract public function error(): string;

    abstract public function errorCode(): int;
}
