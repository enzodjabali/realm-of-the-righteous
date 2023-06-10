<?php
    $verifyMessage = "The link has expired.";

    if (isset($_GET["link"]) && is_string($_GET["link"])) {
        $serverUrl = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";

        $url = "$serverUrl/api/v1/player/verify?link={$_GET["link"]}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

        // Proxy for Docker
        curl_setopt($ch, CURLOPT_PROXY, $_SERVER['SERVER_ADDR'] . ':' .  $_SERVER['SERVER_PORT']);

        if (($response = curl_exec($ch)) === false) {
            echo 'Curl error: ' . curl_error($ch);
            die();
        }
        curl_close($ch);

        if (json_decode($response, true)["response"] === true) {
            $verifyMessage = "You've been successfully verified!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realm Of The Righteous - Verify account</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
        <link href="assets/css/styles.css" rel="stylesheet">

        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    </head>

    <body>
    <?php include_once("includes/menu.php") ?>

    <div class="card text-center w-75 position-absolute top-50 start-50 translate-middle">
        <div class="card-body pt-4">
            <p><?= $verifyMessage ?></p>
        </div>
    </div>

    <?php include_once("includes/footer.php") ?>
    </body>
</html>
