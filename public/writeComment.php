<?php

require_once __DIR__ . '/../config/bootstrap.php';

$ownerId = intval($_GET['blog'] ?? '');
$billetId = intval($_GET['billet'] ?? '');

if(isset($_GET['blog']) && isset($_GET['billet'])) {
    $_SESSION['billets-infos'] = [
        "idBillet" => $_GET['billet'],
        "idOwner" => $_GET['blog']
    ];
}
//get header
$page_title = 'Rédiger un commentaire';
$ownerInfos = getUserInfo($pdo, $ownerId);
require_once __DIR__ . '/../includes/header.php';

//get billet infos
$billetInfo = getSingleBilletInfos($pdo, $billetId);


if (isset($_POST['pseudo']) && isset($_POST['content'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $content = htmlspecialchars($_POST['content']);

    $idComment = addComment($pdo, $_SESSION["billets-infos"]['idBillet'], $pseudo, $content);

    if($idComment === null) {
        addFlash('danger', 'Erreur lors de l\'ajout du comentaire');
    } else {
        addFlash('success', 'Commentaire ajouté');
        session_write_close();
        header('Location: comments.php?blog=' . $_SESSION['billets-infos']['idOwner'] . '&billet=' . $_SESSION['billets-infos']['idBillet']);
        exit;
    }
}
//CONTENT

if($ownerInfos !== null) {
    ?>
    <div class="mx-auto" style="width: 70%; margin-top: 40px">

    <div class="bg-secondary" style=" padding: 10px 30px; display: flex; justify-content: space-between; color: white">
        <h3 style="margin-bottom: 0"><?= $billetInfo['title'] ?><span
                    style=" font-size: 1rem; font-style: italic">  by <?= $billetInfo['autor'] ?></span></h3>
        <p style="margin-bottom: 0; padding-top: 10px"><?= $billetInfo['date'] ?></p>
    </div>
    <p class="bg-light" style="padding: 30px; margin-bottom: 0"><?= $billetInfo['content'] ?></p>

    <hr>
    <h5>Rédiger un commentaire</h5>

    <form class="mx-auto" method="post" action="writeComment.php" style="margin-top: 40px">
        <div class="form-group">
            <label for="pseudo">Pseudo</label>
            <input type="text" class="form-control pseudo" id="title" name="pseudo" style="width: 30%">
        </div>
        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea class="form-control content" id="content" name="content"></textarea>
        </div>
        <input type="submit" class="btn btn-primary comment-submit" value="Publier le commentaire" disabled>
    </form>
    <script src="<?= BASE_URL . 'public/scriptsJS/writeComment.js' ?>"></script>

    <?php
} else {
    addFlash('danger', 'Erreur lors du chargement du billet');
    header('Location: index.php');
}


 include __DIR__ . '/../includes/footer.php';