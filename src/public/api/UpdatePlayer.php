<?php

declare(strict_types=1);

namespace App\public\api;

session_start();

if (file_exists('../../vendor/autoload.php')) {
    require_once('../../vendor/autoload.php');
}

use App\classes\PlayerUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../classes/DbUtils.php');
require_once('../../classes/DbTable.php');
require_once('../../classes/PlayerUtils.php');

extract($_POST);

class UpdatePlayer
{
    /**
     * This call updates a player's username and email
     * @param int $playerId the player's ID that will get updated
     * @param string $currentUsername the player's current username
     * @param string $currentEmail the player's current email
     * @param string $newUsername the new username of the player
     * @param string $newEmail the new email of the player
     * @return void
     * @throws Exception
     */
    public static function do(int $playerId, string $currentUsername, string $currentEmail, string $newUsername, string $newEmail): void
    {
        (new DotEnv('./.env'))->load();
        $isPlayerUpdated = PlayerUtils::updatePlayer($playerId, $currentUsername, $currentEmail, $newUsername, $newEmail);

        if ($isPlayerUpdated == 1) {
            $_SESSION["player_username"] = $newUsername;
            $_SESSION["player_email"] = $newEmail;
        }

        echo $isPlayerUpdated;
    }
}

try {
    UpdatePlayer::do(intval($playerId), $currentUsername, $currentEmail, htmlspecialchars($newUsername), htmlspecialchars($newEmail));
} catch (Exception $e) {
    echo $e;
}
