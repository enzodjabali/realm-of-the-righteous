<?php

declare(strict_types = 1);

namespace App\public\api;

if (file_exists('../../vendor/autoload.php')) {
    require_once('../../vendor/autoload.php');
}

use App\classes\DbTable;
use App\classes\DbUtils;
use DevCoder\DotEnv;
use Exception;

require_once('../../classes/DbUtils.php');
require_once('../../classes/DbTable.php');

$link = $_GET["link"] ?? "";

class DoesResetPasswordLinkExist
{
    /**
     * This call echos 1 if the link exists, 0 if it doesn't
     * @param string $link the reset password link to check
     * @return void
     * @throws Exception
     */
    public static function do(string $link): void
    {
        (new DotEnv('./.env'))->load();
        echo !DbUtils::doesThisValueExist(DbTable::TABLE_RESET_PASSWORD_LINK, "link", $link);
    }
}

try {
    DoesResetPasswordLinkExist::do($link);
} catch (Exception $e) {
    echo $e;
}
