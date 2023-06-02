<?php

declare(strict_types = 1);

namespace App\public\api;

if (file_exists('../../vendor/autoload.php')) {
    require_once('../../vendor/autoload.php');
}

use App\classes\ChatUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../classes/DbUtils.php');
require_once('../../classes/DbTable.php');
require_once('../../classes/ChatUtils.php');

extract($_GET);

class GetChatMessages
{
    /**
     * This method echos the fetched chat messages information to the javascript
     * @return void
     * @throws Exception
     */
    public static function do(): void
    {
        (new DotEnv('./.env'))->load();
        echo(ChatUtils::getAllMessages());
    }
}

try {
    GetChatMessages::do();
} catch (Exception $e) {
    echo $e;
}
