<?php

declare(strict_types=1);

namespace Syntatis\Version\CLI\Commands;

use Assert\Assertion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;
use Version\Version;

use function sprintf;

final class ValidateCommand extends Command
{
	/**
	 * Configure the command options and arguments.
	 */
	protected function configure(): void
	{
		$this->setName('validate');
		$this->setDescription('Validate a version');
		$this->setHelp('This command checks if the provided value is a valid Semantic Version (SemVer) version format.');
		$this->setAliases(['val']);
		$this->addArgument('version', InputArgument::REQUIRED, 'Version to validate');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$style = new SymfonyStyle($input, $output);
		$version = $input->getArgument('version');

		try {
			Assertion::string($version);
			Version::fromString($version);

			$style->success(sprintf("Version string '%s' is valid and can be parsed", $version));

			return Command::SUCCESS;
		} catch (Throwable $th) {
			$style->error($th->getMessage());

			return Command::FAILURE;
		}
	}
}
