<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- home made css -->
        <link rel="stylesheet" href="<?= BASE_URL . 'public/css/style.css' ?>"
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title><?= $page_title ?? '' ?> | BastBlogNet</title>
    </head>
    <body>
        <header class="header">
            <nav class="navbar navbar-dark bg-dark d-flex justify-content-between ">

                <div class="d-flex align-items-center">
                    <a class="navbar-brand header-link" href="<?= BASE_URL ?>public/index.php">Home</a>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <a class="navbar-brand header-link" href="<?= BASE_URL ?>public/account.php">Dashboard de <?= $_SESSION['user']['pseudo'] ?></a>
                        <a class="navbar-brand header-link" href="<?= BASE_URL ?>public/logout.php">Déconnexion</a>
                    <?php else: ?>
                        <a class="navbar-brand header-link" href="<?= BASE_URL ?>public/login.php">Connexion</a>
                        <a class="navbar-brand header-link" href="<?= BASE_URL ?>public/createAccount.php">Créer un compte</a>
                    <?php endif; ?>
                </div>

                <?php if (isset($ownerInfos) && $ownerInfos !== null) : ?>
                    <a href="<?= BASE_URL . 'public/index.php?blog=' . $ownerInfos['id_user'] ?>"  class="navbar-brand">Blog de <?= $ownerInfos['pseudo'] ?></a>
                <?php endif ; ?>

                <div class="d-flex align-items-center" >
                    <div class="search-area" >
                        <input type="text" placeholder="Rechercher un blog par auteur" class="border border-dark search">
                        <ul class="list bg-light search-list"></ul>
                    </div>
                </div>
            </nav>
            <script src="<?= BASE_URL . 'public/scriptsJS/search.js' ?>"></script>
        </header>
        <main>
