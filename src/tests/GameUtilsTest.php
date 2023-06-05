<?php
declare(strict_types = 1);

namespace App\tests;

use App\classes\GameUtils;
use App\classes\GameDifficulties;
use App\classes\GameModels;
use Exception;
use PHPUnit\Framework\TestCase;

final class GameUtilsTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateNewGame(): void
    {
        $isUserInserted = GameUtils::createGame("a phpunit game", 1, 1, GameDifficulties::DIFFICULTY_HARD);
        $this->assertTrue($isUserInserted);
    }

    public function testDoesGameBelongToPlayer(): void
    {
        $doesGameBelongToPlayer = GameUtils::doesGameBelongToPlayer(1, 1);
        $this->assertTrue($doesGameBelongToPlayer);
    }

    public function testGetModel(): void
    {
        $doesModelExist = GameUtils::getModel(1);
        $this->assertIsString($doesModelExist);
    }

    public function testUpdateModel(): void
    {
        $isModelUpdated = GameUtils::updateModel(1, GameModels::MODEL_EASY->value);
        $this->assertTrue($isModelUpdated);
    }
}
