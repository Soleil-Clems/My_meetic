<?php
$title = "home";

ob_start(); ?>
<div class="block">
    <div class="tools">
        <ul>
            <li id="test"><i class="fa-regular fa-clone"></i> <span>Découvrir</span></li>
            <li><span id="dropdown"><i class="fa-solid fa-gears"></i> Critères</span>
                <div class="dropdown">
                    <form action="" method="POST" id="filterForm">
                        <div class="divselect">
                            <label for="city">City :</label>
                            <select name="city" id="city">
                                <option value="all">All</option>
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
                            </select>
                        </div>
                        <div>

                            <input type="checkbox" id="dance" name="dance" value="Dance">
                            <label for="dance">Dance</label><br>
                            <input type="checkbox" id="skateboard" name="skateboard" value="Skateboard">
                            <label for="skateboard">Skateboard</label><br>
                            <input type="checkbox" id="manga" name="manga" value="Manga">
                            <label for="manga">Manga</label><br>
                            <input type="checkbox" id="game" name="gameplay" value="Game play">
                            <label for="game">Game play</label><br>
                            <input type="checkbox" id="cuisiner" name="cuisiner" value="Cuisiner">
                            <label for="cuisiner">Cuisiner</label><br>
                        </div>
                        <div class="divselect">
                            <label for="gender">Sexe :</label>
                            <select name="gender" id="gender">
                                <option value="male">Homme</option>
                                <option value="female">Femme</option>
                                <option value="both">Both</option>
                            </select>
                        </div>
                        <div class="range">
                            <label for="nothing">Age range</label>
                            <label>
                                <input type="radio" name="ageRange" value="18-25" id="firstTranche" checked> 18-25
                            </label>
                            <label>
                                <input type="radio" name="ageRange" value="25-35" id="secondTranche"> 25-35
                            </label>
                            <label>
                                <input type="radio" name="ageRange" value="35-45" id="thirdTranche"> 35-45
                            </label>
                            <label>
                                <input type="radio" name="ageRange" value="45-65" id="lastTranche"> 45+
                            </label>

                        </div>
                        <input type="submit" value="Filter" name="filter" id="filterBtn">
                    </form>

                </div>
            </li>
            <li><i class="fa-regular fa-star"></i> <span>La sélection</span></li>
            <li><i class="fa-solid fa-wifi"></i> <span>En ligne</span></li>
        </ul>
    </div>
    <div id="cards">

        <?php
        foreach ($users as $key => $user) {
            $hobbies = explode(",", $user['hobbies']);
        ?>
            <div class="card">
                <div class="left"><img src="<?= $user["profil"] ?>" alt=""> </div>
                <div class="right">
                    <div class="userInfoTop">
                        <h2><?= $user["firstname"] ?> <?= $user["lastname"] ?></h2>
                        <p><?php $today = new DateTime(date('Y-m-d'));
                            $birthday = new DateTime($user['birthday']);
                            $diff = $birthday->diff($today);
                            $age = $diff->y;
                            echo "$age ans, " . $user['city']; ?></p>
                    </div>
                    <div class="userInfoBottom">
                        <div class="location"><i class="fa-solid fa-venus-mars"></i> <?= $user["gender"] ?></div>
                        <div class="location"><i class="fa-solid fa-fire"></i> <?= $user["attraction"] ?></div>
                        <?php
                        foreach ($hobbies as $key => $value) {
                            switch (strtolower($value)) {
                                case 'dance':
                                    echo "<div class='location'><i class='fa-regular fa-face-smile-wink'></i> $value</div>";
                                    break;
                                case 'cuisiner':
                                    echo "<div class='location'><i class='fa-solid fa-kitchen-set'></i> $value</div>";
                                    break;
                                case 'game play':
                                    echo "<div class='location'><i class='fa-solid fa-gamepad'></i> $value</div>";
                                    break;
                                case 'manga':
                                    echo "<div class='location'><i class='fa-solid fa-book-open'></i> $value</div>";
                                    break;
                                case 'skateboard':
                                    echo "<div class='location'><i class='fa-solid fa-person-skating'></i> $value</div>";
                                    break;
                                default:
                                    echo "<div class='location'><i class='fa-regular fa-face-smile-beam'></i> $value</div>";
                                    break;
                            }
                        }
                        ?>


                        <div class="superflux"><i class="fa-solid fa-location-dot"></i> 5 km</div>
                        <div class="superflux"><i class="fa-solid fa-ruler"></i> 160 cm</div>
                        <div class="diplome"><i class="fa-solid fa-graduation-cap"></i> Bac +5 et plus</div>
                        <div class="enfat"><i class="fa-solid fa-baby-carriage"></i> Pas d'enfant</div>
                        <div class="superflux"><i class="fa-solid fa-baby"></i> Je veux des enfants</div>
                    </div>
                    <div class="divBtn">
                        <div class="slideBtn" data-slide="<?= $user['id'] ?>" data-want="false"><i class="fa-solid fa-xmark"></i> Non</div>
                        <div class="slideBtn" data-slide="<?= $user['id'] ?>" data-want="true"><i class="fa-solid fa-heart"></i> Oui</div>
                        <a href="./profile?uid=<?= $user['id'] ?>"><i class="fa-solid fa-eye"></i> Voir</a>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>


</div>

<?php $content = ob_get_clean();
require "layout.php";
?>