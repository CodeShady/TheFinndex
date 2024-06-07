<?php
include_once("../../configuration.php");

// Prevent caching
// header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
// header('Cache-Control: no-store, no-cache, must-revalidate');
// header('Cache-Control: post-check=0, pre-check=0', FALSE);
// header('Pragma: no-cache');
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
    <link rel="stylesheet" type="text/css" href="../../resources/css/app.css?version=1.3.0" />

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<body>

    <!-- Main app -->
    <div class="app p-4">

        <!-- Navbar -->
        <nav class="app-navbar mt-4">
            <!-- Navbar -->
            <h5 class="green" style="display:inline-block;">
                <img style="height:26px;width:auto;margin-top:-4px;" src="../../resources/logo.png">
                <?php echo APP_TITLE; ?>
            </h5>
        </nav>

        <div class="mt-3">
            <a class="grey text-decoration-none" href="../<?php if (isset($_GET["p"])) { echo "?p=".$_GET["p"]; } else { echo "../"; } ?>"><img style="height:20px;width:auto;margin-top:-4px;" src="../../resources/icons/back-grey.svg"> Go Back</a>
        </div>

        <!-- Overview -->
        <h5 class="mt-3"><img style="height:20px;width:auto;margin-top:-4px;" src="../../resources/icons/eyeglass-white.svg"> Stock Picks</h5>
        <p class="grey mb-2" style="margin-top: -5px;">Find top stocks from the <span class="glare-gold">Motley Fool</span></p>

        <div class="stock-picks">
            <?php
            // Open the CSV file for reading
            $file = fopen(STOCK_PICKS_CSV, 'r');
            $stock_rank = 0;

            // Check if the file was opened successfully
            if ($file !== false) {
                // Read the header row to get column names
                $headers = fgetcsv($file);

                // Loop through each row in the CSV file
                while (($row = fgetcsv($file)) !== false) {
                    // Combine header names with row values to create an associative array
                    $data = array_combine($headers, $row);

                    // Increase stock rank
                    $stock_rank += 1;

                    echo '<a class="text-decoration-none" target="_blank" href="https://finance.yahoo.com/quote/' . $data["Ticker"] . '">
                            <div class="stock-card p-3 mb-2">
                                <div class="row">
                                    <div class="col">
                                        <p class="grey m-0 p-0">' . $data["Company"] . '</p>
                                        <h5 class="m-0 p-0"><span class="glare-gold">#' . $stock_rank . '</span> ' . $data["Ticker"] . '</h5>
                                    </div>

                                    <div class="col-4" style="text-align: right;">
                                        <img style="width:20px;height:auto;" src="../../resources/icons/open-grey.svg">
                                    </div>
                                </div>
                            </div>
                        </a>';
                }

                // Close the file
                fclose($file);
            } else {
                echo "Failed to open the file.";
            }
            ?>
        </div>

        <div class="mt-4"></div>

    </div>

</body>

</html>