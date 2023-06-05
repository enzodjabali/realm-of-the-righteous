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

extract($_POST);

class UpdateGameModel
{
    /**
     * This method echos the result of the updateModel to the javascript
     * @param int $gameId the game ID
     * @param string $newModel the new model
     * @return void
     */
    public static function do(int $gameId, string $newModel): void
    {
        (new DotEnv('./.env'))->load();
        echo GameUtils::updateModel($gameId, $newModel);
    }
}

try {
    UpdateGameModel::do(intval($gameId), $newModel);
} catch (Exception $e) {
    echo $e;
}
