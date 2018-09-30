<?php

namespace core;

/**
 * ErrorHandler class
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class ErrorHandler
{
    /**
     * Handle the error
     *
     * @param int    $level    Error level
     * @param string $message  Error message
     * @param string $file     File name
     * @param int    $line     Line number
     *
     * @throws \ErrorException
     */
    public static function handleError(int $level, string $message, string $file, int $line)
    {
        if (error_reporting() !== 0) {  // to allow @ operator keep working
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Handle the exception
     *
     * @param \Exception $exception Exception
     */
    public static function handleException(\Exception $exception)
    {
        $statusCode = (404 === $exception->getCode() ? $exception->getCode() : 500);

        //set http respose code for browser
        \http_response_code($statusCode);

        //write error info to log file
        \ini_set('error_log', self::getLogFile());
        \error_log($exception);

        //display error page to user
        View::renderTemplate("$statusCode.html");
    }

    /**
     * Return log file name
     *
     * @return string
     */
    private static function getLogFile(): string
    {
      return  \sprintf(
            '%s/logs/log_report_%s.txt',
            \dirname(__DIR__),
            \date('d-m-Y')
        );
    }
}
