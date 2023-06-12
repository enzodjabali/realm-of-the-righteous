<?php

declare(strict_types = 1);

namespace App\public\api\controller;

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
    /**
     * @var int the connected user's session ID
     */
    private int $sessionId;

    public function __construct(protected string $route)
    {
        $this->sessionId = isset($_SESSION["playerId"]) ? (int)$_SESSION["playerId"] : 0;
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
            $this->sessionId,
            htmlspecialchars($message)
        );

        if ($insert === true) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $insert;

        echo json_encode($response);
    }
}

new ChatController($_GET["route"]);
