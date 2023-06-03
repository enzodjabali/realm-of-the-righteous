<?php
declare(strict_types = 1);

namespace App\tests;

use App\classes\PlayerUtils;
use Exception;
use PHPUnit\Framework\TestCase;

final class PlayerUtilsTest extends TestCase
{
	/**
	 * @throws Exception
	 */
	public function testInsertUser(): void
	{
		$isUserInserted = PlayerUtils::insertPlayer("test83163", "1234", "1234", "test83163@test.dev", true);
		$this->assertTrue($isUserInserted);
	}

	/**
	 * @throws Exception
	 */
	public function testInsertUserFail(): void
	{
		$isUserInserted = PlayerUtils::insertPlayer("test_fail", "test_fail", "test_fail", "not_a_valid_email", true);
		$this->assertIsString($isUserInserted);
	}

	/**
	 * @throws Exception
	 */
	public function testLoginAndDeletePlayer(): void
	{
		$userId = PlayerUtils::loginPlayer("test83163", "1234");
		$this->assertIsInt($userId);

		$isUserDeleted = PlayerUtils::deleteUser($userId);
		$this->assertTrue($isUserDeleted);
	}

}