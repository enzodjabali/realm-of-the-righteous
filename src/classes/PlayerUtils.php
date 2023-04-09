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
	 * @throws \Exception
	 */
	public static function insertPlayer(string $username = "", string $password = "", string $email = ""): string|bool
	{
		// Check if the username isn't empty
		if (empty($username)) {
			return "The username can't be empty";
		}
		// Check if the email isn't empty
		if (empty($email)) {
			return "The email can't be empty";
		}
		// Check if the password isn't empty
		if (empty($password)) {
			return "The password can't be empty";
		}
		// Check if the username has enough characters
		if (strlen($username) < 3) {
			return "The username can't have less than 3 characters";
		}
		// Check if the email is a valid email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return "The email isn't a valid email";
		}
		// Check if the username has enough characters
		if (strlen($password) < 4) {
			return "The password can't have less than 4 characters";
		}

        if (!DbUtils::doesThisValueExist(DbTable::TABLE_PLAYER, "username", $username)) {
            return "This username is already used";
        }

        if (!DbUtils::doesThisValueExist(DbTable::TABLE_PLAYER, "email", $email)) {
            return "This email is already used";
        }

		try {
			// Insert the new player into the database
			DbUtils::insert(DbTable::TABLE_PLAYER,
				["username", "password", "email"],
				[$username, sha1($password), $email]
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
	 * @return int returns the id of the player if it exists, returns 0 if it doesn't
	 * @throws \Exception
	 */
	public static function loginPlayer(string $username = "", string $password= ""): int
	{
		try {
			return intval(DbUtils::select(DbTable::TABLE_PLAYER, ["id"], "WHERE username = '$username' AND password = '" . sha1($password) . "'")->fetch()["id"]);
		} catch (Exception $e) {
			echo $e->getMessage();
			return 0;
		}
	}

	/**
	 * This method deletes a player from the database
	 * @param int $id the id of the player
	 * @return bool returns true if the operation succeed, false if it failed
	 * @throws \Exception
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