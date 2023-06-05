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
     * @param string $retypedPassword the retyped password of the player
     * @param string $email the email of the player
     * @param bool $terms the terms agreement status
	 * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
	 * @throws Exception
	 */
	public static function insertPlayer(string $username = "", string $password = "", string $retypedPassword = "", string $email = "", bool $terms = false): string|bool
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
            if (empty($password) || empty($retypedPassword)) {
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
        // Checks if the username doesn't have too many characters
        try {
            if (strlen($username) > 50) {
                throw new Exception("The username can't have more than 50 characters");
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
		// Checks if the password has enough characters
        try {
            if (strlen($password) < 4 || strlen($retypedPassword) < 4) {
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
        // Checks if the passwords are matching
        try {
            if ($password !== $retypedPassword) {
                throw new Exception("The passwords aren't matching");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the terms are agreed
        try {
            if (!$terms) {
                throw new Exception("The terms haven't been agreed");
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
	public static function loginPlayer(string $username = "", string $password = ""): int
	{
		try {
			if ($query = DbUtils::select(DbTable::TABLE_PLAYER, ["id", "password"], "WHERE username = '$username'")->fetch()) {
				return password_verify($password, $query["password"]) ? intval($query["id"]) : 0;
			} else {
				return 0;
			}
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

    /**
     * This method updates a player from the database
     * @param int $playerId the id of the player
     * @param string $newUsername the new username of the player
     * @param string $newEmail the new email of the player
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     * @throws Exception
     */
    public static function updatePlayer(int $playerId, string $newUsername = "", string $newEmail = ""): string|bool
    {
        // Checks if the new username isn't empty
        try {
            if (empty($newUsername)) {
                throw new Exception("The username can't be empty");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the new email isn't empty
        try {
            if (empty($newEmail)) {
                throw new Exception("The email can't be empty");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the new username has enough characters
        try {
            if (strlen($newUsername) < 3) {
                throw new Exception("The username can't have less than 3 characters");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the new username doesn't have too many characters
        try {
            if (strlen($newUsername) > 50) {
                throw new Exception("The username can't have more than 50 characters");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the new email is a valid email
        try {
            if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("The email isn't a valid email");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the new username isn't already used by another user
        try {
            if (!DbUtils::doesThisValueExist(DbTable::TABLE_PLAYER, "username", $newUsername)) {
                throw new Exception("This username is already used");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the new email isn't already used by another user
        try {
            if (!DbUtils::doesThisValueExist(DbTable::TABLE_PLAYER, "email", $newEmail)) {
                throw new Exception("This email is already used");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        try {
            // Updates the username into the database
            DbUtils::update(DbTable::TABLE_PLAYER, "username", $newUsername, "WHERE id = $playerId");
            // Updates the email into the database
            DbUtils::update(DbTable::TABLE_PLAYER, "email", $newEmail, "WHERE id = $playerId");
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * This method updates a player's password from the database
     * @param int $playerId the id of the player
     * @param string $currentPassword the current password of the player
     * @param string $newPassword the new password of the player
     * @param string $retypedNewPassword the retyped new password of the player
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     * @throws Exception
     */
    public static function updatePassword(int $playerId, string $currentPassword = "", string $newPassword = "", string $retypedNewPassword = ""): string|bool
    {
        // Checks if all the fields are filled
        try {
            if (empty($currentPassword) || empty($newPassword) || empty($retypedNewPassword)) {
                throw new Exception("Some fields are empty");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the new password has enough characters
        try {
            if (strlen($newPassword) < 4 || strlen($retypedNewPassword) < 4) {
                throw new Exception("The password can't have less than 4 characters");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the passwords are matching
        try {
            if ($newPassword !== $retypedNewPassword) {
                throw new Exception("The passwords aren't matching");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the current password is correct
        try {
            $currentFetchedPassword = DbUtils::select(DbTable::TABLE_PLAYER, ["password"], "WHERE id = '$playerId'")->fetch()["password"];
            if (!password_verify($currentPassword, $currentFetchedPassword)) {
                throw new Exception("The current password is incorrect");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        try {
            // Updates the password into the database
            DbUtils::update(DbTable::TABLE_PLAYER, "password", password_hash($newPassword, PASSWORD_BCRYPT), "WHERE id = $playerId");
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
