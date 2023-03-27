<h1>This is html message!</h1>

<?php

include("../classes/DBUtils.php");

#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);

echo "Hello!";

$DBUtils = new DBUtils();
$result = $DBUtils::insert();

echo $result;

