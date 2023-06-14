<?php
declare(strict_types = 1);

namespace App\classes;

use Exception;

class PrivateChatUtils
{
    /**
     * This method returns the fetched private messages of the chat
     * @param int $playerId the ID of the connected player
     * @param int $matePlayerId the ID of the chatting mate player
     * @return bool|array returns the json encoded data of the private messages information
     * @throws Exception
     */
    public static function findAllPrivateMessages(int $playerId, int $matePlayerId): bool|array
    {
        $result_array = [];

        if ($playerId > 0) {
            $result = DbUtils::select(
                DbTable::TABLE_PRIVATE_CHAT,
                ["private_chat.id as id", "private_chat.message as message", "s.username as sender", "r.username as receiver"],
                "JOIN player s ON private_chat.sender_player_id = s.id
                JOIN player r ON private_chat.receiver_player_id = r.id
                WHERE s.id = $playerId AND r.id = $matePlayerId OR s.id = $matePlayerId AND r.id = $playerId
                ORDER BY private_chat.id DESC"
            );

            while ($row = $result->fetch()) {
                $result_array[] = $row;
            }
        }

        return $result_array;
    }

    /**
     * This method inserts a new private message
     * @param int $playerId the ID of the player who inserts the message
     * @param int $matePlayerId the ID of the player who receives the message
     * @param string $message the message content
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     */
    public static function insertPrivateMessage(int $playerId, int $matePlayerId, string $message = ""): string|bool
    {
        // Checks if the player's ID is valid
        try {
            if (!$playerId > 0) {
                throw new Exception("You've been disconnected, please try to log back in");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
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
            if (strlen($message) > 50) {
                throw new Exception("Your message can't have more than 50 characters");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        try {
            // Insert the new message into the database
            DbUtils::insert(DbTable::TABLE_PRIVATE_CHAT,
                ["sender_player_id", "receiver_player_id", "message"],
                [$playerId, $matePlayerId, $message]
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
