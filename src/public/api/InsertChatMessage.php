<?php

declare(strict_types = 1);

namespace App\public\api;

session_start();

if (file_exists('../../vendor/autoload.php')) {
    require_once('../../vendor/autoload.php');
}

use App\classes\ChatUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../classes/ChatUtils.php');
require_once('../../classes/DbUtils.php');
require_once('../../classes/DbTable.php');

extract($_POST);

class InsertChatMessage
{
    /**
     * This method echos the result of the insertMessage to the javascript
     * @param int $playerId the ID of the player who sends the message
     * @param string $message the message that is sent
     * @return void
     * @throws Exception
     */
    public static function do(int $playerId, string $message): void
    {
        (new DotEnv('./.env'))->load();
        echo ChatUtils::insertMessage($playerId, $message);
    }
}

try {
    InsertChatMessage::do(intval($_SESSION["player_id"]), htmlspecialchars($message));
} catch (Exception $e) {
    echo $e;
}
