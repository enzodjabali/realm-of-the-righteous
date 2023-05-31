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
        // Checks if the message name isn't empty
        if (empty($message)) {
            return "Your message can't be empty";
        }

        // Check if the message doesn't have too many characters
        if (strlen($message) > 100) {
            return "Your message can't have more than 100 characters";
        }

        // Checks if the player's ID is valid
        if (!$playerId > 0) {
            return "You've been disconnected, please try to log back in";
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
     * @return bool|string returns the json encoded data of the games information
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
