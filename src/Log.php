<?php

namespace FcPhp\Log
{
	use FcPhp\Log\Interfaces\ILog;
	use FcPhp\Log\Exceptions\NotPermissionException;

	class Log implements ILog
	{
		/**
		 * @var array
		 */
		private $nonDebug = ['error', 'warning'];

		/**
		 * @var bool
		 */
		private $debug;
		/**
		 * @var string
		 */
		private $directory;
		/**
		 * @var string
		 */
		private $extension;
		/**
		 * @var string
		 */
		private $dateFormat;

		/**
		 * @var FcPhp\Log\Interfaces\ILog
		 */
		private static $instance;

		/**
		 * Method to return instance of Log
		 *
		 * @param string $directory Directory to write logs
		 * @return FcPhp\Log\Interfaces\ILog
		 */
		public static function getInstance(string $directory, string $extension = 'log')
		{
			if(!self::$instance instanceof ILog) {
				self::$instance = new Log($directory, true, $extension);
			}
			return self::$instance;
		}

		/**
		 * Method to construct instance of Log
		 *
		 * @param string $directory Directory to write logs
		 * @param bool $debug Flag to turn on debug logs
		 * @return void
		 */
		public function __construct(string $directory, string $dateFormat = 'Y-m-d H:i:s', string $extension = 'log', bool $debug = false)
		{
			$this->debug = $debug;
			$this->directory = $directory;
			$this->extension = $extension;
			$this->dateFormat = $dateFormat;
			$this->isWritable($directory);
		}

		/**
		 * Method to capture commands to print log
		 *
		 * @param string $method Method to execute
		 * @param array $args Args to method
		 * @return void
		 */
		public function __call($method, array $args = [])
		{
			$this->write($method, current($args));
		}

		/**
		 * Method to write log
		 *
		 * @param string $fileName File name to save log
		 * @param string $logText Text to log
		 * @return void
		 */
		private function write(string $fileName, string $logText) :void
		{
			if(!$this->debug && !in_array($fileName, $this->nonDebug)) {
				return true;
			}
			$file = $this->directory . $fileName . '.' . $this->extension;
			if(file_exists($file)) {
				$this->isWritable($file);
			}
			$fopen = fopen($file, 'a');
			fwrite($fopen, $this->getDatetime() . $logText . "\r\n");
		}

		/**
		 * Method return date to log
		 *
		 * @return string
		 */
		private function getDatetime() :string
		{
			return $this->dateFormat ? '[' . date($this->dateFormat) . '] ' : '';
		}

		/**
		 * Method to verify if directory is writable
		 *
		 * @param string $directory Directory to verity
		 * @throws FcPhp\Log\Exceptions\NotPermissionException
		 * @return void
		 */
		private function isWritable(string $directory) :void
		{
			if(!is_writable($directory)) {
				throw new NotPermissionToWriteException($directory);
			}
		}
	}
}