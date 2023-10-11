<?php

function logException(Exception $exception)
{
    return self::class . " " . __FUNCTION__ . " " . json_encode($exception->getTrace());
}
