<?php
include_once("../configuration.php");
include_once("../Tools.php");
include_once("../Account.php");

// PHP Code to add notification to JSON file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read the JSON file
    $jsonFile = "../" . NOTIFICATION_DATA_FILE;
    $jsonData = file_get_contents($jsonFile);
    $data = json_decode($jsonData, true);

    // Get input values
    $user       = $_POST['user'];
    $title      = $_POST['title'];
    $message    = $_POST['message'];

    // New notification data
    $newNotification = array(
        "title" => $title,
        "message" => $message,
        "timestamp" => date("M jS, Y")
    );

    // Add the new notification to the specified user's array
    $data[$user][] = $newNotification;

    // Encode the data back to JSON
    $newJsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Write the JSON data back to the file
    file_put_contents($jsonFile, $newJsonData);

    // Redirect
    Tools::redirect("admin.php?success");
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
    <link rel="stylesheet" type="text/css" href="../resources/css/app.css?version=<?php echo APP_VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="../resources/css/notifications.css?version=<?php echo APP_VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="../resources/css/alertbox.css?version=<?php echo APP_VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="../resources/css/admin.css?version=<?php echo APP_VERSION; ?>" />

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Main App -->
</head>

<body>

    <!-- Main app -->
    <div class="app p-4">

        <!-- Navbar -->
        <nav class="app-navbar mt-4">
            <!-- Navbar -->
            <h5 class="green" style="display:inline-block;">
                <img style="height:26px;width:auto;margin-top:-4px;" src="../resources/logo.png">
                <?php echo APP_TITLE; ?>  <span class="text-light">Admin Zone</span>
            </h5>
        </nav>

        <!-- Cash Sweep -->
        <h5 class="mt-4"><img style="height:20px;width:auto;margin-top:-4px;" src="../resources/icons/admin-white.svg"> Add Notification</h5>
        <div>
            <form method="post">
                <div class="form-group mt-2">
                    <label for="user" class="text-light">Select User:</label>
                    <select id="user" name="user" class="form-control">
                        <option value="Beck">Beck</option>
                        <option value="Evvi">Evvi</option>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="title" class="text-light">Title:</label>
                    <input type="text" id="title" name="title" class="form-control">
                </div>
                <div class="form-group mt-2">
                    <label for="message" class="text-light">Message:</label>
                    <textarea type="text" id="message" name="message" class="form-control"></textarea>
                </div>
                <button type="submit" class="mt-2 btn btn-primary">Add Notification</button>
            </form>

            <?php
            if (isset($_GET["success"])) {
                echo "<span class='mt-2 green bold'>Added notification!</span>";
            }
            ?>
        </div>

        <div class="mt-4"></div>

    </div>

</body>

</html>