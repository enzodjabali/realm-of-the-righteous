<?php
declare(strict_types = 1);

namespace App\classes;

use PHPUnit\Logging\Exception;

class PlayerUtils
{
	/**
	 * This method inserts a new player into the database
	 * @param string $username The username of the player
	 * @param string $password The password of the player
	 * @param string $email The email of the player
	 * @param int $score The score of the player
	 * @param int $level The level of the player
	 * @param int $coins The coins of the player
	 * @return string|bool Returns true if the operation succeed, and returns a string containing an error message if it failed
	 * @throws \Exception
	 */
	public static function insertPlayer(string $username = "", string $password = "", string $email = "", int $score = 0, int $level = 0, int $coins = 25): string|bool {
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

		try {
			// Insert the new player into the database
			DbUtils::insert(DbTable::TABLE_PLAYER,
				["username", "password", "email", "score", "level", "coins"],
				[$username, $password, $email, $score, $level, $coins]
			);
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
}