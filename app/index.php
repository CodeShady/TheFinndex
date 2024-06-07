<?php
include_once("../configuration.php");
include_once("../Tools.php");
include_once("../Account.php");

// Prevent caching
Tools::prevent_cache();

// Variables
$OVERALL_PROFITS = 0;
$ACCOUNT_VALUE = 0;
$USER = Tools::clean_string($_GET["p"]);

// Check if $USER is set
if (!isset($_GET["p"])) {
    Tools::redirect("../");
}

// Create new account class for this user
$USER_ACCOUNT = new Account($USER);

// Read the JSON file contents
$json_data = file_get_contents("../portfolio.json");

// Decode the JSON data
$data = json_decode($json_data, true);

// Check if decoding was successful
if ($data === null) {
    die("Error decoding JSON data");
}

// Find this person (Beck)
$portfolio = $data[$USER];
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
    <link rel="stylesheet" type="text/css" href="../resources/css/global.css?version=<?php echo APP_VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="../resources/css/app.css?version=<?php echo APP_VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="../resources/css/notifications.css?version=<?php echo APP_VERSION; ?>" />
    <link rel="stylesheet" type="text/css" href="../resources/css/alertbox.css?version=<?php echo APP_VERSION; ?>" />

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Main App -->
</head>

<body>

    <?php if (DISPLAY_PAIN_POPUP): ?>
        <?php include_once("pain.php"); ?>
    <?php endif; ?>

    <!-- JS Alert Box -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="alertMessage"></p>
        </div>
    </div>

    <!-- Main app -->
    <div class="app p-4">

        <!-- Navbar -->
        <nav class="app-navbar mt-4">
            <!-- Navbar -->
            <h6 class="green" style="display:inline-block;">
                <img style="height:26px;width:auto;margin-top:-4px;" src="../resources/logo.png">
                <?php echo APP_TITLE; ?>
            </h6>
            
            <!-- Notification bell -->
            <div id="open-notification-center-btn" class="notification-bell stock-card p-2">
                <div class="notification-circle"></div>
                <img style="height:22px;width:auto;margin-top:-4px;" src="../resources/icons/bell-white.svg">
            </div>

            <!-- Market open/close -->
            <div class="market-status stock-card p-2" style="margin-right:5px;">
                <div id="market-open">
                    <img style="height:20px;width:auto;margin-top:-4px;" src="../resources/icons/market-open.svg">
                    Market Open
                </div>

                <div id="market-close">
                    <img style="height:20px;width:auto;margin-top:-4px;" src="../resources/icons/market-close.svg">
                    Market Closed
                </div>
            </div>
        </nav>

        <!-- Overview -->
        <h5 class="mt-3"><img style="height:20px;width:auto;margin-top:-4px;" src="../resources/icons/overview-white.svg"> Overview</h5>
        <div id="overview">
            <div class="row m-0">
                <div class="col stock-card p-3" style="margin-right:4px;">
                    <h6 class="small-text grey m-0 p-0">Total Gain/Loss</h6>
                    <h4 class="m-0 p-0" id="total-profits-text">+ $0.00</h4>
                </div>

                <div class="col stock-card p-3" style="margin-left:4px;">
                    <h6 class="small-text grey m-0 p-0">Your Equity</h6>
                    <h4 class="m-0 p-0" id="account-value-text">$0.00</h4>
                </div>
            </div>
            
            <div class="row m-0 mt-2">
                <div class="col stock-card p-3" style="background: transparent;border: 2px solid #292929;">
                    <h6 class="small-text grey m-0 p-0">Uninvested Cash</h6>
                    <h4 class="mt-1 m-0 color-accent-1">$<?php echo Tools::two_decimals($USER_ACCOUNT->get_uninvested_cash()); ?></h4>
                    <?php if ($USER_ACCOUNT->is_auto_investing()) : ?>
                        <?php include("../resources/blocks/auto_invest.php"); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Cash Sweep -->
        <h5 class="mt-4"><img style="height:20px;width:auto;margin-top:-4px;" src="../resources/icons/broom-white.svg"> Cash Sweep</h5>
        <p class="grey mb-2" style="margin-top: -5px;">Earn <span class="glare-gold"><?php echo INTEREST_RATE_APY; ?>% APY</span> on uninvested cash</p>
    
        <div class="row m-0">
            <div class="col stock-card p-3" style="margin-right:4px;text-align:center;">
                <h6 class="small-text grey m-0 p-0">Cash Earning Interest</h6>
                <h4 class="mt-1 color-accent-1">$<?php echo Tools::two_decimals($USER_ACCOUNT->get_cash_earning_interest()); ?></h4>
            </div>

            <div class="col stock-card p-3" style="margin-left:4px;text-align:center;">
                <h6 class="small-text grey m-0 p-0">Total Interest Earned</h6>
                <h4 class="mt-1 glare-gold">$<?php echo Tools::two_decimals($USER_ACCOUNT->get_total_interest_profit()); ?></h4>
            </div>
        </div>

        <!-- Crypto -->
        <h5 id="crypto" class="mt-4"><img style="height:20px;width:auto;margin-top:-4px;" src="../resources/icons/cryptocurrency-white.svg"> Crypto</h5>
        <p id="show-stock-picks" class="grey mb-2" style="margin-top: -5px;">View your <a id="show-recommended-picks" class="bold text-light" href="#crypto">recommended picks</a></p>
        <p id="hide-stock-picks" class="hidden grey mb-2" style="margin-top: -5px;">Hide your <a id="hide-recommended-picks" class="bold text-light" href="#crypto">recommended picks</a></p>
        
        <?php if (API_ENABLED_CRYPTO) : ?>
            <?php include("api_crypto.php"); ?>
        <?php endif; ?>

        <!-- Portfolio -->
        <h5 class="mt-4"><img style="height:20px;width:auto;margin-top:-4px;" src="../resources/icons/portfolio-white.svg"> Stocks</h5>
        <p class="grey mb-2" style="margin-top: -5px;">Find safe investments with our <a class="text-light text-decoration-none" href="./stock-picks/?p=<?php echo Tools::clean_string($_GET["p"]); ?>">top stock picks</a></p>

        <?php if (API_ENABLED_STOCKS) : ?>
            <?php include("api_stocks.php"); ?>
        <?php endif; ?>

        <div class="mt-4"></div>

    </div>

    <!-- Notification Center -->
    <div class="notification-background"></div>
    <div class="notification-center p-4">
        <?php include("../resources/blocks/notifications.php"); ?>
    </div>

    <!-- Scripts -->
    <script src="../resources/js/app.js?version=<?php echo APP_VERSION; ?>"></script>
    <script src="../resources/js/isMarketOpen.js?version=<?php echo APP_VERSION; ?>"></script>
    <script>
        const OVERALL_PROFITS = "<?php echo Tools::two_decimals($OVERALL_PROFITS); ?>";
        const ACCOUNT_VALUE = "<?php echo Tools::two_decimals($ACCOUNT_VALUE + $USER_ACCOUNT->get_account_value()); ?>";
        const NOTIFICATION_COUNT = "<?php echo $USER_ACCOUNT->get_notification_count(); ?>";

        $(document).ready(() => {
            // If the notification count isn't equal to the value in localstorage,
            // show the notification circle
            if (NOTIFICATION_COUNT != localStorage.getItem("notifications")) {
                $(".notification-circle").fadeIn();
            }

            // Update the total profits container
            if (Number(OVERALL_PROFITS) >= 0) {
                $("#total-profits-text").text(`+ $${Math.abs(OVERALL_PROFITS).toFixed(2)}`);
                $("#total-profits-text").addClass(`green`);
            } else {
                $("#total-profits-text").text(`- $${Math.abs(OVERALL_PROFITS).toFixed(2)}`);
                $("#total-profits-text").addClass(`red`);
            }

            // Check if we need to toggle total-holdings and total-equity
            $(".total-holdings").on("click", function() {
                $(".total-holdings").hide();
                $(".total-equity").show();
            });
            $(".total-equity").on("click", function() {
                $(".total-equity").hide();
                $(".total-holdings").show();
            });

            // Stock recommendation picks
            $("#show-recommended-picks").on("click", function() {
                // Show all picks
                $("#show-stock-picks").hide();
                $("#hide-stock-picks").show();
                $(".stock-recommendation-link").fadeIn();
            });

            $("#hide-recommended-picks").on("click", function() {
                // Show all picks
                $("#hide-stock-picks").hide();
                $("#show-stock-picks").show();
                $(".stock-recommendation-link").fadeOut();
            });

            // Update the account value container
            $("#account-value-text").text(`$${Math.abs(ACCOUNT_VALUE).toFixed(2)}`);
        });
    </script>

</body>

</html>