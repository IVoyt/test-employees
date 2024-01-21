<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $code = 404;

    public function __construct(string $message)
    {
        $this->message = $message;

        parent::__construct($this->message, $this->code, $this->getPrevious());
    }
}