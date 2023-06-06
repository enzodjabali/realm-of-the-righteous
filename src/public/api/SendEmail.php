<?php

declare(strict_types = 1);

namespace App\public\api;

session_start();

if (file_exists('../../vendor/autoload.php')) {
    require_once('../../vendor/autoload.php');
}

use App\classes\EmailSender;
use DevCoder\DotEnv;
use Exception;


require_once('../../classes/EmailSender.php');

extract($_POST);

class SendEmail
{
    public static function do(string $recipientEmail, string $recipientUsername): void
    {
        (new DotEnv('./.env'))->load();
        echo EmailSender::sendEmail($recipientEmail, $recipientUsername);
    }
}

SendEmail::do(htmlspecialchars($_SESSION["player_email"]), htmlspecialchars($_SESSION["player_username"]));
