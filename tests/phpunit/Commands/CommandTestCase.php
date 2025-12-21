<?php

declare(strict_types=1);

namespace Syntatis\Tests\Commands;

use PHPUnit\Framework\TestCase;

use function preg_replace;
use function str_replace;
use function trim;

abstract class CommandTestCase extends TestCase
{
	protected static function normalizeOutput(string $value): string
	{
		$output = self::canonicalize($value);
		$output = str_replace("\n", ' ', $output);
		$output = preg_replace('/\s+/', ' ', $output);

		if ($output === null) {
			return $value;
		}

		return trim($output);
	}

	protected static function canonicalize(string $str): string
	{
		// normalize EOL style
		$str = str_replace("\r\n", "\n", $str);

		// trim newlines at end
		$str = rtrim($str, "\n");

		// remove trailing whitespace on all lines
		$lines = explode("\n", $str);
		$lines = array_map(static function ($line): string {
			return rtrim($line, " \t");
		}, $lines);

		return implode("\n", $lines);
	}
}
