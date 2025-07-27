<?php

declare(strict_types=1);

namespace Syntatis\Tests\Commands;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Syntatis\Version\CLI\Commander;

use function sprintf;

class ValidateCommandTest extends TestCase
{
	/** @dataProvider dataInvalidVersionArgument */
	public function testInvalidVersionArgument(string $version): void
	{
		$command = new Commander();
		$tester = new CommandTester($command->get('validate'));
		$tester->execute(['version' => $version]);

		$this->assertStringContainsString(
			sprintf("[ERROR] Version string '%s' is not valid and cannot be parsed", $version),
			$tester->getDisplay(),
		);
	}

	/** @dataProvider dataValidVersionArgument */
	public function testValidVersionArgument(string $version): void
	{
		$command = new Commander();
		$tester = new CommandTester($command->get('validate'));
		$tester->execute(['version' => $version]);

		$this->assertStringContainsString(
			sprintf("[OK] Version string '%s' is valid and can be parsed", $version),
			$tester->getDisplay(),
		);
	}

	public static function dataInvalidVersionArgument(): iterable
	{
		yield ['v'];
		yield ['v0'];
		yield ['v0.0'];
	}

	public static function dataValidVersionArgument(): iterable
	{
		yield ['1.0.0'];
		yield ['2.1.7-alpha'];
		yield ['1.0.0-beta.1'];
		yield ['3.4.5+build.78'];
		yield ['0.9.1-alpha.1+exp.sha.5114f85'];
	}
}
