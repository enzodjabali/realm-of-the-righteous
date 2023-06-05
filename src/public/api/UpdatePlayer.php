<?php

declare(strict_types=1);

namespace App\public\api;

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
     * @param string $newUsername the new username of the player
     * @param string $newEmail the new email of the player
     * @return void
     * @throws Exception
     */
    public static function do(int $playerId, string $newUsername, string $newEmail): void
    {
        (new DotEnv('./.env'))->load();
        echo PlayerUtils::updatePlayer($playerId, $newUsername, $newEmail);
    }
}

try {
    UpdatePlayer::do(intval($playerId), htmlspecialchars($newUsername), htmlspecialchars($newEmail));
} catch (Exception $e) {
    echo $e;
}
