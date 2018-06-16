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

	public function testInstanceDebugFalse()
	{
		$instance = new Log(__DIR__ . '/../var/', 'Y-m-d H:i:s', 'log');
		$this->assertTrue($instance->someExample('Message warning'));
	}

	public function testMoreError()
	{
		$this->assertTrue($this->instance->error('Message error') == null);
	}

	/**
     * @expectedException FcPhp\Log\Exceptions\NotPermissionToWriteException
     */
	public function testNotPermissionDir()
	{
		$instance = new Log('/root', 'Y-m-d H:i:s', 'log');
	}

}