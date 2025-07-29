<?php

declare(strict_types=1);

namespace Syntatis\Tests\Commands;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Syntatis\Version\CLI\Commander;

use function sprintf;

class EqualCommandTest extends TestCase
{
	private Commander $commander;
	private CommandTester $tester;

	public function setUp(): void
	{
		parent::setUp();

		$this->commander = new Commander();
		$this->tester = new CommandTester($this->commander->get('eq'));
	}

	/** @dataProvider dataComparison */
	public function testComparison(string $versionA, string $versionB, string $expect): void
	{
		$this->tester->execute(['version-a' => $versionA, 'version-b' => $versionB]);

		self::assertStringContainsString(
			$expect,
			$this->tester->getDisplay(),
		);
	}

	public static function dataComparison(): iterable
	{
		yield ['1.0.0', '1.0.0', sprintf("[OK] Version '%s' is equal to '%s'.", '1.0.0', '1.0.0')];
		yield ['v1.0.0', 'v1.0.0', sprintf("[OK] Version '%s' is equal to '%s'.", 'v1.0.0', 'v1.0.0')];
		yield ['1.0.0', '2.0.0', sprintf("[ERROR] Version '%s' is not equal to '%s'.", '1.0.0', '2.0.0')];
		yield ['1.0.0-alpha.1', '1.0.0-alpha.1', sprintf("[OK] Version '%s' is equal to '%s'.", '1.0.0-alpha.1', '1.0.0-alpha.1')];
		yield ['v1.0.0-alpha.1', 'v1.0.0-alpha.1', sprintf("[OK] Version '%s' is equal to '%s'.", 'v1.0.0-alpha.1', 'v1.0.0-alpha.1')];
		yield ['1.0.0-alpha.1', '1.0.0-alpha.2', sprintf("[ERROR] Version '%s' is not equal to '%s'.", '1.0.0-alpha.1', '1.0.0-alpha.2')];
	}
}
