<?php
declare(strict_types = 1);

namespace App\tests;

use App\classes\GameUtils;
use App\classes\GameDifficulties;
use App\classes\GameMatrixes;
use Exception;
use PHPUnit\Framework\TestCase;

final class GameUtilsTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateNewGame(): void
    {
        $isUserInserted = GameUtils::createGame("a phpunit game", 1, 1, GameDifficulties::DIFFICULTY_HARD, GameMatrixes::MATRIX_EASY);
        $this->assertTrue($isUserInserted);
    }

    public function testDoesGameBelongToPlayer(): void
    {
        $doesGameBelongToPlayer = GameUtils::doesGameBelongToPlayer(2, 1);
        $this->assertTrue($doesGameBelongToPlayer);
    }

    public function testGetMatrix(): void
    {
        $doesMatrixExist = GameUtils::getMatrix(2);
        $this->assertIsString($doesMatrixExist);
    }

    public function testUpdateMatrix(): void
    {
        $isMatrixUpdated = GameUtils::updateMatrix(2, GameMatrixes::MATRIX_EASY->value);
        $this->assertTrue($isMatrixUpdated);
    }
}
