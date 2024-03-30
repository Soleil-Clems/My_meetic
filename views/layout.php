<?php $datas = json_encode($_SESSION['user']);?>
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
    <link rel="stylesheet" href="./css/style.css">

</head>

<body>
    <section id="mainSection">
        <header>
            <div><i class="fa-solid fa-gauge-high"></i> Boost</div>
            <div><i class="fa-solid fa-ghost"></i> Incognito</div>
            <div class="last"><i class="fa-solid fa-rocket"></i> Love note</div>
        </header>
        <aside>
            <div class="logo"><img src="./assets/logo.png" alt=""></div>
            <nav>
                <ul>
                    <li><a href="./"><i class="fa-regular fa-clone"></i> <span>Decouvrir</span></a></li>
                    <li><a href="./likes"><i class="fa-regular fa-heart"></i> <span>Likes</span></a></li>
                    <li><a href="./messages"><i class="fa-regular fa-comment"></i> <span>Messages</span></a></li>
                    <li><a href="profile"><i class="fa-regular fa-user"></i> <span>Profil</span></a></li>
                </ul>
            </nav>
        </aside>
        <main>
            <?= $content ?>

        </main>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>