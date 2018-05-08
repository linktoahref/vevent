<?php

namespace LTAH\Generator\Exception;

use DateTime;
use Exception;

class InvalidDatesException extends Exception
{
    /**
     * @param  DateTime $start
     * @param  DateTime $end
     * @return self
     */
    function construct(DateTime $start, DateTime $end) {
        parent::__construct("`{$start->format('YMD His')}` must be greater than `{$end->format('YMD His')}`");
    }
}
