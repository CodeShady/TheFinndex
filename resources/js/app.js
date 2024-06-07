// Function to display custom modal alert
function customAlert(message) {
    var modal = document.getElementById("myModal");
    var alertMessage = document.getElementById("alertMessage");
    alertMessage.innerHTML = message;
    modal.style.display = "block";

    // When the user clicks on <span> (x), close the modal
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function external_account_reminder() {
    customAlert("These funds are only being tracked. They are physically located somewhere else and don't belong to your broker.");
}

function stop_loss_info(stop_loss_amount) {
    customAlert(`Your broker has set a stop-loss for this fund.<br><br>If the fund's price drops below <span class="glare-red">${stop_loss_amount}</span>, your funds will be automatically sold.<br><br>This helps protect your hard-earned profits by preventing further losses if the market takes a downturn.`)
}

function auto_investing() {
    customAlert(`<strong>Auto-investing is enabled.</strong><br><br>Your broker is actively searching for the best market deals for your uninvested cash.<br><br>Let your broker know if you'd like to disable this to enter/exit a trade yourself.`)
}

$("document").ready(function () {
    // Open notification center button
    $("#open-notification-center-btn").on("click", function() {
        // Hide the notification alert circle
        $(".notification-circle").fadeOut();

        // Update the localstorage value
        localStorage.setItem("notifications", NOTIFICATION_COUNT);

        // "Lock" background
        $("body").css("overflow", "hidden");

        // Slide up the notification center
        $(".notification-background").fadeIn(200);
        $(".notification-center").animate({top: "20%"}, 400);

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if ($(event.target).is(".notification-background")) {
                // Hide the notification center
                $(".notification-background").fadeOut(200);
                $(".notification-center").animate({top: "100vh"}, 200);
                // "Unlock" background
                $("body").css("overflow", "auto");
            }
        }
    });
});