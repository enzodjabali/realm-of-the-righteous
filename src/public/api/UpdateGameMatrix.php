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

class UpdateGameMatrix
{
    /**
     * This method echos the result of the CreateGameMethod to the javascript
     * @param int $gameId the game ID
     * @param string $newMatrix the new matrix
     * @return void
     */
    public static function do(int $gameId, string $newMatrix): void
    {
        (new DotEnv('./.env'))->load();
        echo GameUtils::updateMatrix($gameId, $newMatrix);
    }
}

try {
    UpdateGameMatrix::do(intval($gameId), $newMatrix);
} catch (Exception $e) {
    echo $e;
}
