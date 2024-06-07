<?php
$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
$parameters = [
    'symbol' => AVALAIBLE_CURRENCIES,
    'convert' => 'USD'
];
$headers = [
    'Accepts: application/json',
    'X-CMC_PRO_API_KEY: ' . CRYPTO_API_KEY
];
$qs = http_build_query($parameters); // query string encode the parameters
$request = "{$url}?{$qs}"; // create the request URL


$curl = curl_init(); // Get cURL resource
// Set cURL options
curl_setopt_array($curl, array(
    CURLOPT_URL => $request,            // set the request URL
    CURLOPT_HTTPHEADER => $headers,     // set the headers
    CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
));

if (API_ENABLED_CRYPTO)
    $response = curl_exec($curl); // Send the request, save the response
else
    $response = array();
$crypto_data = json_decode($response, true); // print json decoded response
curl_close($curl); // Close request
?>
<?php foreach ($portfolio["crypto"] as $coin) : ?>
    <?php if (isset($coin["recommended"]) && $coin["recommended"] == true) : ?>
        <!-- Display the recommended stock -->
        <a href="https://stocks.apple.com/symbol/<?php echo $coin["symbol"]; ?>-USD" class="stock-recommendation-link text-decoration-none">
            <div class="stock-recommendation stock-card p-3 mb-2">
                <h5 class="m-0 p-0"><?php echo $coin["symbol"]; ?></h5>
                <p class="grey m-0 p-0">Recommended</p>
            </div>
        </a>
    <?php else: ?>
        <?php
        $coin_price = $crypto_data["data"][$coin["symbol"]]["quote"]["USD"]["price"];

        // Calculate profits for all transactions
        $holding = Tools::calculate_profit($coin["orders"], $coin_price);

        // Add the profit to the global variable & update the price
        $OVERALL_PROFITS += $holding["total_profit"];
        $ACCOUNT_VALUE += $holding["total_equity"];
        ?>
        <div class="stock-card p-3 mb-2">

            <div class="row">
                <div class="col">
                    <h5 class="glare-silver m-0 p-0"><?php echo $coin['symbol']; ?></h5>
                </div>
                <div class="col" style="text-align:right;">
                    <h4 class="m-0 p-0">$<?php echo Tools::two_decimals($coin_price) ?></h4>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    <p class="total-holdings grey m-0 p-0"><?php echo $holding["total_holding_amount"]; ?> coins</p>
                    <p class="total-equity grey m-0 p-0 hidden">$<?php echo Tools::two_decimals($holding["total_equity"]); ?></p>
                </div>
                <div class="col" style="text-align: right;">
                    <?php if ($holding["total_profit"] >= 0) : ?>
                        <p class="green m-0 p-0">+ $<?php echo Tools::two_decimals($holding["total_profit"]); ?></p>
                    <?php else : ?>
                        <p class="red m-0 p-0">- $<?php echo Tools::two_decimals(abs($holding["total_profit"])); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Additional badges below -->
            <?php if (isset($coin["stop_loss"]) && !empty($coin["stop_loss"])): ?>
                <?php include("../resources/blocks/stop_loss.php"); ?>
            <?php elseif (isset($coin["external_broker"]) && $coin["external_broker"]) : ?>
                <?php include("../resources/blocks/external_broker.html"); ?>
            <?php endif; ?>

        </div>
    <?php endif; ?>
<?php endforeach; ?>