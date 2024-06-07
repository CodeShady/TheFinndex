<h4 class="mb-2"><img style="height:22px;width:auto;margin-top:-4px;" src="../resources/icons/bell-white.svg"> Notifications</h4>

<!-- Display each notification -->
<div class="notification-container">
    <?php foreach(array_reverse($USER_ACCOUNT->get_notifications()) as $notification) : ?>
        <div class="notification pt-2 pb-2 mt-1">
            <span class="grey m-0"><?php echo $notification["timestamp"]; ?></span>
            <h6 class="mb-1 mt-1"><?php echo $notification["title"]; ?></h6>
            <p class="grey m-0"><?php echo $notification["message"]; ?></p>
        </div>
        <hr class="m-1 notification-divider">
    <?php endforeach; ?>

    <div class="mb-4"></div>
</div>