<?php

define("APP_TITLE",     "The Finndex");
define("APP_VERSION",   "1.6.5-pub");

define("AVALAIBLE_CURRENCIES", 'BTC,ETH,LTC,DOGE,XRP,BCH,SOL,BNB,USDT,AVAX,MKR');

define("PORTFOLIO_DATA_FILE",       "portfolio.json");
define("NOTIFICATION_DATA_FILE",    "notifications.json");

define("API_ENABLED_CRYPTO", true);
define("API_ENABLED_STOCKS", true);
define("API_KEY",           "API_KEY_REQUIRED_HERE");     // polygon.io API key
define("CRYPTO_API_KEY",    "API_KEY_REQUIRED_HERE"); // coinmarketcap.com API Key

// Cash Interest
define("INTEREST_RATE_APY", 5); // Does your broker give you APY on uninvested cash?

// Stock Picks
define("STOCK_PICKS_CSV", "2023-12-17-mf-stock-picks.csv"); // CSV File containing top rated stocks

// Misc
define("DISPLAY_PAIN_POPUP", false); // Funny message