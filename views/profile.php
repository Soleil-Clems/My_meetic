<?php
@session_start();
$title = "Profile"; ?>

<?php ob_start(); ?>
<?php
if (isset($users['hobby']) && count($users["hobby"]) > 0) { ?>
    <div id="profileCard">
        <?php if (!isset($_GET['uid'])) { ?>
            <a class="update" href="update"><i class="fa-regular fa-pen-to-square icon"></i></a>
        <?php } ?>
        <h2><?= ucfirst($users['firstname']) ?> <?= ucfirst($users['lastname']) ?></h2>

        <div id="labprofil">
            <div id="default"><img src="<?= $users["profil"] ?>" alt="default_image"></div>
        </div><br>

        <?php if (isset($_GET['uid'])) { ?>
            <div class="divBtn">
                <div class="invitation" data-slide="<?= $_GET['uid'] ?>" data-want="false"><i class="fa-solid fa-xmark"></i> Non</div>
                <div class="invitation" data-slide="<?= $_GET['uid'] ?>" data-want="true"><i class="fa-solid fa-heart"></i> Oui</div>
            </div>
        <?php } ?>

        <p><?php $today = new DateTime(date('Y-m-d'));
            $birthday = new DateTime($users['birthday']);
            $diff = $birthday->diff($today);
            $age = $diff->y;
            echo "$age ans, " . $users['city']; ?> </p>

        <p><?= $users['email'] ?> </p>
        <p>Gender : <?= ucfirst($users['gender']) ?> </p>
        <p>Attracted by : <?= ucfirst($users['attraction']) ?> </p>
        <p>Hobby(ies):
            <?php
            foreach ($users["hobby"] as $key => $value) { ?>
                <?php echo $value['name'];
                if (count($users['hobby']) > $key + 1) {
                    echo ",";
                }
                ?>
            <?php } ?>
        </p>
        <div id="config">
            <?php
            if (!isset($_GET['uid'])) { ?>
                <a id="no" href="disable">Delete</a>
                <a class="a" href="logout">Logout</a>
            <?php } ?>
        </div>

    </div>

<?php } else { ?>
    <div class="loisir">
        <h2>Optimize your profile</h2>
        <form action="" method="post" id="sendImg" enctype="multipart/form-data">
            <label for="profil" id="setprofil">
                <div id="default"><img src="<?= $users["profil"] ?>" alt="default_image"></div>
                <i id="icon" class="fa-regular fa-pen-to-square "></i>
            </label><br>
            <input type="file" id="profil" name="file" accept=".jpg, .png, .jpeg">
        </form>

        <form id="optimizeForm" action="" method="post" enctype="multipart/form-data">

            <input type="checkbox" id="dance" name="dance" value="1">
            <label for="dance">Dance</label><br>
            <input type="checkbox" id="skateboard" name="skateboard" value="2">
            <label for="skateboard">Skateboard</label><br>
            <input type="checkbox" id="manga" name="manga" value="3">
            <label for="manga">Manga</label><br>
            <input type="checkbox" id="game" name="gameplay" value="4">
            <label for="game">Game play</label><br>
            <input type="checkbox" id="cuisiner" name="cuisiner" value="5">
            <label for="cuisiner">Cuisiner</label><br>
            <div id="responseError" class="error" hidden></div>
            <input type="submit" name="loisir" value="Optimize" id="optimizeBtn">
        </form>
        <div id="config">
            <a class="a" href="logout">Logout</a>
        </div>
    </div>

<?php } ?>


<?php $content = ob_get_clean();
require "layout.php";
?>