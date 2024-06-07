<?php

class Tools {
    static public function two_decimals($number, $places = 2) {
        return number_format((float)$number, $places, '.', ',');
    }

    // Function that takes JSON "orders" object as input and calculates the profit
    static public function calculate_profit($orders, $current_price) {
        $total_profit   = 0;
        $total_holdings = 0;

        // Loop through each order
        foreach ($orders as $order) {
            // Calculate profits and add equity
            $purchase_cost = $order["amount"] * $order["purchase_price"];
            $current_value = $order["amount"] * $current_price;

            // Add profit
            $total_profit += ($current_value - $purchase_cost);

            // Add holdings
            $total_holdings += $order["amount"];
        }

        // Return all data
        return array(
            "total_profit" => $total_profit,
            "total_holding_amount" => $total_holdings,
            "total_equity" => $current_price * $total_holdings,
        );
    }

    // Prevent caching by sending certain headers
    static public function prevent_cache() {
        header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }

    // Function to redirect user
    static public function redirect($location) {
        header("Location: " . $location);
        exit;
    }

    // Function to clean a string
    static public function clean_string($input) {
        // Remove HTML tags
        $cleaned_input = strip_tags($input);

        // Remove potentially dangerous characters
        $cleaned_input = preg_replace('/[^\p{L}\p{N}\s\.\,\-\_\!\@\#\$\%\^\&\*\(\)\[\]\{\}\;\'\"\:\|\?\+\=\<\>\,\/\\\]/u', '', $cleaned_input);

        // Optionally, you can trim the string
        $cleaned_input = trim($cleaned_input);

        return $cleaned_input;
    }
}