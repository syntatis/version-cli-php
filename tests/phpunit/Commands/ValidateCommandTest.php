<?php

declare(strict_types=1);

namespace Syntatis\Tests\Commands;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Syntatis\Version\CLI\Commander;

use function sprintf;

class ValidateCommandTest extends TestCase
{
	private Commander $commander;
	private CommandTester $tester;

	public function setUp(): void
	{
		parent::setUp();

		$this->commander = new Commander();
		$this->tester = new CommandTester($this->commander->get('validate'));
	}

	/** @dataProvider dataInvalidVersionArgument */
	public function testInvalidVersionArgument(string $version): void
	{
		$this->tester->execute(['version' => $version]);

		self::assertStringContainsString(
			sprintf("[ERROR] Version string '%s' is not valid and cannot be parsed", $version),
			$this->tester->getDisplay(),
		);
	}

	/** @dataProvider dataValidVersionArgument */
	public function testValidVersionArgument(string $version): void
	{
		$this->tester->execute(['version' => $version]);

		self::assertStringContainsString(
			sprintf("[OK] Version string '%s' is valid and can be parsed", $version),
			$this->tester->getDisplay(),
		);
	}

	public static function dataInvalidVersionArgument(): iterable
	{
		yield ['0'];
		yield ['0.0'];
		yield ['v'];
		yield ['v0'];
		yield ['v0.0'];
	}

	public static function dataValidVersionArgument(): iterable
	{
		yield ['1.0.0'];
		yield ['v1.0.0'];
		yield ['2.1.7-alpha'];
		yield ['1.0.0-beta.1'];
		yield ['3.4.5+build.78'];
		yield ['0.9.1-alpha.1+exp.sha.5114f85'];
	}
}
