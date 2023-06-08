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
            intval($_SESSION["player_id"])
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
            intval($_SESSION["player_id"]),
            1,
            match (intval($difficulty)) {
                2 => GameDifficulties::DIFFICULTY_NORMAL,
                3 => GameDifficulties::DIFFICULTY_HARD,
                default => GameDifficulties::DIFFICULTY_EASY,
            }
        );

        if ($create == "1") {
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
            intval($_SESSION["player_id"])
        );

        if ($delete == "1") {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $delete;

        echo json_encode($response);
    }

    /**
     * @route('/game/doesBelongToPlayer?game_id={id}&player_id={id}')
     * @method('GET')
     * @return void
     * @throws Exception
     */
    protected function doesBelongToPlayer(): void
    {
        $gameId = $_GET["game_id"] ?? 0;
        $playerId = $_GET["player_id"] ?? 0;

        $response["response"] = GameUtils::doesGameBelongToPlayer(
            intval($gameId),
            intval($playerId)
        );

        http_response_code(200);

        echo json_encode($response);
    }

    /**
     * @route('/game/getModel?game_id={id}')
     * @method('GET')
     * @return void
     * @throws Exception
     */
    protected function getModel(): void
    {
        $gameId = $_GET["game_id"] ?? 0;

        $getModel = GameUtils::getModel(
            intval($gameId),
            intval($_SESSION["player_id"])
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

}

new GameController($_GET["route"]);
