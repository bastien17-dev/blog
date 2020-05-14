<?php

require __DIR__ . '/../config/bootstrap.php';

if (isset($_GET['billet'])){
    $billetId = $_GET['billet'];
    $billetInfos = getSingleBilletInfos($pdo, $billetId);


    addALike($pdo, $billetId);
    header('Location: index.php?blog=' . $billetInfos['id_autor']);
} else {
    header('Location: index.php' );
}


