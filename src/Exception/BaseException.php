<?php

namespace Ziishaned\PhpLicense\Exception;

use Exception;

class BaseException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        if ($openSSlErrorMessage = openssl_error_string()) {
            $this->message = sprintf(
                '%s%sUnderlying OpenSSL message : %s',
                parent::getMessage(),
                PHP_EOL,
                $openSSlErrorMessage
            );
        }
    }
}
