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
		$this->setDescription('Increment a version.');
		$this->setHelp('This command increments the provided version by the specified part (major, minor, patch).');
		$this->setAliases(['incr']);
		$this->addArgument('part', InputArgument::REQUIRED, 'Part to increment (major, minor, patch)');
		$this->addArgument('version', InputArgument::REQUIRED, 'Version to increment');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$style = new SymfonyStyle($input, $output);
		$part = $input->getArgument('part');
		$version = $input->getArgument('version');

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
				),
			);
		} catch (Throwable $th) {
			$style->error($th->getMessage());

			return Command::FAILURE;
		}

		return Command::SUCCESS;
	}

	private function increment(Version $version, string $part): Version
	{
		switch ($part) {
			case 'major':
				return $version->incrementMajor();

			case 'minor':
				return $version->incrementMinor();

			case 'patch':
				return $version->incrementPatch();

			default:
				throw new InvalidArgumentException(sprintf("Invalid part '%s' provided. Expected 'major', 'minor', or 'patch'.", $part));
		}
	}
}
