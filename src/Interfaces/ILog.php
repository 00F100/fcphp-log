<?php

namespace FcPhp\Log\Interfaces
{
    use FcPhp\Log\Interfaces\ILog;
    
    interface ILog
    {
        /**
         * Method to return instance of Log
         *
         * @param string $directoryOutput Directory to write logs
         * @param string|bool $dateFormat Format of date to print log. If `false` not print date
         * @param string $extension Extension of file log
         * @param bool $debug Enable debug mode
         * @return FcPhp\Log\Interfaces\ILog
         */
        public static function getInstance(string $directoryOutput, $dateFormat = 'Y-m-d H:i:s', string $extension = 'log', bool $debug = false) :ILog;

        /**
         * Method to construct instance of Log
         *
         * @param string $directory Directory to write logs
         * @param bool $debug Flag to turn on debug logs
         * @return void
         */
        public function __construct(string $directory, string $dateFormat = 'Y-m-d H:i:s', string $extension = 'log', bool $debug = false);

        /**
         * Method to capture commands to print log
         *
         * @param string $method Method to execute
         * @param array $args Args to method
         * @return void
         */
        public function __call($method, array $args = []);

        /**
         * Method to write log
         *
         * @param string $fileName File name to save log
         * @param string $logText Text to log
         * @return void
         */
        public function write(string $fileName, string $logText);

        /**
         * Method to configure custom log
         *
         * @param object $closure
         * @return FcPhp\Log\Interfaces\ILog
         */
        public function customLog($clousure) :ILog;
    }
}
