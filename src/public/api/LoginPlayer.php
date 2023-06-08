<?php

declare(strict_types = 1);

namespace App\public\api;

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

class LoginPlayer
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
        $response = PlayerUtils::loginPlayer($username, $password);


        if (is_numeric($response)) {
            $playerInformation = PlayerUtils::getPlayerInformation($response);
            if (is_array($playerInformation)) {
                $_SESSION["player_id"] = $response;
                $_SESSION["player_is_admin"] = PlayerUtils::isPlayerAdmin($response);
                $_SESSION["player_username"] = $playerInformation["username"];
                $_SESSION["player_email"] = $playerInformation["email"];
                echo '{"playerId":' . $response . '}';
            } else {
                echo '{"error":"An error has occurred."}';
            }
        } else {
            echo '{"error":"' . $response . '"}';
        }
    }
}

if (!empty($username) && !empty($password)) {
    try {
        LoginPlayer::do(htmlspecialchars($username), $password);
    } catch (Exception $e) {
        echo $e;
    }
} else {
    echo 0;
}
