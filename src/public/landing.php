<!DOCTYPE html>
<html>
  <head>
      <title>Realm of the righteous</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="icon" type="image/x-icon" href="assets/images/website/favicon.ico">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
      <style>
        body,h1,h2{font-family: "Raleway", sans-serif}
        body, html {height: 100%}
        p {line-height: 2}
        .bgimg{
          min-height: 100%;
          background-position: center;
          background-size: cover;
        }
        .bgimg {background-image: url("assets/images/website/frame.jpg")}
      </style>
    </head>

  <body>
    <!-- Header / Home-->
    <header class="w3-display-container w3-wide bgimg w3-grayscale-min" id="home">
      <div class="w3-display-middletop w3-text-white w3-center">
        <img src="assets/images/website/logo.png" height="400px">
        <h1 class="w3-jumbo" style="color: navy;font-family: 'Old English Text MT'">Realm Of The Righteous</h1>
        <h2 style="color: navy">The best tower defense in all the realm</h2>
        <button onclick="location.href = 'login.html';" style="border-radius: 25px;background-color: maroon;border: none;color: antiquewhite; width: 150px;height: 50px; font-size: 1.3em; cursor: pointer;">Start now</button>
        <h2><b></b></h2>
      </div>
    </header>

    <?php include_once("includes/menu.php") ?>

  </body>
</html>