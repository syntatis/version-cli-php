<?php

declare(strict_types=1);

namespace Syntatis\Tests\Commands;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Syntatis\Version\CLI\Commander;

use function sprintf;

class GreaterThanCommandTest extends TestCase
{
	private Commander $commander;

	public function setUp(): void
	{
		parent::setUp();

		$this->commander = new Commander();
	}

	/** @dataProvider dataComparison */
	public function testComparison(string $versionA, string $versionB, string $expect): void
	{
		$tester = new CommandTester($this->commander->get('gt'));
		$tester->execute(['version-a' => $versionA, 'version-b' => $versionB]);

		self::assertStringContainsString(
			$expect,
			$tester->getDisplay(),
		);
	}

	public static function dataComparison(): iterable
	{
		yield ['1.0.0', '2.0.0', sprintf("[ERROR] Version '%s' is not greater than '%s'.", '1.0.0', '2.0.0')];
		yield ['2.0.0', '1.0.0', sprintf("[OK] Version '%s' is greater than '%s'.", '2.0.0', '1.0.0')];
		yield ['1.0.0', '1.0.0', sprintf("[ERROR] Version '%s' is not greater than '%s'.", '1.0.0', '1.0.0')];
		yield ['1.0.0-alpha.1', '1.0.0-alpha.2', sprintf("[ERROR] Version '%s' is not greater than '%s'.", '1.0.0-alpha.1', '1.0.0-alpha.2')];
		yield ['1.0.0-alpha.2', '1.0.0-alpha.1', sprintf("[OK] Version '%s' is greater than '%s'.", '1.0.0-alpha.2', '1.0.0-alpha.1')];
	}
}
