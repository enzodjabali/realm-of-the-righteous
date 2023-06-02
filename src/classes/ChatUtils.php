<?php
declare(strict_types = 1);

namespace App\classes;

use Exception;

class ChatUtils
{
    /**
     * This method inserts a new message
     * @param int $playerId the id of the player who inserted the message
     * @param string $message the message content
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     */
    public static function insertMessage(int $playerId, string $message): string|bool
    {
        // Checks if the message isn't empty
        try {
            if (empty($message)) {
                throw new Exception("Your message can't be empty");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Check if the message doesn't have too many characters
        try {
            if (strlen($message) > 100) {
                throw new Exception("Your message can't have more than 100 characters");
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

        $date = date("Y-m-d H:i:s");

        try {
            // Insert the new message into the database
            DbUtils::insert(DbTable::TABLE_CHAT,
                ["player_id", "message", "date"],
                [$playerId, $message, $date]
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * This method return the fetched messages of the chat
     * @return bool|string returns the json encoded data of the messages information
     * @throws Exception
     */
    public static function getAllMessages(): bool|string
    {
        $result = DbUtils::select(DbTable::TABLE_CHAT, ["player_id", "message"]);
        $result_array = [];

        while($row = $result->fetch()) {
            $result_array[] = $row;
        }

        header('Content-type: application/json');
        return json_encode($result_array);
    }
}
