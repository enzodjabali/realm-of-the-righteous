<?php
declare(strict_types = 1);

namespace App\tests;

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
			["username", "password", "email"],
			["test player 3", "test123!", "test@test.dev"]
		);

		$this->assertTrue($isInserted);
	}
}