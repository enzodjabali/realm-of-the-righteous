<?php
declare(strict_types = 1);

namespace App\classes;

use DateTimeImmutable;
use Exception;

class PlayerUtils
{
    /**
     * This method returns the fetched information of the players
     * @param int $playerId the player's ID
     * @return bool|string returns the json encoded data of the players' information
     * @throws Exception
     */
    public static function findAllPlayers(int $playerId): bool|array
    {
        if ($playerId > 0) {
            $result = DbUtils::select(DbTable::TABLE_PLAYER, ["id", "username", "xp", "last_activity"], "WHERE is_verified IS TRUE ORDER BY xp DESC");
            $result_array = [];

            while($row = $result->fetch()) {
                $result_array[] = $row;
            }

            return $result_array;
        } else {
            return [];
        }
    }

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
	public static function insertPlayer(
        string $username = "",
        string $password = "",
        string $retypedPassword = "",
        string $email = "",
        bool $terms = false
    ): string|bool
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

            PlayerUtils::generateVerificationLink($email);
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * This method logs a user in
	 * @param string $username the username of the player
	 * @param string $password the password of the player
	 * @return int|string returns the ID of the player if a matching account has been found, returns a string containing an error message if it has not
	 * @throws Exception
	 */
	public static function loginPlayer(string $username = "", string $password = ""): int|string
    {
        // Checks if a player with this username exists
        try {
            if (DbUtils::select(DbTable::TABLE_PLAYER, ["COUNT(username)"], "WHERE username = '$username'")->fetch()["COUNT(username)"] < 1) {
                throw new Exception("Wrong username or password, please try again.");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        // Checks if the username matches the password
		try {
            if ($query = DbUtils::select(DbTable::TABLE_PLAYER, ["id", "password"], "WHERE username = '$username'")->fetch()) {
                if (password_verify($password, $query["password"]) ? intval($query["id"]) : 0) {
                    $playerId = intval($query["id"]);
                } else {
                    throw new Exception("Wrong username or password, please try again.");
                }
            }
		} catch (Exception $e) {
			return $e->getMessage();
		}

        // Checks if the player is verified
        try {
            if (!DbUtils::select(DbTable::TABLE_PLAYER, ["is_verified"], "WHERE username = '$username'")->fetch()["is_verified"]) {
                throw new Exception("This account hasn't been verified yet.");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $playerId ?? "Wrong username or password, please try again.";
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
	 * @param int $playerId the id of the player
	 * @return bool returns true if the operation succeed, false if it failed
	 * @throws Exception
	 */
	public static function deletePlayer(int $playerId): bool
	{
		try {
			DbUtils::delete(DbTable::TABLE_PLAYER, "WHERE id = $playerId");
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}

    /**
     * This method updates a player from the database
     * @param int $playerId the id of the player
     * @param string $currentUsername the current username of the player
     * @param string $currentEmail the current email of the player
     * @param string $newUsername the new username of the player
     * @param string $newEmail the new email of the player
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     * @throws Exception
     */
    public static function updatePlayer(
        int $playerId,
        string $currentUsername = "",
        string $currentEmail = "",
        string $newUsername = "",
        string $newEmail = ""
    ): string|bool
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
            if ($newUsername !== $currentUsername && !DbUtils::doesThisValueExist(DbTable::TABLE_PLAYER, "username", $newUsername)) {
                throw new Exception("This username is already used");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the new email isn't already used by another user
        try {
            if ($newEmail !== $currentEmail && !DbUtils::doesThisValueExist(DbTable::TABLE_PLAYER, "email", $newEmail)) {
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
     * @param int $playerId the ID of the player
     * @param string $currentPassword the current password of the player
     * @param string $newPassword the new password of the player
     * @param string $retypedNewPassword the retyped new password of the player
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     * @throws Exception
     */
    public static function updatePassword(
        int $playerId,
        string $currentPassword = "",
        string $newPassword = "",
        string $retypedNewPassword = "",
        bool $bypassCurrentPassword = false
    ): string|bool
    {
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
        if (!$bypassCurrentPassword) {
            try {
                $currentFetchedPassword = DbUtils::select(DbTable::TABLE_PLAYER, ["password"], "WHERE id = '$playerId'")->fetch()["password"];
                if (!password_verify($currentPassword, $currentFetchedPassword)) {
                    throw new Exception("The current password is incorrect");
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        try {
            // Updates the password into the database
            DbUtils::update(DbTable::TABLE_PLAYER, "password", password_hash($newPassword, PASSWORD_BCRYPT), "WHERE id = $playerId");
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * This method generates a verification link that will get sent to the player
     * @param string $playerEmail the email of the player
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     */
    public static function generateVerificationLink(string $playerEmail = ""): string|bool
    {
        $link = md5((string)rand());
        $url = !empty($_ENV['DOMAIN_NAME']) ? $_ENV['DOMAIN_NAME'] : (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";

        try {
            DbUtils::insert(DbTable::TABLE_VERIFICATION_LINK,
                ["player_email", "link"],
                [$playerEmail, $link]
            );

            EmailSender::sendEmail($playerEmail, "Verify your account", "Link: $url/verify?link=$link");
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    /**
     * This method verifies a player in the database
     * @param string $link the verification link
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     * @throws Exception
     */
    public static function verifyPlayer(string $link = ""): string|bool
    {
        // Checks if the link exists in the database
        try {
            if (DbUtils::doesThisValueExist(DbTable::TABLE_VERIFICATION_LINK, "link", $link)) {
                throw new Exception("The link has expired.");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        try {
            $playerEmail = DbUtils::select(DbTable::TABLE_VERIFICATION_LINK, ["player_email"], "WHERE link = '$link'")->fetch()["player_email"];
            DbUtils::delete(DbTable::TABLE_VERIFICATION_LINK, "WHERE link = '$link'");
            DbUtils::update(DbTable::TABLE_PLAYER, "is_verified", true, "WHERE email = '$playerEmail'");
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * This method generates a reset password link that will get sent to the player
     * @param string $playerEmail the email of the player
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     */
    public static function generateResetPasswordLink(string $playerEmail = ""): string|bool
    {
        // Check if the email is a valid email
        try {
            if (!filter_var($playerEmail, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("The email isn't a valid email");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        // Checks if the email exists in the database
        try {
            if (DbUtils::doesThisValueExist(DbTable::TABLE_PLAYER, "email", $playerEmail)) {
                throw new Exception("This email is not related to an existing account");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $link = md5((string)rand());
        $url = !empty($_ENV['DOMAIN_NAME']) ? $_ENV['DOMAIN_NAME'] : (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";

        try {
            DbUtils::insert(DbTable::TABLE_RESET_PASSWORD_LINK,
                ["player_email", "link"],
                [$playerEmail, $link]
            );

            EmailSender::sendEmail($playerEmail, "Reset your password", "Link: $url/reset-password?link=$link");
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    /**
     * This method resets a player's password in the database
     * @param string $link the reset password link
     * @param string $newPassword the new password of the player
     * @param string $retypedNewPassword the retyped new password of the player
     * @return string|bool returns true if the operation succeed, and returns a string containing an error message if it failed
     * @throws Exception
     */
    public static function resetPassword(string $link = "", string $newPassword = "", string $retypedNewPassword = ""): string|bool
    {
        // Checks if the link exists in the database
        try {
            if (DbUtils::doesThisValueExist(DbTable::TABLE_RESET_PASSWORD_LINK, "link", $link)) {
                throw new Exception("The link has expired.");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        // Fetches the player's ID from his reset password link
        try {
            $playerId = DbUtils::select(
                DbTable::TABLE_RESET_PASSWORD_LINK,
                ["player.id as playerId"],
                "JOIN player ON reset_password_link.player_email = player.email WHERE reset_password_link.link = '$link'"
            )->fetch()["playerId"];
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $updatePassword = PlayerUtils::updatePassword(intval($playerId), "", $newPassword, $retypedNewPassword, true);
        if ($updatePassword === true) {
            DbUtils::delete(DbTable::TABLE_RESET_PASSWORD_LINK, "WHERE link = '$link'");
        }

        return $updatePassword;
    }

    /**
     * This method tells if a player is admin or not from his ID
     * @param int $playerId the player's ID
     * @return bool returns true if the player is admin, false if not
     * @throws Exception
     */
    public static function isPlayerAdmin(int $playerId): bool
    {
        return (bool)DbUtils::select(DbTable::TABLE_PLAYER, ["is_admin"], "WHERE id = '$playerId'")->fetch()["is_admin"];
    }

    /**
     * This method updates a player's last activity from the database
     * @param int $playerId the ID of the player
     * @return string|bool returns true if the operation succeed, false if it didn't
     * @throws Exception
     */
    public static function updateActivity(int $playerId): string|bool
    {
        $date = new DateTimeImmutable();

        if (DbUtils::update(DbTable::TABLE_PLAYER, "last_activity", $date->getTimestamp(), "WHERE id = $playerId")) {
            return true;
        } else {
            return false;
        }
    }
}
