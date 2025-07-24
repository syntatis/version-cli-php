<?php

declare(strict_types=1);

namespace App\Tests;

use App\Main;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
	public function testTrue(): void
	{
		$this->assertEquals('Hello, World!', (string) (new Main()));
	}
}
