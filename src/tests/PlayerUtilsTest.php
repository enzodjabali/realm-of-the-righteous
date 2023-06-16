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
	public function testCanPlayerBeInserted(): void
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

    public function testCanVerificationLinkBeGenerated(): void
    {
        $isVerificationLinkGenerated = PlayerUtils::generateVerificationLink("test83163@test.dev");
        $this->assertTrue($isVerificationLinkGenerated);
    }

    public function testCanResetPasswordLinkBeGenerated(): void
    {
        $isResetPasswordLinkGenerated = PlayerUtils::generateResetPasswordLink("test83163@test.dev");
        $this->assertTrue($isResetPasswordLinkGenerated);
    }

    /**
     * @throws Exception
     */
    public function testCanPlayerPasswordBeUpdated(): void
    {
        $getPlayerId = (int)DbUtils::select(DbTable::TABLE_PLAYER, ["id"], "WHERE username = 'test83163'")->fetch()["id"];

        $isPasswordUpdated = PlayerUtils::updatePassword($getPlayerId, "1234", "1234NewP4ssW0r8", "1234NewP4ssW0r8");
        $this->assertTrue($isPasswordUpdated);
    }

    /**
     * @throws Exception
     */
    public function testCanPlayerXPBeIncrementedAndDecremented(): void
    {
        $isPlayerXPIncremented = PlayerUtils::incrementXP(1, 100);
        $this->assertTrue($isPlayerXPIncremented);

        $isPlayerXPDecremented = PlayerUtils::decrementXP(1, 50);
        $this->assertTrue($isPlayerXPDecremented);
    }

	/**
	 * @throws Exception
	 */
	public function testCanPlayerLoginAndBeDeleted(): void
	{
        $verifyPlayer = DbUtils::update(DbTable::TABLE_PLAYER, "is_verified", true, "WHERE username = 'test83163'");
        $this->assertTrue($verifyPlayer);

        $playerId = PlayerUtils::loginPlayer("test83163", "1234NewP4ssW0r8");
		$this->assertIsInt($playerId);

		$isPlayerDeleted = PlayerUtils::deletePlayer($playerId);
		$this->assertTrue($isPlayerDeleted);
	}
}
