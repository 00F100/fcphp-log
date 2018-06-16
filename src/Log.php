<?php

namespace FcPhp\Log
{
	use FcPhp\Log\Interfaces\ILog;
	use FcPhp\Log\Exceptions\NotPermissionToWriteException;

	class Log implements ILog
	{
		/**
		 * @var array
		 */
		private $nonDebug = ['error', 'warning', 'exception'];

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
		 * @var object
		 */
		private $customLog;

		/**
		 * Method to return instance of Log
		 *
		 * @param string $directoryOutput Directory to write logs
		 * @param string|bool $dateFormat Format of date to print log. If `false` not print date
		 * @param string $extension Extension of file log
		 * @param bool $debug Enable debug mode
		 * @return FcPhp\Log\Interfaces\ILog
		 */
		public static function getInstance(string $directoryOutput, $dateFormat = 'Y-m-d H:i:s', string $extension = 'log', bool $debug = false) :ILog
		{
			if(!self::$instance instanceof ILog) {
				self::$instance = new Log($directoryOutput, $dateFormat, $extension, $debug);
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
			return $this->write($method, current($args));
		}

		/**
		 * Method to write log
		 *
		 * @param string $fileName File name to save log
		 * @param string $logText Text to log
		 * @return void
		 */
		public function write(string $fileName, string $logText)
		{
			if(!$this->debug && !in_array($fileName, $this->nonDebug)) {
				return true;
			}
			$file = $this->directory . $fileName . '.' . $this->extension;
			if(file_exists($file)) {
				$this->isWritable($file);
			}
			$fopen = fopen($file, 'a');
			fwrite($fopen, $this->createLog($this->getDatetime(), $logText, "\r\n"));
			fclose($fopen);
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
		 * @throws FcPhp\Log\Exceptions\NotPermissionToWriteException
		 * @return void
		 */
		private function isWritable(string $directory) :void
		{
			if(!is_writable($directory)) {
				throw new NotPermissionToWriteException($directory);
			}
		}

		/**
		 * Method to configure custom log
		 *
		 * @param object $closure
		 * @return FcPhp\Log\Interfaces\ILog
		 */
		public function customLog($clousure) :ILog
		{
			$this->customLog = $clousure;
			return $this;
		}

		/**
		 * Method to create log
		 *
		 * @param string|null $dateTime Date time to log
		 * @param string $logText Text to put in file log
		 * @param string $breakLine The break of line
		 * @return string
		 */
		private function createLog(?string $dateTime, string $logText, string $breakLine) :string
		{
			if(gettype($this->customLog) == 'object') {
				$customLog = $this->customLog;
				return $customLog($dateTime, $logText, $breakLine);
			}
			$log = '';
			if(!empty($dateTime)) {
				$log = $dateTime;
			}
			$log .= $logText . $breakLine;
			return $log;
		}
	}
}