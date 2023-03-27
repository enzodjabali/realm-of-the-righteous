<?php
declare(strict_types = 1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\classes\DbUtils;
use App\classes\DbTable;

final class DbTest extends TestCase
{
	/**
	 * @throws \Exception
	 */
	public function testCanBeInsertedIntoPlayerTable(): void
	{
		$isInserted = DbUtils::insert(DbTable::TABLE_PLAYER,
			["username", "password", "email", "score", "level", "coins"],
			["test player 3", "test123!", "test@test.dev", 2300, 2, 50]
		);

		$this->assertTrue($isInserted);
	}
}