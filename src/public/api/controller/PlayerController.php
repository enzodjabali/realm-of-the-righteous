<?php

declare(strict_types = 1);

namespace App\public\controller\api;

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
    public function __construct(protected string $route)
    {
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
                $_SESSION["player_id"] = $login;
                $_SESSION["player_is_admin"] = PlayerUtils::isPlayerAdmin($login);
                $_SESSION["player_username"] = $playerInformation["username"];
                $_SESSION["player_email"] = $playerInformation["email"];

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

        if ($register == "1") {
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
            intval($_SESSION["player_id"])
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
            intval($_SESSION["player_id"]),
            $currentUsername,
            $currentEmail,
            htmlspecialchars($newUsername),
            htmlspecialchars($newEmail)
        );

        if ($update == "1") {
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
            intval($_SESSION["player_id"]),
            $currentPassword,
            $newPassword,
            $retypedNewPassword
        );

        if ($updatePassword == "1") {
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

        if ($updatePassword == "1") {
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

        if ($generateResetPasswordLink == "1") {
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

        if ($verify == "1") {
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

        $response["response"] = !DbUtils::doesThisValueExist(DbTable::TABLE_RESET_PASSWORD_LINK, "link", $link);

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
            intval($_SESSION["player_id"])
        );

        http_response_code(200);

        echo json_encode($response);
    }
}

new PlayerController($_GET["route"]);
