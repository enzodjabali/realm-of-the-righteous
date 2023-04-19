<?php

declare(strict_types = 1);

namespace App\public\api;

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

class GetGameInformation
{
    /**
     * This method echos the fetched game information to the javascript
     * @param int $playerId the player's ID
     * @return void
     * @throws Exception
     */
    public static function do(int $playerId): void
    {
        (new DotEnv('./.env'))->load();
        echo(GameUtils::getGameInformation($playerId));
    }
}

try {
    GetGameInformation::do(intval($playerId));
} catch (Exception $e) {
    echo $e;
}
