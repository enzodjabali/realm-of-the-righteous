<?php

declare(strict_types = 1);

namespace App\public\methods;

session_start();

if (file_exists('../../vendor/autoload.php')) {
    require_once('../../vendor/autoload.php');
}

use App\classes\PlayerUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../classes/PlayerUtils.php');
require_once('../../classes/DbUtils.php');
require_once('../../classes/DbTable.php');

extract($_POST);

class LoginPlayerMethod
{
    /**
     * This method echos the result of the LoginPlayerMethod to the javascript
     * @param string $username the username to log in with
     * @param string $password the password to log in with
     * @return void
     * @throws Exception
     */
    public static function do(string $username = "", string $password = ""): void
    {
        (new DotEnv('./.env'))->load();
        $playerId = PlayerUtils::loginPlayer($username, $password);
        $_SESSION["player_id"] = max($playerId, 0);

        if ($playerId > 0) {
            $playerInformation = PlayerUtils::getPlayerInformation($playerId);
            $_SESSION["player_username"] = $playerInformation["username"];
            $_SESSION["player_email"] = $playerInformation["email"];
        }

        echo $playerId;
    }
}

if (!empty($username) && !empty($password)) {
    try {
        LoginPlayerMethod::do(htmlspecialchars($username), $password);
    } catch (Exception $e) {
        echo $e;
    }
} else {
    echo 0;
}
