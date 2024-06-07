<!-- Pain Container -->
<div class="pain-container">

    <div class="content">

        <img style="margin: 40px 0;height: 50px;width:100%;" src="../resources/icons/sleep-moon.svg">

        <h1>Account Hibernating</h1>

        <p>For the sake of your sanity, your account is taking a nap for a little bit.</p>

        <p>Remember, the crypto market can be volatile, but history has shown that it often bounces back stronger than ever. Stay patient and focused on your long-term goals. Your investments are part of a larger journey, and temporary setbacks are just bumps along the way to potential future gains.</p>
        
        <p><strong>Keep a steady hand and trust in your investment strategy.</strong></p>
    
        <a href="#">
            <button id="continue-pain-button" class="button">
                Continue anyway?
            </button>
        </a>
    </div>

</div>

<!-- Script -->
<script>
$(document).ready(function(){
    $("#continue-pain-button").click(function(){
        // Annoying confirmation dialog
        if(confirm("Ayo, you sure?")) {
            if(confirm("Seriously?")) {
                if(confirm("Really? You're absolutely positive?")) {
                    finished_annoying_user();
                }
            }
        }
    });

    // Hide the app
    $(".app").hide();
});

function close_window() {
    window.location.replace("http://www.google.com");
}

function finished_annoying_user() {
    // Function to call when user finally agrees
    $(".app").show();
    $(".pain-container").fadeOut("fast");
}
</script>