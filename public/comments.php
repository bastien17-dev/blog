<?php

require_once __DIR__ . '/../config/bootstrap.php';

$ownerId = intval($_GET['blog'] ?? '');
$billetId = intval($_GET['billet'] ?? '');

$billetInfo = getSingleBilletInfos($pdo, $billetId);
$comments = getComments($pdo, $billetId);
$ownerInfos = getUserInfo($pdo, $ownerId);

//header
$page_title = 'Commentaires';
require_once __DIR__ . '/../includes/header.php';

if($billetInfo === null || $ownerInfos === null) {
    addFlash('danger', 'Erreur de chargement');
    header('Location: index.php');

} else {
    ?>
        <div class="mx-auto comment">
            <div class="bg-secondary comment__billet">
                <p><?= $billetInfo['date'] ?></p>
                <h3><?=$billetInfo['title'] ?><span>  by <?= $billetInfo['autor']?></span></h3>
            </div>
            <p class="bg-light comment__billet-content"><?= $billetInfo['content'] ?></p>
        <?php
        include_once __DIR__ . '/../includes/flashes.php';
        if ($comments === null) : ?>
            <hr>
            <div class="content__empty">
                <p>Aucuns commentaires</p>
                <img src="assets/img/HugePossibleBarasingha-small.gif" alt="thumbleweed">
            </div>
         <?php else :
            foreach ($comments as $comment) : ?>
                <hr>
                <div>
                    <div>
                        <span class="comment__autor"><?= $comment['autor'] ?></span>
                        <span class="comment__infos">le <?= (new DateTime($comment['date_comment']))->format('d F Y à H:i:s') ?></span>
                    </div>
                    <p class="comment__content"><?= $comment['content'] ?></p>
                </div>
        <?php endforeach;
        endif; ?>
        </div>
<?php
}

include __DIR__ . '/../includes/footer.php';



