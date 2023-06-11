<?php
declare(strict_types = 1);

namespace App\tests;

use Exception;
use PHPUnit\Framework\TestCase;
use App\classes\DbUtils;
use App\classes\DbTable;

final class DbTest extends TestCase
{
	/**
	 * @throws Exception
	 */
	public function testCanBeInsertedIntoPlayerTable(): void
	{
		$isInserted = DbUtils::insert(
            DbTable::TABLE_PLAYER,
			["username", "password", "email"],
			["test player 3", "test123!", "test@test.dev"]
		);

		$this->assertTrue($isInserted);
	}

    /**
     * @throws Exception
     */
    public function testCanBeUpdatedFromPlayerTable(): void
    {
        $isUpdated = DbUtils::update(
            DbTable::TABLE_PLAYER,
            "username",
            "test player 3 updated",
            "WHERE username = 'test player 3'"
        );

        $this->assertTrue($isUpdated);
    }

    /**
     * @throws Exception
     */
    public function testCanBeDeletedFromPlayerTable(): void
    {
        $isDeleted = DbUtils::delete(
            DbTable::TABLE_PLAYER,
            "WHERE username = 'test player 3 updated'"
        );

        $this->assertTrue($isDeleted);
    }
}
