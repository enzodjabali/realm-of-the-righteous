<?php
declare(strict_types = 1);

namespace App\classes;

use Exception;

class GameUtils
{
    /**
     * This method returns the fetched information of the games
     * @param int $playerId the player's ID
     * @return bool|string returns the json encoded data of the games information
     * @throws Exception
     */
    public static function findAllGames(int $playerId): bool|array
    {
        $result_array = [];

        if ($playerId > 0) {
            $result = DbUtils::select(DbTable::TABLE_GAME, ["id", "name", "difficulty", "date"], "WHERE player_id = '$playerId' ORDER BY id DESC");

            while ($row = $result->fetch()) {
                $result_array[] = $row;
            }
        }

        return $result_array;
    }

    /**
     * This method creates a new game
     * @param string $name the name of the game
     * @param int $playerId the ID of the player who created the game
     * @param int $mapId the ID of the map
     * @param GameDifficulties $difficulty the level of difficulty of the game
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     */
    public static function createGame(string $name, int $playerId, int $mapId = 1, GameDifficulties $difficulty = GameDifficulties::DIFFICULTY_EASY): string|bool
    {
        // Checks if the player's ID is valid
        try {
            if (!$playerId > 0) {
                throw new Exception("You've been disconnected, please try to log back in");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
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
     * @param int $playerId the player's ID
     * @return string returns a string containing the model if it exists, returns an empty string if it doesn't
     */
    public static function getModel(int $gameId, int $playerId): string
    {
        if (GameUtils::doesGameBelongToPlayer($gameId, $playerId)) {
            try {
                return DbUtils::select(DbTable::TABLE_GAME, ["model"], "WHERE id = '$gameId'")->fetch()["model"] ?? "";
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        return "";
    }

    /**
     * This method updates the model of a given game ID
     * @param int $gameId the game ID
     * @param int $playerId the player's ID owner of the game
     * @return bool returns true is the operation succeed, false if it failed
     */
    public static function updateModel(int $gameId, int $playerId, string $newModel): bool
    {
        if (GameUtils::doesGameBelongToPlayer($gameId, $playerId)) {
            try {
                return DbUtils::update(DbTable::TABLE_GAME, "model", $newModel, "WHERE id = '$gameId'");
            } catch (Exception $e) {
                echo $e->getMessage();

            }
        }

        return false;
    }

    /**
     * This method deletes a game from the database
     * @param int $gameId the ID of the game
     * @param int $playerId the ID of the player owner of the game
     * @return bool returns true if the operation succeed, false if it failed
     * @throws Exception
     */
    public static function deleteGame(int $gameId, int $playerId): bool
    {
        try {
            if (GameUtils::doesGameBelongToPlayer($gameId, $playerId)) {
                DbUtils::delete(DbTable::TABLE_GAME, "WHERE id = $gameId");
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * This method returns the fetched logs of a game
     * @param int $gameId the game ID
     * @param int $playerId the player's ID owner of the game
     * @return bool|string returns the json encoded data of the game logs
     * @throws Exception
     */
    public static function findAllLogs(int $gameId, int $playerId): bool|array
    {
        $result_array = [];

        if (GameUtils::doesGameBelongToPlayer($gameId, $playerId)) {
            $result = DbUtils::select(DbTable::TABLE_GAME_LOG, ["content", "type"], "WHERE game_id = '$gameId' ORDER BY id DESC");

            while($row = $result->fetch()) {
                $result_array[] = $row;
            }
        }

        return $result_array;
    }

    /**
     * This method inserts a new game log
     * @param int $gameId the ID of the game
     * @param int $playerId the ID of the player owner of the game
     * @param string $content the log content
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     */
    public static function insertLog(int $gameId, int $playerId, string $content = "", int $type = 1): string|bool
    {
        // Checks if the game belongs to player
        try {
            if (!GameUtils::doesGameBelongToPlayer($gameId, $playerId)) {
                throw new Exception("This game doesn't belong to you");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the content isn't empty
        try {
            if (empty($content)) {
                throw new Exception("The content can't be empty");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Check if the content doesn't have too many characters
        try {
            if (strlen($content) > 30) {
                throw new Exception("The content can't have more than 30 characters");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the type is valid
        try {
            if ($type != 1 && $type != 2 && $type != 3) {
                throw new Exception("The type isn't valid");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        try {
            // Insert the new log into the database
            DbUtils::insert(DbTable::TABLE_GAME_LOG,
                ["game_id", "content", "type"],
                [$gameId, $content, $type]
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
