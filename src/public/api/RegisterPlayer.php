<?php

declare(strict_types = 1);

namespace App\public\api;

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

class RegisterPlayer
{
    /**
     * This method echos the result of the RegisterPlayerMethod to the javascript
     * @param string $username the username to register with
     * @param string $password the password to register with
     * @param string $retypedPassword the retyped password to register with
     * @param string $email the email to register with
     * @param bool $terms the terms agreement status
     * @return void
     * @throws Exception
     */
    public static function do(string $username = "", string $password = "", string $retypedPassword = "", string $email = "", bool $terms = false): void
    {
        (new DotEnv('./.env'))->load();
        echo PlayerUtils::insertPlayer($username, $password, $retypedPassword, $email, $terms);
    }
}

try {
    RegisterPlayer::do(htmlspecialchars($username), $password, $retypedPassword, htmlspecialchars($email), $terms === 'true');
} catch (Exception $e) {
    echo $e;
}
