# FcPhp Log

Package to manipulate logs of application FcPhp

[![Build Status](https://travis-ci.org/00F100/fcphp-log.svg?branch=master)](https://travis-ci.org/00F100/fcphp-log) [![codecov](https://codecov.io/gh/00F100/fcphp-log/branch/master/graph/badge.svg)](https://codecov.io/gh/00F100/fcphp-log)

## How to install

Composer:
```sh
$ composer require 00f100/fcphp-log
```

or add in composer.json
```json
{
	"require": {
		"00f100/fcphp-log": "*"
	}
}
```

## How to use

Create logs easy! If `$debug = false` in constructor, just `$log->error()` and `$log->warning()` works...

```php
<?php

use \FcPhp\Log\Log;

/*

	Method to return instance of Log
	
	@param string $directoryOutput Directory to write logs
	@param string|bool $dateFormat Format of date to print log. If `false` not print date
	@param string $extension Extension of file log
	@param bool $debug Enable debug mode
	@return FcPhp\Log\Interfaces\ILog

	Log::getInstance(string $directoryOutput, $dateFormat = 'Y-m-d H:i:s', string $extension = 'log', bool $debug = false) :ILog

*/

$log = Log::getInstance('var/log', 'Y-m-d H:i:s', 'log', true);

// To error logs
$log->error('message of error');
// Print log: var/log/error.log
// [2018-06-16 04:06:25] message of error

// To warning logs
$log->warning('message of warning');
// Print log: var/log/warning.log
// [2018-06-16 04:06:25] message of warning

// To debug
$log->debug('message debug');
// Print log: var/log/debug.log
// [2018-06-16 04:06:25] message debug

// To many types
$log->fooBar('message foo bar');
// Print log: var/log/fooBar.log
// [2018-06-16 04:06:25] message foo bar

```