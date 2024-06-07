function isStockMarketOpen() {
    const now = new Date();
    const dayOfWeek = now.getUTCDay();
    const hours = now.getUTCHours();
    const minutes = now.getUTCMinutes();

    // Check if it's a weekday and if the current time is within trading hours
    if (dayOfWeek >= 1 && dayOfWeek <= 5) { // Monday to Friday
        if ((hours == 13 && minutes >= 30) || (hours > 13 && hours < 20)) { // Trading hours in UTC
            return true;
        }
    }

    return false;
}

$(document).ready(function () {
    // Check if the stock market is open and alert the user accordingly
    if (isStockMarketOpen()) {
        $("#market-close").hide();
        $("#market-open").fadeIn();
    } else {
        $("#market-open").hide();
        $("#market-close").css("opacity", "1");
        $("#market-close").css("display", "none");
        $("#market-close").fadeIn();
    }
});