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

// Download all stock ticker data
foreach($data as $person => $portfolio) {
    // Loop through each stock this person owns
    foreach($portfolio["stocks"] as $stock) {
        // Download this data
        $stock_json = file_get_contents("https://api.polygon.io/v2/aggs/ticker/" . $stock['symbol'] . "/prev?adjusted=true&apiKey=" . API_KEY);
        
    }
}