<?php

declare(strict_types = 1);

namespace App\public\api\controller;

session_start();

if (file_exists('../../../vendor/autoload.php')) {
    require_once('../../../vendor/autoload.php');
}

use App\classes\GameUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../../classes/DbUtils.php');
require_once('../../../classes/DbTable.php');
require_once('../../../classes/GameUtils.php');

header("Content-Type:application/json");

(new DotEnv('../.env'))->load();

class GameController {
    /**
     * @var int the connected player's session ID
     */
    private int $sessionId;

    public function __construct(protected string $route)
    {
        $this->sessionId = isset($_SESSION["playerId"]) ? (int)$_SESSION["playerId"] : 0;
        $this->$route();
    }

    /**
     * @route('/game/getAll')
     * @method('GET')
     * @return void
     * @throws Exception
     */
    protected function getAll(): void
    {
        $getAll = GameUtils::findAllGames(
            $this->sessionId
        );

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
     * @route('/game/create')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function create(): void
    {
        extract($_POST);

        $create = GameUtils::createGame(
            htmlspecialchars($name),
            $this->sessionId,
            (int)$map,
            (int)$difficulty
        );

        if ($create === true) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $create;

        echo json_encode($response);
    }

    /**
     * @route('/game/delete')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function delete(): void
    {
        extract($_POST);

        $delete = GameUtils::deleteGame(
            (int)$gameId,
            $this->sessionId
        );

        if ($delete === true) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $delete;

        echo json_encode($response);
    }

    /**
     * @route('/game/doesBelongToPlayer?gameId={id}&playerId={id}')
     * @method('GET')
     * @return void
     * @throws Exception
     */
    protected function doesBelongToPlayer(): void
    {
        $gameId = isset($_GET["gameId"]) ? (int)$_GET["gameId"] : 0;
        $playerId = isset($_GET["playerId"]) ? (int)$_GET["playerId"] : 0;

        $response["response"] = GameUtils::doesGameBelongToPlayer(
            $gameId,
            $playerId
        );

        http_response_code(200);

        echo json_encode($response);
    }

    /**
     * @route('/game/getModel?gameId={id}')
     * @method('GET')
     * @return void
     * @throws Exception
     */
    protected function getModel(): void
    {
        $gameId = isset($_GET["gameId"]) ? (int)$_GET["gameId"] : 0;

        $getModel = GameUtils::getModel(
            $gameId,
            $this->sessionId
        );

        if (!empty($getModel)) {
            http_response_code(200);
            echo $getModel;
        } else {
            http_response_code(400);
            echo '{"matrice": []}';
        }
    }

    /**
     * @route('/game/updateModel')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function updateModel(): void
    {
        extract($_POST);

        $response["response"] = GameUtils::updateModel(
            (int)$gameId,
            $this->sessionId,
            $newModel
        );

        http_response_code(200);

        echo json_encode($response);
    }

    /**
     * @route('/game/getDifficulty?gameId={id}')
     * @method('GET')
     * @return void
     * @throws Exception
     */
    protected function getDifficulty(): void
    {
        $gameId = isset($_GET["gameId"]) ? (int)$_GET["gameId"] : 0;

        $response["response"] = GameUtils::getDifficulty(
            $gameId,
            $this->sessionId
        );

        http_response_code(200);

        echo json_encode($response);
    }

    /**
     * @route('/game/getLogs?gameId={id}')
     * @method('GET')
     * @return void
     * @throws Exception
     */
    protected function getLogs(): void
    {
        $gameId = isset($_GET["gameId"]) ? (int)$_GET["gameId"] : 0;

        $getLogs = GameUtils::findAllLogs(
            $gameId,
            $this->sessionId
        );

        if (is_array($getLogs)) {
            http_response_code(200);
            $response = $getLogs;
        } else {
            http_response_code(400);
            $response["response"] = "An error has occurred.";
        }

        echo json_encode($response);
    }

    /**
     * @route('/game/insertLog')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function insertLog(): void
    {
        extract($_POST);

        $insertLog = GameUtils::insertLog(
            (int)$gameId,
            $this->sessionId,
            htmlspecialchars($content),
            (int)$type
        );

        if ($insertLog === true) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $insertLog;

        echo json_encode($response);
    }
}

new GameController($_GET["route"]);
