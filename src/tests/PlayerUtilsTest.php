<?php
declare(strict_types = 1);

namespace App\tests;

use App\classes\DbTable;
use App\classes\DbUtils;
use App\classes\PlayerUtils;
use Exception;
use PHPUnit\Framework\TestCase;

final class PlayerUtilsTest extends TestCase
{
	/**
	 * @throws Exception
	 */
	public function testInsertPlayer(): void
	{
		$isPlayerInserted = PlayerUtils::insertPlayer("test83163", "1234", "1234", "test83163@test.dev", true);
		$this->assertTrue($isPlayerInserted);
	}

	/**
	 * @throws Exception
	 */
	public function testInsertPlayerFail(): void
	{
		$isPlayerInserted = PlayerUtils::insertPlayer("test_fail", "test_fail", "test_fail", "not_a_valid_email", true);
		$this->assertIsString($isPlayerInserted);
	}

	/**
	 * @throws Exception
	 */
	public function testLoginAndDeletePlayer(): void
	{
        $verifyPlayer = DbUtils::update(DbTable::TABLE_PLAYER, "is_verified", true, "WHERE username = 'test83163'");
        $this->assertTrue($verifyPlayer);

        $playerId = PlayerUtils::loginPlayer("test83163", "1234");
		$this->assertIsInt($playerId);

		$isPlayerDeleted = PlayerUtils::deletePlayer($playerId);
		$this->assertTrue($isPlayerDeleted);
	}

}