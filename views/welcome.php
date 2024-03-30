<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Meetic - Trouver l'amour</title>
    <meta name="description" content="Découvrez My Meetic pour des rencontres exceptionnelles. Trouvez l'amour, faites des rencontres intéressantes et explorez de nouvelles relations.">
    <meta name="keywords" content="My Meetic, rencontre, amour, relation">
    <meta name="author" content="My Meetic">
    <meta name="robots" content="index, follow">
    <link rel="shortcut icon" href="./assets/favicon.png" type="image/x-icon">
    <meta property="og:title" content="My Meetic - Découvrez le meilleur des rencontres">
    <meta property="og:description" content="Découvrez My Meetic pour des rencontres exceptionnelles. Trouvez l'amour, faites des rencontres intéressantes et explorez de nouvelles relations.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="URL_de_votre_site">
    <meta property="og:image" content="URL_de_l'image_à_afficher_sur_les_réseaux_sociaux">


    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="My Meetic - Découvrez le meilleur des rencontres">
    <meta name="twitter:description" content="Découvrez My Meetic pour des rencontres exceptionnelles. Trouvez l'amour, faites des rencontres intéressantes et explorez de nouvelles relations.">
    <meta name="twitter:image" content="URL_de_l'image_à_afficher_sur_Twitter">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./css/welcome.css">

</head>

<body>

    <header>
        <nav>
            <div class="logo"><img src="./assets/logo.png" alt=""></div>
            <ul>
                <li>
                    <p class="login">Login</p>
                </li>
                <li>
                    <p class="register">Sign in</p>
                </li>
            </ul>
        </nav>
    </header>
    <section class="welcome">

        <div class="swipe">
            <h1>Swipe Right®</h1>
            <div>
                <p class="create register">Create account</p>
            </div>
        </div>
    </section>
    <div id="login">
        <span class="closelogin">close</span>
        <h1>Login</h1>
        <form action="" method="post" id="loginForm">
            <input type="email" class="same" id='emaillogin' name="email" placeholder="example@gmail.com">
            <input type="password" class="same" name="psw" id="pswlogin" placeholder="*********">
            <div id="responseMessage" class="error" hidden></div>
            <input type="submit" name="login" value="Login" id="loginBtn">
        </form>
    </div>

    <div id="signIn">
        <span class="closeregister">close</span>
        <h1>Sign in</h1>
        <form action="" method="post" id="registerForm">

            <input class="same" type="text" name="firstname" placeholder="Firstname" id="firstname"><br>
            <input class="same" type="text" name="lastname" placeholder="Lastname" id="lastname"><br>
            <div class="infoBlock">
                <div class="label">
                    <label for="gender">Your gender </label>
                    <select name="gender" id="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="label">
                    <label for="attraction">You look for </label>
                    <select name="attraction" id="attraction">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="yourage">
                    <div class="label">
                        <label for="birthday">Your birthday</label>
                        <input class="same" type="date" name="birthday" placeholder="Birthday" id="birthday"><br>
                    </div>
                    <div id="ageVerif" class="error" hidden>Age must be bettween 18 - 70</div>
                </div>
            </div>
            <select name="city" id="city">
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
            <input class="same" type="email" name="email" placeholder="yourmail@gmail.com" id="email"><br>
            <input class="same" type="password" name="psw" placeholder="Password" id="password"><br>
            <div class="password-criteria error" hidden>
                <p class="length">Length between 8 to 50</p>
                <p class="numeric">At least 2 numbers</p>
                <p class="maj">At least 2 capital letters</p>
                <p class="min">At least 2 capital lowercase</p>
                <p class="chars">At least 2 capital special characters</p>
            </div>
            <input class="same" type="password" name="cPsw" placeholder="Confirme password" id="confPassword"><br>

            <div id="response" class="error" hidden></div>
            <input class="same" type="submit" name="register" value="register" id="registerBtn">
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>