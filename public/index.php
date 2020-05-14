<?php

require_once __DIR__ . '/../config/bootstrap.php';

$ownerId = intval($_GET['blog'] ?? '');
$ownerInfos = getUserInfo($pdo, $ownerId);

$page_title = $ownerInfos['pseudo'] ?? 'Home';

include_once __DIR__ . '/../includes/header.php';

include_once __DIR__ . '/../includes/flashes.php';

if ($ownerInfos !== null) {
    $billets = getBilletsInfos($pdo, $ownerId);
        if($billets !== null) {
            foreach ($billets as $billet) : ?>
                <div class="mx-auto billet">
                    <div class="bg-secondary billet__header">
                        <h3><?= $billet['title'] ?><span
                                    style=" font-size: 1rem; font-style: italic">  by <?= $billet['autor'] ?></span></h3>
                        <p><?= (new DateTime($billet['date_creation']))->format('d F Y') ?></p>
                    </div>
                    <p class="bg-light billet__content"><?= $billet['content'] ?></p>
                    <div class="d-flex justify-content-between align-items-center bg-light billet__footer">
                        <div>
                            <span style="margin-right: 20px">Likes <?= $billet['likes'] ?></span>
                            <a href="<?= BASE_URL ?>public/comments.php?blog=<?= $ownerId ?>&amp;billet=<?= $billet['id_billet'] ?>">Commentaires <?= checkCommentsNumber($pdo, $billet['id_billet']) ?></a>
                        </div>
                        <div>
                            <a class="ml-auto"
                               href="<?= BASE_URL ?>public/writeComment.php?blog=<?= $ownerId ?>&amp;billet=<?= $billet['id_billet'] ?>">
                                <button class="btn btn-info ">Commenter</button>
                            </a>
                            <a class="ml-auto" href="<?= BASE_URL ?>public/addLike.php?billet=<?= $billet['id_billet'] ?>">
                                <button class="btn btn-info ">I like</button>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        } else {
            ?>
                <div class="mx-auto content__empty">
                    <p><?= $ownerInfos['pseudo'] . ' n\'a encore rien publier' ?></p>
                    <img src="assets/img/HugePossibleBarasingha-small.gif" alt="thumbleweed">
                </div>
            <?php
        }
} else {
    ?>
        <h1 class="mx-auto titre">Bienvenue sur BastBlogNet</h1>
    <?php
}
include __DIR__ . '/../includes/footer.php';

