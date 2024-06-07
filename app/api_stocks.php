<div id="portfolio">
<?php foreach ($portfolio["stocks"] as $stock) : ?>
    <?php if (isset($stock["recommended"]) && $stock["recommended"] == true) : ?>
        <!-- Display the recommended stock -->
        <a href="https://stocks.apple.com/symbol/<?php echo $stock["symbol"]; ?>" class="stock-recommendation-link text-decoration-none">
            <div class="stock-recommendation stock-card p-3 mb-2">
                <h5 class="m-0 p-0"><?php echo $stock["symbol"]; ?></h5>
                <p class="grey m-0 p-0">Recommended</p>
            </div>
        </a>
    <?php else: ?>
        <?php
        // Get current stock price
        if (API_ENABLED_STOCKS)
            $stock_json = file_get_contents("https://api.polygon.io/v2/aggs/ticker/" . $stock['symbol'] . "/prev?adjusted=true&apiKey=" . API_KEY);
        else
            break;

        $stock_data = json_decode($stock_json, true);

        // Get the most recent data
        $most_recent_price = $stock_data["results"][0];

        // Calculate the average price for this day
        $average_stock_price = ($most_recent_price["h"] + $most_recent_price["l"]) / 2;

        // Calculate profits for all transactions
        $holding = Tools::calculate_profit($stock["orders"], $average_stock_price);

        // Add the profit to the global variable & update the price
        $OVERALL_PROFITS += $holding["total_profit"];
        $ACCOUNT_VALUE += $holding["total_equity"];
        ?>

        <div class="stock-card p-3 mb-2">
            <div class="row">
                <div class="col">
                    <h5 class="m-0 p-0"><?php echo $stock['symbol']; ?></h5>

                    <p class="total-holdings grey m-0 p-0"><?php echo $holding["total_holding_amount"]; ?> shares</p>
                    <p class="total-equity grey m-0 p-0 hidden">$<?php echo Tools::two_decimals($holding["total_equity"]); ?></p>
                    
                    <!-- ETF Badge -->
                    <?php if (isset($stock["tags"])) : ?>
                        <?php foreach($stock["tags"] as $tag) : ?>
                            <div class="stock-tag"><?php echo $tag; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="col-4" style="text-align: right;">
                    <h4 class="m-0 p-0">$<?php echo Tools::two_decimals($average_stock_price) ?></h4>

                    <?php if ($holding["total_profit"] >= 0) : ?>
                        <p class="green m-0 p-0">+ $<?php echo Tools::two_decimals($holding["total_profit"]); ?></p>
                    <?php else : ?>
                        <p class="red m-0 p-0">- $<?php echo Tools::two_decimals(abs($holding["total_profit"])); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- EXTERNAL account icon -->
            <?php if (isset($stock["external_broker"]) && $stock["external_broker"]) : ?>
                <?php include("../resources/blocks/external_broker.html"); ?>
            <?php endif; ?>

        </div>
    <?php endif;?>
<?php endforeach; ?>
</div>