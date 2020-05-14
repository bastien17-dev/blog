<?php
require_once __DIR__ . '/../config/bootstrap.php';

if(!isset($_SESSION['user'])) {
    addFlash('danger', 'il faut etre connecté pour accéder à cette page');
    session_write_close();
    header('Location: index.php');
    exit;
}

$page_title = 'Compte de ' . $_SESSION['user']['pseudo'];
include_once __DIR__ . '/../includes/header.php';

$user = getUserInfo($pdo, $_SESSION['user']['id']);
$billets = getBilletsInfos($pdo, $user['id_user']);
$billet = getBilletsInfos($pdo, $user['id_user']);

if(isset($_POST['addPost'])) {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    $newpost = addPost($pdo, $title, $content, $user['pseudo'], $user['id_user']);

    if($newpost === null) {
        addFlash('danger', 'Erreur lors de l\'ajout du post');
    } else {
        addFlash('success', 'Post publié :)');
        header('Location: index.php?blog=' . $user['id_user']);
    }
}

?>

    <h2 class="primary-title">Welcome on your dashboard <?= $user['pseudo'] ?></h2>
    <hr>

    <h4 class="secondary-title">Ajouter un poste</h4>
    <form class="mx-auto account__form" method="post" action="account.php">
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" class="form-control title" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea class="form-control content" id="content" name="content"></textarea>
        </div>
        <input type="submit" class="btn btn-primary post-submit" value="Publier" name="addPost" disabled>
    </form>
    <script src="<?= BASE_URL . 'public/scriptsJS/admin.js'?>"></script>

    <hr>
    <h4 class="secondary-title">Gestion des publications</h4>

    <?php if($billets === null) : ?>
        <p>Aucunes publications</p>
    <?php else : ?>
        <table class="table">
            <thead>
                <tr>
                   <th scope="col">Titre</th>
                   <th scope="col">Date de publication</th>
                    <th scope="col">Nombre de commentaires</th>
                   <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($billets as $billet) : ?>
                <tr>
                    <th scope="row"><?= $billet['title'] ?></th>
                    <td><?= (new DateTime($billet['date_creation']))->format('d F Y') ?></td>
                    <td><?= checkCommentsNumber($pdo, $billet['id_billet']) ?></td>
                    <td><a><button class="btn btn-info">Modifier</button></a></td>
                    <td>
                        <a href="comments.php?blog= <?= $_SESSION['user']['id'] ?> &billet= <?= $billet['id_billet'] ?>">
                            <button class="btn btn-info">Voir</button>
                        </a>
                    </td>
                </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php include __DIR__ . '/../includes/footer.php';
