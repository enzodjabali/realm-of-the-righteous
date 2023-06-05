<?php

declare(strict_types=1);

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

extract($_GET);

class GetGameModel
{
    /**
     * This method echos the fetched game model to the javascript
     * @param int $gameId the game ID
     * @return void
     * @throws Exception
     */
    public static function do(int $gameId): void
    {
        (new DotEnv('./.env'))->load();
        echo(GameUtils::getModel($gameId));
    }
}

try {
    GetGameModel::do(intval($gameId));
} catch (Exception $e) {
    echo $e;
}
