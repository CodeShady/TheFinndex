<?php

class Account {
    private $ACCOUNT_DATA;
    private $ACCOUNT_NOTIFICATIONS;
    private $ACCOUNT_VALUE;

    function __construct($account_user) {
        // Load the JSON and find the user's information
        $portfolio_json     = file_get_contents("../" . PORTFOLIO_DATA_FILE);
        $notification_json  = file_get_contents("../" . NOTIFICATION_DATA_FILE);
        
        $portfolio_data     = json_decode($portfolio_json, true);
        $notification_data  = json_decode($notification_json, true);

        // Check if decoding was successful
        if ($portfolio_data === null || $notification_data === null) {
            die("Error decoding JSON data");
        }

        // Find this person
        $this->ACCOUNT_DATA             = $portfolio_data[$account_user];
        $this->ACCOUNT_NOTIFICATIONS    = $notification_data[$account_user];

        // Calculate the account value
        $this->ACCOUNT_VALUE += $this->get_cash_earning_interest();
        $this->ACCOUNT_VALUE += $this->get_total_interest_profit();
    }

    // Function to return true/false if the investor has auto-investing enabled
    public function is_auto_investing() {
        return $this->ACCOUNT_DATA["auto_invest"];
    }

    // Function to return an object of all notifications
    public function get_notifications() {
        return $this->ACCOUNT_NOTIFICATIONS;
    }

    // Function to return the number of notifications
    public function get_notification_count() {
        return count($this->get_notifications());
    }

    // Function to return the account value
    public function get_account_value() {
        return $this->ACCOUNT_VALUE;
    }

    // Calculate the daily interest rate based on the APY
    public function get_daily_interest_rate() {
        return pow(1 + (INTEREST_RATE_APY / 100), 1 / 365) - 1;
    }

    // Return a decimal of the amount of uninvested cash (literally copy and paste)
    public function get_uninvested_cash() {
        return $this->ACCOUNT_DATA["uninvested_cash"];
    }

    // Return a decimal of the amount of cash earning interest
    public function get_cash_earning_interest() {
        // If the start date isn't set, then the user IS NOT earning interest on their uninvested cash (safety measure for me!)
        if ($this->ACCOUNT_DATA["interest"]["inital_start_date"] != "")
            return $this->ACCOUNT_DATA["uninvested_cash"];
    }

    // Calculate the amount of profits earned from interest
    public function get_total_interest_profit() {
        $cash_earning_interest = $this->get_cash_earning_interest();
        $daily_interest_rate   = $this->get_daily_interest_rate();
        $interest_start_date   = strtotime($this->ACCOUNT_DATA["interest"]["inital_start_date"]);

        // If invalid input, just return 0
        if ($interest_start_date == "")
            return 0;

        // Calculate how many days have passed while earning interest
        $current_date   = time();
        $seconds_passed = $current_date - $interest_start_date;
        $days_passed    = floor($seconds_passed / (60 * 60 * 24));
        
        // Return the calculation (profit)!
        return $cash_earning_interest * pow(1 + $daily_interest_rate, $days_passed) - $cash_earning_interest;;
    }

    
}