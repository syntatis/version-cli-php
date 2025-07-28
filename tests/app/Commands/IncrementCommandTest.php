<?php

declare(strict_types=1);

namespace Syntatis\Tests\Commands;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Syntatis\Version\CLI\Commander;

use function sprintf;

class IncrementCommandTest extends TestCase
{
	private Commander $commander;

	public function setUp(): void
	{
		parent::setUp();

		$this->commander = new Commander();
	}

	/** @dataProvider dataInvalidVersionArgument */
	public function testInvalidVersionArgument(string $version): void
	{
		$tester = new CommandTester($this->commander->get('increment'));
		$tester->execute(['version' => $version]);

		self::assertStringContainsString(
			sprintf("[ERROR] Version string '%s' is not valid and cannot be parsed", $version),
			$tester->getDisplay(),
		);
	}

	public function testIncrementPatch(): void
	{
		$tester = new CommandTester($this->commander->get('increment'));
		$tester->execute(['version' => '1.0.0']);

		self::assertStringContainsString('1.0.1', $tester->getDisplay());
	}

	public function testIncrementMinor(): void
	{
		$tester = new CommandTester($this->commander->get('increment'));
		$tester->execute(['version' => '1.0.0', '--part' => 'minor']);

		self::assertStringContainsString('1.1.0', $tester->getDisplay());
	}

	public function testIncrementMajor(): void
	{
		$tester = new CommandTester($this->commander->get('increment'));
		$tester->execute(['version' => '1.0.0', '--part' => 'major']);

		self::assertStringContainsString('2.0.0', $tester->getDisplay());
	}

	public function testIncrementWithBuildMetadata(): void
	{
		$tester = new CommandTester($this->commander->get('increment'));
		$tester->execute(['version' => '1.0.0', '--build' => '123']);

		self::assertStringContainsString('1.0.1+123', $tester->getDisplay());
	}

	public function testIncrementWithPreRelease(): void
	{
		$tester = new CommandTester($this->commander->get('increment'));
		$tester->execute(['version' => '1.0.0', '--pre' => 'beta']);

		self::assertStringContainsString('1.0.1-beta', $tester->getDisplay());
	}

	public static function dataInvalidVersionArgument(): iterable
	{
		yield ['v'];
		yield ['v0'];
		yield ['v0.0'];
	}
}
