<?php

declare(strict_types = 1);

namespace App\public\controller\api;

session_start();

if (file_exists('../../../vendor/autoload.php')) {
    require_once('../../../vendor/autoload.php');
}

use App\classes\ChatUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../../classes/DbUtils.php');
require_once('../../../classes/DbTable.php');
require_once('../../../classes/ChatUtils.php');

header("Content-Type:application/json");

(new DotEnv('../.env'))->load();

class ChatController {
    public function __construct(protected string $route)
    {
        $this->$route();
    }

    /**
     * @route('/chat/getAll')
     * @method('GET')
     * @return void
     * @throws Exception
     */
    protected function getAll(): void
    {
        $getAll = ChatUtils::findAllMessages();

        if (is_array($getAll)) {
            http_response_code(200);
            $response = $getAll;
        } else {
            http_response_code(400);
            $response["response"] = "An error has occurred.";
        }

        echo json_encode($response);
    }

    /**
     * @route('/chat/insert')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function insert(): void
    {
        extract($_POST);

        $insert = ChatUtils::insertMessage(
            intval($_SESSION["player_id"]),
            htmlspecialchars($message)
        );

        if ($insert == "1") {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $insert;

        echo json_encode($response);
    }

}

new ChatController($_GET["route"]);
