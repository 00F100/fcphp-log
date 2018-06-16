<?php

namespace FcPhp\Log\Interfaces
{
	use FcPhp\Log\Interfaces\ILog;
	
	interface ILog
	{
		public static function getInstance(string $directoryOutput, $dateFormat = 'Y-m-d H:i:s', string $extension = 'log', bool $debug = false) :ILog;

		public function __construct(string $directory, string $dateFormat = 'Y-m-d H:i:s', string $extension = 'log', bool $debug = false);

		public function __call($method, array $args = []);

		public function write(string $fileName, string $logText);
	}
}