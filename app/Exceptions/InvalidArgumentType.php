<?php

declare(strict_types=1);

namespace Syntatis\Version\CLI\Exceptions;

use InvalidArgumentException;

use function gettype;
use function sprintf;

class InvalidArgumentType extends InvalidArgumentException
{
	/** @param mixed $value */
	public function __construct($value)
	{
		parent::__construct(sprintf("Invalid type of value. Expected '%s', '%s' given", 'string', gettype($value)));
	}
}
