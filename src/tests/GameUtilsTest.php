<?php
declare(strict_types = 1);

namespace App\tests;

use App\classes\GameUtils;
use App\classes\GameModels;
use Exception;
use PHPUnit\Framework\TestCase;

final class GameUtilsTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCanNewGameBeCreated(): void
    {
        $isGameCreated = GameUtils::createGame("a phpunit game", 1, 1, 1);
        $this->assertTrue($isGameCreated);
    }

    public function testDoesGameBelongToPlayer(): void
    {
        $doesGameBelongToPlayer = GameUtils::doesGameBelongToPlayer(1, 1);
        $this->assertTrue($doesGameBelongToPlayer);
    }

    public function testCanGetModel(): void
    {
        $doesModelExist = GameUtils::getModel(1, 1);
        $this->assertIsString($doesModelExist);
    }

    public function testCanUpdateModel(): void
    {
        $isModelUpdated = GameUtils::updateModel(1, 1, GameModels::MODEL_CONTEBURGH->value);
        $this->assertTrue($isModelUpdated);
    }

    /**
     * @throws Exception
     */
    public function testDeleteGameHasFailed(): void
    {
        $hasGameDeleteFailed = GameUtils::deleteGame(12345, 1);
        $this->assertFalse($hasGameDeleteFailed);
    }

    public function testCanLogBeInserted(): void
    {
        $isLogInserted = GameUtils::insertLog(1, 1, "test phpunit log", 1);
        $this->assertTrue($isLogInserted);
    }

    /**
     * @throws Exception
     */
    public function testCanLogsBeFetched(): void
    {
        $getLogs = GameUtils::findAllLogs(1, 1);
        $this->assertIsArray($getLogs);
    }
}
