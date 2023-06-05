<?php

declare(strict_types=1);

namespace App\public\api;

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

class UpdatePassword
{
    /**
     * This call updates a player's username and email
     * @param int $playerId the player's ID that will get updated
     * @param string $currentPassword the current password of the player
     * @param string $newPassword the new password of the player
     * @param string $retypedNewPassword the retyped new password of the player
     * @return void
     * @throws Exception
     */
    public static function do(int $playerId, string $currentPassword, string $newPassword, string $retypedNewPassword): void
    {
        (new DotEnv('./.env'))->load();
        echo PlayerUtils::updatePassword($playerId, $currentPassword, $newPassword, $retypedNewPassword);
    }
}

try {
    UpdatePassword::do(intval($playerId), $currentPassword, $newPassword, $retypedNewPassword);
} catch (Exception $e) {
    echo $e;
}
