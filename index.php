<?php
include_once("configuration.php");

// Read the JSON file contents
$json_data = file_get_contents("portfolio.json");

// Decode the JSON data
$data = json_decode($json_data, true);

// Check if decoding was successful
if ($data === null) {
    die("Error decoding JSON data");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#D8E9A8">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta http-equiv="ScreenOrientation" content="autoRotate:disabled">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Title -->
    <title><?php echo APP_TITLE; ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;1,100;1,300;1,400;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="./resources/css/global.css?version=<?php echo APP_VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="./resources/css/app.css?version=<?php echo APP_VERSION; ?>" />

    <!-- Main App -->
</head>

<body>

    <!-- Main app -->
    <div class="app p-4">

        <!-- Navbar -->
        <nav class="app-navbar mt-4">
            <h5 class="green">
                <img style="height:26px;width:auto;margin-top:-4px;" src="./resources/logo.png">
                <?php echo APP_TITLE; ?>
            </h5>
        </nav>

        <!-- Home -->
        <h5 class="mt-4"><img style="height:20px;width:auto;margin-top:-4px;" src="./resources/icons/account-white.svg"> Choose Account</h5>
        <?php foreach ($data as $person => $portfolio) : ?>
            <a href="./app/?p=<?php echo $person; ?>" class="text-decoration-none">
                <div class="stock-card p-3 mb-2">
                    <h5 class="m-0 p-0"><?php echo $person; ?></h5>
                </div>
            </a>
        <?php endforeach; ?>

    </div>

</body>

</html>