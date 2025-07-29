<?php

declare(strict_types=1);

namespace Syntatis\Tests\Commands;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Syntatis\Version\CLI\Commander;

use function sprintf;

class LessThanCommandTest extends TestCase
{
	private Commander $commander;
	private CommandTester $tester;

	public function setUp(): void
	{
		parent::setUp();

		$this->commander = new Commander();
		$this->tester = new CommandTester($this->commander->get('lt'));
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
		yield ['1.0.0', '2.0.0', sprintf("[OK] Version '%s' is less than '%s'.", '1.0.0', '2.0.0')];
		yield ['2.0.0', '1.0.0', sprintf("[ERROR] Version '%s' is not less than '%s'.", '2.0.0', '1.0.0')];
		yield ['1.0.0', '1.0.0', sprintf("[ERROR] Version '%s' is not less than '%s'.", '1.0.0', '1.0.0')];
		yield ['1.0.0-alpha.1', '1.0.0-alpha.2', sprintf("[OK] Version '%s' is less than '%s'.", '1.0.0-alpha.1', '1.0.0-alpha.2')];
		yield ['1.0.0-alpha.2', '1.0.0-alpha.1', sprintf("[ERROR] Version '%s' is not less than '%s'.", '1.0.0-alpha.2', '1.0.0-alpha.1')];
	}
}
