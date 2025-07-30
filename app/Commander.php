<?php

declare(strict_types=1);

namespace Syntatis\Version\CLI;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Syntatis\Version\CLI\Commands\EqualCommand;
use Syntatis\Version\CLI\Commands\GreaterThanCommand;
use Syntatis\Version\CLI\Commands\IncrementCommand;
use Syntatis\Version\CLI\Commands\LessThanCommand;
use Syntatis\Version\CLI\Commands\ValidateCommand;

final class Commander extends Application
{
	public const VERSION = '0.0.0';

	public function __construct()
	{
		parent::__construct('Version', self::VERSION);

		$this->addCommands($this->getCommands());
	}

	/**
	 * @return array<Command>
	 * @phpstan-return list<Command>
	 */
	private function getCommands(): array
	{
		return [
			new EqualCommand(),
			new GreaterThanCommand(),
			new IncrementCommand(),
			new LessThanCommand(),
			new ValidateCommand(),
		];
	}
}
