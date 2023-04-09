<?php

declare(strict_types = 1);

namespace App\public\methods;

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
     * @throws Exception
     */
    public static function do(int $playerId): void
    {
        (new DotEnv('./.env'))->load();
        echo(GameUtils::getGameInformation($playerId));



        //while($info = $test) {
        //    var_dump($info["name"]);
        //}

    }
}

try {
    GetGameInformation::do(intval($playerId));
} catch (Exception $e) {
    echo $e;
}
