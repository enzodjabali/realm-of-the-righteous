<?php

declare(strict_types = 1);

namespace App\public\methods;

if (file_exists('../../vendor/autoload.php')) {
    require_once('../../vendor/autoload.php');
}

use App\classes\GameUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../classes/GameUtils.php');
require_once('../../classes/DbUtils.php');
require_once('../../classes/DbTable.php');

$playerId = $_GET["player_id"] ?? 0;
$gameId = $_GET["game_id"] ?? 0;

class DoesGameBelongToPlayerMethod
{
    /**
     * This method echos 1 if the game belongs to this player, 0 if it doesn't
     * @param int $gameId the game ID
     * @param int $playerId the player's ID
     * @return void
     */
    public static function do(int $gameId, int $playerId): void
    {
        (new DotEnv('./.env'))->load();
        echo GameUtils::doesGameBelongToPlayer($gameId, $playerId);
    }
}

if (intval($gameId) > 0 && intval($playerId) > 0) {
    try {
        DoesGameBelongToPlayerMethod::do(intval($gameId), intval($playerId));
    } catch (Exception $e) {
        echo $e;
    }
} else {
    echo 0;
}
