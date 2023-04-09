<?php
declare(strict_types = 1);

namespace App\classes;

use Exception;

class GameUtils
{
    /**
     * This method creates a new game
     * @param string $name the name of the game
     * @param int $playerId the id of the player who created the game
     * @param int $mapId the id of the map
     * @param GameDifficulties $difficulty the level of difficulty of the game
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     */
    public static function createGame(string $name, int $playerId, int $mapId = 1, GameDifficulties $difficulty = GameDifficulties::DIFFICULTY_EASY): string|bool
    {
        // Checks if the username isn't empty
        if (empty($name)) {
            return "The name of the game can't be empty";
        }

        // Checks if the player's ID is valid
        if (!$playerId > 0) {
            return "You've been disconnected, please try to log back in";
        }

        try {
            // Insert the new game into the database
            DbUtils::insert(DbTable::TABLE_GAME,
                ["name", "player_id", "map_id", "difficulty"],
                [$name, $playerId, $mapId, $difficulty->value]
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}