<?php

declare(strict_types = 1);

namespace App\public\api;

if (file_exists('../../vendor/autoload.php')) {
    require_once('../../vendor/autoload.php');
}

use App\classes\GameDifficulties;
use App\classes\GameUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../classes/DbUtils.php');
require_once('../../classes/DbTable.php');
require_once('../../classes/GameDifficulties.php');
require_once('../../classes/GameUtils.php');

extract($_POST);

class CreateGame
{
    /**
     * This method echos the result of the CreateGameMethod to the javascript
     * @param string $name the name of the game to create
     * @param int $playerId the player's ID of the game owner
     * @param int $mapId the map's ID of the game
     * @param GameDifficulties $difficulty the difficulty of the game
     * @return void
     */
    public static function do(string $name, int $playerId, int $mapId, GameDifficulties $difficulty): void
    {
        (new DotEnv('./.env'))->load();
        echo GameUtils::createGame($name, $playerId, $mapId, $difficulty);
    }
}

try {
    $difficulty = match (intval($difficulty)) {
        2 => GameDifficulties::DIFFICULTY_NORMAL,
        3 => GameDifficulties::DIFFICULTY_HARD,
        default => GameDifficulties::DIFFICULTY_EASY,
    };

    CreateGame::do(htmlspecialchars($name), intval($playerId), 1, $difficulty);
} catch (Exception $e) {
    echo $e;
}
