<?php

class ErrorHandler
{
    public static function handleException(Throwable $exception): void
    {
        echo json_decode([
            "code" => $exception->getCode(),
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine()
        ]);
    }
}