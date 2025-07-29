<?php

declare(strict_types=1);

namespace Syntatis\Version\CLI\Commands;

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

final class LessThanCommand extends Command
{
	/**
	 * Configure the command options and arguments.
	 */
	protected function configure(): void
	{
		$this->setName('lt');
		$this->setDescription('Compare if a version is less than another');
		$this->addArgument('version-a', InputArgument::REQUIRED, 'First version to compare');
		$this->addArgument('version-b', InputArgument::REQUIRED, 'Second version to compare against the first');
		$this->setHelp(<<<'HELP'
			This command compares two versions and checks if the first version is less than the second.

			Usage:
			<info>version lt 0.9.0 1.0.0</info>
			<info>version lt 2.1.0 2.1.0</info>
			HELP);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$style = new SymfonyStyle($input, $output);
		$versionA = $input->getArgument('version-a');
		$versionB = $input->getArgument('version-b');

		try {
			if (! is_string($versionA) || ! is_string($versionB)) {
				throw new InvalidArgumentType($versionA, $versionB);
			}

			/** @var Version $a */
			$a = Version::fromString($versionA);

			/** @var Version $b */
			$b = Version::fromString($versionB);

			if ($a->isLessThan($b)) {
				$style->success(sprintf("Version '%s' is less than '%s'.", $a, $b));

				return Command::SUCCESS;
			}

			$style->error(sprintf("Version '%s' is not less than '%s'.", $a, $b));

			return Command::FAILURE;
		} catch (Throwable $th) {
			$style->error($th->getMessage());

			return Command::FAILURE;
		}
	}
}
