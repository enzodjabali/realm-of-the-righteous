<?php

declare(strict_types=1);

namespace App\public\api;

session_start();

if (file_exists('../../vendor/autoload.php')) {
    require_once('../../vendor/autoload.php');
}

use App\classes\GameUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../classes/DbUtils.php');
require_once('../../classes/DbTable.php');
require_once('../../classes/GameUtils.php');

extract($_POST);

class DeleteGame
{
    /**
     * This method echos the result of the deleteGame method to the javascript
     * @param int $gameId the game ID
     * @param int $playerId the player's ID
     * @return void
     * @throws Exception
     */
    public static function do(int $gameId, int $playerId): void
    {
        (new DotEnv('./.env'))->load();
        echo GameUtils::deleteGame($gameId, $playerId);
    }
}

try {
    DeleteGame::do(intval($gameId), intval($_SESSION["player_id"]));
} catch (Exception $e) {
    echo $e;
}
