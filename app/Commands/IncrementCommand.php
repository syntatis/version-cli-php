<?php

declare(strict_types=1);

namespace Syntatis\Version\CLI\Commands;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Syntatis\Version\CLI\Exceptions\InvalidArgumentType;
use Throwable;
use Version\Version;

use function is_string;
use function sprintf;

final class IncrementCommand extends Command
{
	/**
	 * Configure the command options and arguments.
	 */
	protected function configure(): void
	{
		$this->setName('increment');
		$this->setDescription('Increment a version');
		$this->setAliases(['incr']);
		$this->addArgument('version', InputArgument::REQUIRED, 'Version to increment');
		$this->addOption('part', 'p', InputArgument::OPTIONAL, 'Part to increment (major, minor, patch)', 'patch');
		$this->addOption('build', 'b', InputArgument::OPTIONAL, 'Build metadata to append to the version');
		$this->addOption('pre', null, InputArgument::OPTIONAL, 'Pre-release identifier to append to the version');
		$this->setHelp(<<<'HELP'
			This command increments the provided version by the specified part (major, minor, patch).
			You can also append build metadata or a pre-release identifier to the version.

			Usage:
			<info>version increment 1.0.0</info>
			<info>version increment 1.0.0 --part=minor</info>
			<info>version increment 1.0.0 --build=123</info>
			<info>version increment 1.0.0 --pre=beta</info>
			HELP,);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$style = new SymfonyStyle($input, $output);
		$part = $input->getOption('part');
		$version = $input->getArgument('version');
		$build = $input->getOption('build');
		$pre = $input->getOption('pre');

		try {
			if (! is_string($part)) {
				throw new InvalidArgumentType($part);
			}
		} catch (Throwable $th) {
			$style->error($th->getMessage());

			return Command::FAILURE;
		}

		try {
			if (! is_string($version)) {
				throw new InvalidArgumentType($version);
			}

			/** @var Version $parsed */
			$parsed = Version::fromString($version);
			$style->writeln(
				(string) $this->increment(
					$parsed,
					$part,
					$pre,
					$build,
				),
			);
		} catch (Throwable $th) {
			$style->error($th->getMessage());

			return Command::FAILURE;
		}

		return Command::SUCCESS;
	}

	/**
	 * @param mixed $pre
	 * @param mixed $build
	 */
	private function increment(Version $version, string $part, $pre = null, $build = null): Version
	{
		switch ($part) {
			case 'major':
				$version = $version->incrementMajor();
				break;

			case 'minor':
				$version = $version->incrementMinor();
				break;

			case 'patch':
				$version = $version->incrementPatch();
				break;

			default:
				throw new InvalidArgumentException(sprintf("Invalid part '%s' provided. Expected 'major', 'minor', or 'patch'.", $part));
		}

		if (is_string($pre) && $pre !== '') {
			$version = $version->withPreRelease($pre);
		}

		if (is_string($build) && $build !== '') {
			$version = $version->withBuild($build);
		}

		return $version;
	}
}
