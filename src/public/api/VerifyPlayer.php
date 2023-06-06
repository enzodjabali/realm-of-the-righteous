<?php

declare(strict_types=1);

namespace App\public\api;

session_start();

if (file_exists('../../vendor/autoload.php')) {
    require_once('../../vendor/autoload.php');
}

use App\classes\PlayerUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../classes/DbUtils.php');
require_once('../../classes/DbTable.php');
require_once('../../classes/PlayerUtils.php');

class VerifyPlayer
{
    /**
     * This call verifies a player
     * @param string $link the verification link
     * @return void
     * @throws Exception
     */
    public static function do(string $link): void
    {
        (new DotEnv('./.env'))->load();
        echo PlayerUtils::verifyPlayer($link);
    }
}

try {
    VerifyPlayer::do(htmlspecialchars($_GET["link"]));
} catch (Exception $e) {
    echo $e;
}
