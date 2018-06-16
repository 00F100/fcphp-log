<?php

use FcPhp\Log\Log;
use FcPhp\Log\Interfaces\ILog;
use PHPUnit\Framework\TestCase;

class LogTest extends TestCase
{
	private $instance;

	public function setUp()
	{
		$this->instance = new Log(__DIR__ . '/../var/', 'Y-m-d H:i:s', 'log', true);
	}

	public function testInstance()
	{
		$this->assertTrue($this->instance instanceof ILog);
	}

	public function testLogError()
	{
		$this->instance->error('Message error');
		$this->instance->warning('Message warning');
		$this->instance->someExample('Message warning');
		$this->assertTrue(true);
	}

	public function testGetInstance()
	{
		$this->assertTrue(Log::getInstance('tests') instanceof ILog);
	}

}