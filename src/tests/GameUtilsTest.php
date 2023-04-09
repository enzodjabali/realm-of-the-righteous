<?php
declare(strict_types = 1);

namespace App\tests;

use App\classes\GameDifficulties;
use App\classes\GameUtils;
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
}