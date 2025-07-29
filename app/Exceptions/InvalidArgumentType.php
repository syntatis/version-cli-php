<?php

declare(strict_types=1);

namespace Syntatis\Version\CLI\Exceptions;

use InvalidArgumentException;

use function array_map;
use function implode;
use function sprintf;

class InvalidArgumentType extends InvalidArgumentException
{
	/** @param mixed $value */
	public function __construct(...$value)
	{
		$types = array_map('gettype', $value);

		parent::__construct(
			sprintf(
				"Invalid type of value. Expected '%s', '%s' given",
				'string',
				implode(', ', $types),
			),
		);
	}
}
