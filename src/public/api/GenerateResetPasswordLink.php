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

extract($_POST);

class GenerateResetPasswordLink
{
    /**
     * This call sends a reset password link to an email
     * @param string $playerEmail the email of the player
     * @return void
     */
    public static function do(string $playerEmail): void
    {
        (new DotEnv('./.env'))->load();
        echo PlayerUtils::generateResetPasswordLink($playerEmail);
    }
}

try {
    GenerateResetPasswordLink::do(htmlspecialchars($playerEmail));
} catch (Exception $e) {
    echo $e;
}
