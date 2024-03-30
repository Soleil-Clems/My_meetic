<?php
@session_start();
$title = "Likes";
?>

<?php ob_start(); ?>
<p>Likes</p>
<section class="likeSection">
    <div class="containerLike">
        <?php
        foreach ($users as $key => $row) { ?>


            <a href="./profile?uid=<?= $row['id'] ?>">
                <div class="mini-card">
                    <div class="mini-head">
                        <div class="mini-img">
                            <img src="<?= $row['profil'] ?>" alt="Profil">
                        </div>
                    </div>
                    <div class="mini-body">
                        
                        <p><?= $row['firstname'] . ' ' . $row['lastname']; ?></p>
                    </div>
                </div>
            </a>
        <?php } ?>
    </div>
</section>
<?php
$content = ob_get_clean();
require "layout.php";
?>