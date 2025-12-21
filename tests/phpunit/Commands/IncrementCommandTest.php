<?php

declare(strict_types=1);

namespace Syntatis\Tests\Commands;

use Syntatis\Tests\Commands\CommandTestCase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Syntatis\Version\CLI\Commander;

use function sprintf;

class IncrementCommandTest extends CommandTestCase
{
	private Commander $commander;
	private CommandTester $tester;

	public function setUp(): void
	{
		parent::setUp();

		$this->commander = new Commander();
		$this->tester = new CommandTester($this->commander->get('increment'));
	}

	/** @dataProvider dataInvalidVersionArgument */
	public function testInvalidVersionArgument(string $version): void
	{
		$this->tester->execute(['version' => $version]);

		self::assertStringContainsString(
			sprintf("[ERROR] Version string '%s' is not valid and cannot be parsed", $version),
			self::normalizeOutput($this->tester->getDisplay()),
		);
	}

	public function testIncrementPatch(): void
	{
		$this->tester->execute(['version' => '1.0.0']);

		self::assertStringContainsString(
			'1.0.1',
			self::normalizeOutput($this->tester->getDisplay()),
		);
	}

	public function testIncrementMinor(): void
	{
		$this->tester->execute(['version' => '1.0.0', '--part' => 'minor']);

		self::assertStringContainsString(
			'1.1.0',
			self::normalizeOutput($this->tester->getDisplay()),
		);
	}

	public function testIncrementMajor(): void
	{
		$this->tester->execute(['version' => '1.0.0', '--part' => 'major']);

		self::assertStringContainsString(
			'2.0.0',
			self::normalizeOutput($this->tester->getDisplay()),
		);
	}

	public function testIncrementWithBuildMetadata(): void
	{
		$this->tester->execute(['version' => '1.0.0', '--build' => '123']);

		self::assertStringContainsString(
			'1.0.1+123',
			self::normalizeOutput($this->tester->getDisplay()),
		);
	}

	public function testIncrementWithPreRelease(): void
	{
		$this->tester->execute(['version' => '1.0.0', '--pre' => 'beta']);

		self::assertStringContainsString(
			'1.0.1-beta',
			self::normalizeOutput($this->tester->getDisplay()),
		);
	}

	/**
	 * @dataProvider dataIncrementPrerelease
	 */
	public function testIncrementPrerelease(string $version, string $expect): void
	{
		$this->tester->execute(['version' => $version, '--part' => 'prerelease']);

		self::assertStringContainsString(
			$expect,
			self::normalizeOutput($this->tester->getDisplay()),
		);
	}

	public static function dataIncrementPrerelease(): iterable
	{
		yield ['1.0.0-beta', '1.0.0-beta.1'];
		yield ['1.0.0-alpha.1', '1.0.0-alpha.2'];
	}

	public function testIncrementPrereleaseWithPreTag(): void
	{
		$this->tester->execute(['version' => '1.0.0-beta', '--part' => 'prerelease', '--pre' => 'rc']);

		self::assertStringContainsString(
			"[ERROR] Specifying a prerelease tag when incrementing the prerelease part is not allowed.",
			self::normalizeOutput($this->tester->getDisplay()),
		);
	}

	public function testIncrementPrereleaseWithoutReleaseTag(): void
	{
		$this->tester->execute(['version' => '1.0.0', '--part' => 'prerelease']);

		self::assertStringContainsString(
			"[ERROR] Unable to increment prerelease on a version without a prerelease tag.",
			self::normalizeOutput($this->tester->getDisplay()),
		);
	}

	public static function dataInvalidVersionArgument(): iterable
	{
		yield ['v'];
		yield ['v0'];
		yield ['v0.0'];
	}
}
