<?php

declare(strict_types = 1);

namespace App\public\controller\api;

session_start();

if (file_exists('../../../vendor/autoload.php')) {
    require_once('../../../vendor/autoload.php');
}

use App\classes\GameDifficulties;
use App\classes\GameUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../../classes/DbUtils.php');
require_once('../../../classes/DbTable.php');
require_once('../../../classes/GameUtils.php');
require_once('../../../classes/GameDifficulties.php');

header("Content-Type:application/json");

(new DotEnv('../.env'))->load();

class GameController {
    public function __construct(protected string $route)
    {
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
            intval($_SESSION["playerId"])
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
            intval($_SESSION["playerId"]),
            1,
            match (intval($difficulty)) {
                2 => GameDifficulties::DIFFICULTY_NORMAL,
                3 => GameDifficulties::DIFFICULTY_HARD,
                default => GameDifficulties::DIFFICULTY_EASY,
            }
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
            intval($gameId),
            intval($_SESSION["playerId"])
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
        $gameId = $_GET["gameId"] ?? 0;
        $playerId = $_GET["playerId"] ?? 0;

        $response["response"] = GameUtils::doesGameBelongToPlayer(
            intval($gameId),
            intval($playerId)
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
        $gameId = $_GET["gameId"] ?? 0;

        $getModel = GameUtils::getModel(
            intval($gameId),
            intval($_SESSION["playerId"])
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
            intval($gameId),
            $newModel
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
        $gameId = $_GET["gameId"] ?? 0;

        $getLogs = GameUtils::findAllLogs(
            intval($gameId),
            intval($_SESSION["playerId"])
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
            intval($gameId),
            intval($_SESSION["playerId"]),
            htmlspecialchars($content),
            intval($type)
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
