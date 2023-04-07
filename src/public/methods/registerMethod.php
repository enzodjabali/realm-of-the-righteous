<?php

declare(strict_types = 1);

namespace App\public\methods;

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

class registerMethod
{
    /**
     * This method echos the result of the registerMethod to the javascript
     * @param string $username the username to register with
     * @param string $password the password to register with
     * @param string $email the email to register with
     * @return void
     * @throws Exception
     */
    public static function register(string $username = "", string $password = "", string $email = ""): void
    {
        (new DotEnv('./.env'))->load();
        $result = PlayerUtils::insertPlayer($username, $password, $email);
        echo $result;
    }
}

try {
    registerMethod::register(htmlspecialchars($username), $password, htmlspecialchars($email));
} catch (Exception $e) {
    echo $e;
}