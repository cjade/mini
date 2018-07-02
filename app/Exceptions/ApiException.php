<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class ApiException extends Exception
{
    protected $body;

    public function __construct ($message = "", $body = '', $code = 0)
    {
        parent::__construct($message, $code);
        $this->body = $body;
    }

    public function render (Request $request)
    {
        if (!$request->expectsJson()) {
            return jsonError($this->message, $this->code, $this->body);
        }
    }


}
