<?php

declare(strict_types = 1);

namespace App\public\api\controller;

session_start();

if (file_exists('../../../vendor/autoload.php')) {
    require_once('../../../vendor/autoload.php');
}

use App\classes\DbTable;
use App\classes\DbUtils;
use App\classes\PlayerUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../../classes/DbUtils.php');
require_once('../../../classes/DbTable.php');
require_once('../../../classes/PlayerUtils.php');

header("Content-Type:application/json");

(new DotEnv('../.env'))->load();

class PlayerController {
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
     * @route('/player/getAll')
     * @method('GET')
     * @return void
     * @throws Exception
     */
    protected function getAll(): void
    {
        $getAll = PlayerUtils::findAllPlayers(
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
     * @route('/player/login')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function login(): void
    {
        extract($_POST);

        $login = PlayerUtils::loginPlayer(
            htmlspecialchars($username),
            $password
        );

        if (is_numeric($login)) {
            $playerInformation = PlayerUtils::getPlayerInformation($login);

            if (is_array($playerInformation)) {
                $_SESSION["playerId"] = $login;
                $_SESSION["playerIsAdmin"] = PlayerUtils::isPlayerAdmin($login);
                $_SESSION["playerUsername"] = $playerInformation["username"];
                $_SESSION["playerEmail"] = $playerInformation["email"];

                http_response_code(200);
                $response['response'] = $login;
            } else {
                http_response_code(400);
                $response['response'] = "An error has occurred.";
            }
        } else {
            http_response_code(400);
            $response['response'] = $login;
        }

        echo json_encode($response);
    }

    /**
     * @route('/player/register')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function register(): void
    {
        extract($_POST);

        $register = PlayerUtils::insertPlayer(
            htmlspecialchars($username),
            $password,
            $retypedPassword,
            htmlspecialchars($email),
            $terms === 'true'
        );

        if ($register === true) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $register;

        echo json_encode($response);
    }

    /**
     * @route('/player/delete')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function delete(): void
    {
        $response["response"] = PlayerUtils::deletePlayer(
            $this->sessionId
        );

        http_response_code(200);

        echo json_encode($response);
    }

    /**
     * @route('/player/update')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function update(): void
    {
        extract($_POST);

        $update = PlayerUtils::updatePlayer(
            $this->sessionId,
            $currentUsername,
            $currentEmail,
            htmlspecialchars($newUsername),
            htmlspecialchars($newEmail)
        );

        if ($update === true) {
            $_SESSION["playerUsername"] = htmlspecialchars($newUsername);
            $_SESSION["playerEmail"] = htmlspecialchars($newEmail);
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $update;

        echo json_encode($response);
    }

    /**
     * @route('/player/updatePassword')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function updatePassword(): void
    {
        extract($_POST);

        $updatePassword = PlayerUtils::updatePassword(
            $this->sessionId,
            $currentPassword,
            $newPassword,
            $retypedNewPassword
        );

        if ($updatePassword === true) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $updatePassword;

        echo json_encode($response);
    }

    /**
     * @route('/player/resetPassword')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function resetPassword(): void
    {
        extract($_POST);

        $updatePassword = PlayerUtils::resetPassword(
            $link,
            $newPassword,
            $retypedNewPassword
        );

        if ($updatePassword === true) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $updatePassword;

        echo json_encode($response);
    }

    /**
     * @route('/player/generateResetPasswordLink')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function generateResetPasswordLink(): void
    {
        extract($_POST);

        $generateResetPasswordLink = PlayerUtils::generateResetPasswordLink(
            htmlspecialchars($playerEmail)
        );

        if ($generateResetPasswordLink === true) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $generateResetPasswordLink;

        echo json_encode($response);
    }

    /**
     * @route('/player/verify')
     * @method('GET')
     * @return void
     * @throws Exception
     */
    protected function verify(): void
    {
        $verify = PlayerUtils::verifyPlayer(
            htmlspecialchars($_GET["link"])
        );

        if ($verify === true) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        $response['response'] = $verify;

        echo json_encode($response);
    }

    /**
     * @route('/player/doesResetPasswordLinkExist')
     * @method('GET')
     * @return void
     * @throws Exception
     */
    protected function doesResetPasswordLinkExist(): void
    {
        $link = $_GET["link"] ?? "";

        $response["response"] = !DbUtils::doesThisValueExist(
            DbTable::TABLE_RESET_PASSWORD_LINK,
            "link",
            $link
        );

        http_response_code(200);

        echo json_encode($response);
    }

    /**
     * @route('/player/updateActivity')
     * @method('POST')
     * @return void
     * @throws Exception
     */
    protected function updateActivity(): void
    {
        $response["response"] = PlayerUtils::updateActivity(
            $this->sessionId
        );

        http_response_code(200);

        echo json_encode($response);
    }
}

new PlayerController($_GET["route"]);
