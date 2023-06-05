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
        try {
            if (empty($name)) {
                throw new Exception("The name of the game can't be empty");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Check if the game name has enough characters
        try {
            if (strlen($name) < 3) {
                throw new Exception("The game name can't have less than 3 characters");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Check if the game name doesn't have too many characters
        try {
            if (strlen($name) > 25) {
                throw new Exception("The game name can't have more than 25 characters");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the player's ID is valid
        try {
            if (!$playerId > 0) {
                throw new Exception("You've been disconnected, please try to log back in");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $model = match ($difficulty) {
            GameDifficulties::DIFFICULTY_NORMAL => GameModels::MODEL_NORMAL,
            GameDifficulties::DIFFICULTY_HARD => GameModels::MODEL_HARD,
            default => GameModels::MODEL_EASY,
        };

        try {
            // Insert the new game into the database
            DbUtils::insert(DbTable::TABLE_GAME,
                ["name", "player_id", "map_id", "difficulty", "model", "date"],
                [$name, $playerId, $mapId, $difficulty->value, $model->value, date("Y-m-d")]
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
        $result = DbUtils::select(DbTable::TABLE_GAME, ["id", "name", "date"], "WHERE player_id = '$playerId' ORDER BY id DESC");
        $result_array = [];

        while($row = $result->fetch()) {
            $result_array[] = $row;
        }

        header('Content-type: application/json');
        return json_encode($result_array);
    }

    /**
     * This method checks if a given game belongs to a given player
     * @param int $gameId the game ID
     * @param int $playerId the player's ID
     * @return bool returns true if the game doesn't belong to the player, false if it does
     */
    public static function doesGameBelongToPlayer(int $gameId, int $playerId): bool
    {
        try {
            $response = DbUtils::select(DbTable::TABLE_GAME, ["COUNT(player_id)"], "WHERE id = '$gameId' AND player_id = '$playerId'")->fetch()["COUNT(player_id)"];
            return $response > 0;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * This method gets the model of a given game ID
     * @param int $gameId the game ID
     * @return string returns a string containing the model if it exists, returns an empty string if it doesn't
     */
    public static function getModel(int $gameId): string
    {
        try {
            return DbUtils::select(DbTable::TABLE_GAME, ["model"], "WHERE id = '$gameId'")->fetch()["model"] ?? "";
        } catch (Exception $e) {
            echo $e->getMessage();
            return "";
        }
    }

    /**
     * This method updates the model of a given game ID
     * @param int $gameId the game ID
     * @return bool returns true is the operation succeed, false if it failed
     */
    public static function updateModel(int $gameId, string $newModel): bool
    {
        try {
            return DbUtils::update(DbTable::TABLE_GAME, "model", $newModel, "WHERE id = '$gameId'");
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * This method deletes a game from the database
     * @param int $gameId the id of the game
     * @param int $playerId the id of the player owner of the game
     * @return bool returns true if the operation succeed, false if it failed
     * @throws Exception
     */
    public static function deleteGame(int $gameId, int $playerId): bool
    {
        try {
            if (GameUtils::doesGameBelongToPlayer($gameId, $playerId)) {
                DbUtils::delete(DbTable::TABLE_GAME, $gameId);
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

}
