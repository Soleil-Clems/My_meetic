<?php
@session_start();
$title = "Messages"; ?>

<?php ob_start(); ?>
<p>messages</p>

<section class="messageSection">
    <div class="msgLeft">
        <div class="msgTop">All messages</div>
        <div class="msgBottom">
            <?php
            foreach ($users as $key => $user) { ?>

                <a href="./messages?msg=<?=$user['id']?>" class="context">
                    <div class="img">
                        <img src="<?=$user['profil']?>" alt="">
                    </div>
                    <div class="userInfo"><?=$user['firstname']." ".$user['lastname']?></div>
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="msgRight">
        <div class="screen">
        </div>
        <div class="form">
            <form action="" method="POST" id="messageForm">
                <input type="text" id="msg" placeholder="write your message" name="msg">
                <label for="msgBtn"><i class="fa-solid fa-paper-plane"></i></label>
                <input type="submit" value="send" name="send" id="msgBtn" data-msg="">
            </form>
        </div>
    </div>
</section>

<?php
// echo "<pre>";
// var_dump($_GET);
// echo "</pre>";
$content = ob_get_clean();
require "layout.php";
?>