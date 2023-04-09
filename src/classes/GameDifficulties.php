<?php
declare(strict_types = 1);

namespace App\classes;

/**
 * Enumeration of the game difficulties
 */
enum GameDifficulties: int
{
    case DIFFICULTY_EASY = 1;
    case DIFFICULTY_NORMAL = 2;
    case DIFFICULTY_HARD = 3;
}
