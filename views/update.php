<?php
@session_start();
if (isset($_SESSION["user"])) {
    $users = $_SESSION["user"];
}

$title = "Profile"; ?>

<?php ob_start(); ?>
<?php
if (isset($_SESSION["user"])) {
    $users = $_SESSION["user"]; ?>
    <div class="loisir">
        <h2>Optimize your profile</h2>
        <form action="" method="post" id="sendImg" enctype="multipart/form-data">
            <label for="profil" id="setprofil">
                <div id="default"><img src="<?=$users["profil"]?>" alt="default_image"></div>
                <i id="icon" class="fa-regular fa-pen-to-square "></i>
            </label><br>
            <input type="file" id="profil" name="file" accept=".jpg, .png, .jpeg">
        </form>
        <form id="updateForm" action="" method="post" enctype="multipart/form-data">


            <input class="same" type="text" name="firstname" placeholder="Firstname" id="firstname" value="<?= $users['firstname']; ?>"><br>
            <input class="same" type="text" name="lastname" placeholder="Lastname" id="lastname" value="<?= $users['lastname']; ?>"><br>
            <select name="city" id="city">
                <option value="<?= $users['city']; ?>"><?= $users['city']; ?></option>
                <option value="Paris">Paris</option>
                <option value="Marseille">Marseille</option>
                <option value="Lyon">Lyon</option>
                <option value="Toulouse">Toulouse</option>
                <option value="Nice">Nice</option>
                <option value="Nantes">Nantes</option>
                <option value="Strasbourg">Strasbourg</option>
                <option value="Montpellier">Montpellier</option>
                <option value="Bordeaux">Bordeaux</option>
                <option value="Lille">Lille</option>
                <option value="Rennes">Rennes</option>
                <option value="Reims">Reims</option>
                <option value="Le Havre">Le Havre</option>
                <option value="Saint-Etienne">Saint-Étienne</option>
                <option value="Toulon">Toulon</option>
                <option value="Grenoble">Grenoble</option>
                <option value="Dijon">Dijon</option>
                <option value="Angers">Angers</option>
                <option value="Nimes">Nîmes</option>
                <option value="Villeurbanne">Villeurbanne</option>
            </select><br>
            <input class="same" type="email" name="email" placeholder="yourmail@gmail.com" id="email" value="<?= $users['email']; ?>"><br>
            <input class="same" type="password" name="actualPassword" placeholder="Actual password" id="actualPassword"><br>
            <input class="same" type="password" name="psw" placeholder="New password" id="password"><br>
            <div class="password-criteria error" hidden>
                <p class="length">Length between 8 to 50</p>
                <p class="numeric">At least 2 numbers</p>
                <p class="maj">At least 2 capital letters</p>
                <p class="min">At least 2 capital lowercase</p>
                <p class="chars">At least 2 capital special characters</p>
            </div>
            <input class="same" type="password" name="cPsw" placeholder="Confirme password" id="confPassword"><br>



            <div id="responseError" class="error" hidden></div>
            <input type="submit" name="update" value="Update" id="updateBtn">
        </form>
    </div>




<?php } ?>


<?php $content = ob_get_clean();
require "layout.php";
?>