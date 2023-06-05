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

class DeletePlayer
{
    /**
     * This call updates a player's username and email
     * @param int $playerId the ID of the player that will get deleted
     * @return void
     * @throws Exception
     */
    public static function do(int $playerId): void
    {
        (new DotEnv('./.env'))->load();
        echo PlayerUtils::deletePlayer($playerId);
    }
}

try {
    DeletePlayer::do(intval($playerId));
} catch (Exception $e) {
    echo $e;
}
