<?php

namespace App\classes;

use Exception;

class Utils
{
	/**
	 * This method generates a random string
	 * @param int $length the length of the string
	 * @param string $allowedCharacters the characters allowed to be use by the method to generate the string
	 * @return string returns the random string
	 * @throws Exception
	 */
	function generateRandomString(int $length = 10, string $allowedCharacters = "0123456789abcdefghijklmnopqrstuvwxyz"): string
	{
		$charactersLength = strlen($allowedCharacters);
		$randomString = "";

		for ($i = 0; $i < $length; $i++) {
			$randomString .= $allowedCharacters[random_int(0, $charactersLength - 1)];
		}

		return $randomString;
	}

}