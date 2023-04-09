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
        // Checks if the game name isn't empty
        if (empty($name)) {
            return "The name of the game can't be empty";
        }

        // Check if the game name has enough characters
        if (strlen($name) < 3) {
            return "The game name can't have less than 3 characters";
        }

        // Check if the game name doesn't have too many characters
        if (strlen($name) > 25) {
            return "The game name can't have more than 25 characters";
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

    /**
     * This method return the fetched information of the games
     * @param int $playerId the player's ID
     * @return bool|string returns the json encoded data of the games information
     * @throws Exception
     */
    public static function getGameInformation(int $playerId): bool|string
    {
        $result = DbUtils::select(DbTable::TABLE_GAME, ["id", "name"], "WHERE player_id = '$playerId'");
        $result_array = [];

        while($row = $result->fetch()) {
            $result_array[] = $row;
        }

        header('Content-type: application/json');
        return json_encode($result_array);
    }
}