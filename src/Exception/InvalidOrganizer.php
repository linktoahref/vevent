<?php

namespace LTAH\Generator\Exception;

use Exception;

class InvalidOrganizer extends Exception
{
    /**
     * @param  string $message
     * @return self
     */
    function construct(string $message) {
        parent::__construct($message);
    }
}
