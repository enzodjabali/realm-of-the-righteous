<?php
declare(strict_types = 1);

namespace App\classes;

use Exception;

class PlayerUtils
{
	/**
	 * This method inserts a new player into the database
	 * @param string $username the username of the player
	 * @param string $password the password of the player
	 * @param string $email the email of the player
	 * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
	 * @throws Exception
	 */
	public static function insertPlayer(string $username = "", string $password = "", string $email = ""): string|bool
	{
		// Checks if the username isn't empty
        try {
            if (empty($username)) {
                throw new Exception("The username can't be empty");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
		// Checks if the email isn't empty
        try {
            if (empty($email)) {
                throw new Exception("The email can't be empty");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
		// Checks if the password isn't empty
        try {
            if (empty($password)) {
                throw new Exception("The password can't be empty");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
		// Checks if the username has enough characters
        try {
            if (strlen($username) < 3) {
                throw new Exception("The username can't have less than 3 characters");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
		// Checks if the email is a valid email
        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("The email isn't a valid email");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
		// Checks if the username has enough characters
        try {
            if (strlen($password) < 4) {
                throw new Exception("The password can't have less than 4 characters");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the username isn't already used by another user
        try {
            if (!DbUtils::doesThisValueExist(DbTable::TABLE_PLAYER, "username", $username)) {
                throw new Exception("This username is already used");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the email isn't already used by another user
        try {
            if (!DbUtils::doesThisValueExist(DbTable::TABLE_PLAYER, "email", $email)) {
                throw new Exception("This email is already used");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

		try {
			// Insert the new player into the database
			DbUtils::insert(DbTable::TABLE_PLAYER,
				["username", "password", "email"],
				[$username, password_hash($password, PASSWORD_BCRYPT), $email]
			);
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * This method logs a user in
	 * @param string $username the username of the player
	 * @param string $password the password of the player
	 * @return int returns the ID of the player if it exists, returns 0 if it doesn't
	 * @throws Exception
	 */
	public static function loginPlayer(string $username = "", string $password= ""): int
	{
		try {
			$query = DbUtils::select(DbTable::TABLE_PLAYER, ["id", "password"], "WHERE username = '$username'")->fetch();
            return password_verify($password, $query["password"]) ? intval($query["id"]) : 0;
		} catch (Exception $e) {
			echo $e->getMessage();
			return 0;
		}
	}

    /**
     * This method fetches the username and the email of a player's ID
     * @param int $playerId the player's ID
     * @return array|bool return the PDOStatement if the operation succeed, false if it failed
     */
    public static function getPlayerInformation(int $playerId): array|bool
    {
        try {
            return DbUtils::select(DbTable::TABLE_PLAYER, ["username, email"], "WHERE id = '$playerId'")->fetch();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

	/**
	 * This method deletes a player from the database
	 * @param int $id the id of the player
	 * @return bool returns true if the operation succeed, false if it failed
	 * @throws Exception
	 */
	public static function deleteUser(int $id): bool
	{
		try {
			DbUtils::delete(DbTable::TABLE_PLAYER, $id);
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}

}
