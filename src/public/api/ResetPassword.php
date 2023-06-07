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

class ResetPassword
{
    /**
     * This call resets a player's password
     * @param string $link the password reset link
     * @param string $newPassword the new password of the player
     * @param string $retypedNewPassword the retyped new password of the player
     * @return void
     * @throws Exception
     */
    public static function do(string $link, string $newPassword, string $retypedNewPassword): void
    {
        (new DotEnv('./.env'))->load();
        echo PlayerUtils::resetPassword($link, $newPassword, $retypedNewPassword);
    }
}

try {
    ResetPassword::do($link, $newPassword, $retypedNewPassword);
} catch (Exception $e) {
    echo $e;
}
