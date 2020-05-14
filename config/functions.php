<?php

function getAllUsers (PDO $pdo): ?array {
    $req = $pdo->prepare('SELECT * from Users');
    $req->execute();
    return $req->fetchAll() ?: null;
}

function getUserInfo (PDO $pdo, int $id): ?array {
    $req = $pdo->prepare('SELECT * FROM users where id_user = :id');
    $req->execute([
        "id" => $id
    ]);
    return $req->fetch() ?: null;
}

function insertnewUser (PDO $pdo, $pseudo, $password): ?array {
    $req = $pdo->prepare('INSERT INTO users (pseudo, password) VALUES (:pseudo, :pass)');
    $req->execute([
        "pseudo" => $pseudo,
        "pass" => password_hash($password, PASSWORD_DEFAULT)
    ]);

    return getuserbyPseudo($pdo, $pseudo);
}

function getuserbyPseudo (PDO $pdo, string $pseudo): ?array {
    $req = $pdo->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
    $req->execute(["pseudo" => $pseudo]);
    return $req->fetch() ?: null;
}

function getBilletsInfos (PDO $pdo, int $id_user): ?array {
    $req = $pdo->prepare('SELECT * FROM billets where id_autor = :id ORDER BY id_billet DESC ');
    $req->execute([
        "id" => $id_user
    ]);
    return $req->fetchAll() ?: null;
}

function getSingleBilletInfos (PDO $pdo, int $id_billet): ?array {
    $req = $pdo->prepare('SELECT *, DATE_FORMAT(date_creation, "%d %b %Y") AS date FROM billets where id_billet = :id');
    $req->execute([
        "id" => $id_billet
    ]);
    return $req->fetch() ?: null;
}

//check comments number

function checkCommentsNumber(PDO $pdo, int $id_billet):int {
    $req = $pdo->prepare('SELECT count(*) AS nb_comments FROM comments WHERE id_billet = :id_billet');
    $req->execute(["id_billet" => $id_billet]);
    $nbComments = $req->fetch();

    return $nbComments['nb_comments'];
}

function getComments (PDO $pdo, int $id_billet): ?array {
    $req = $pdo->prepare('SELECT * FROM comments where id_billet = :id');
    $req->execute([
        "id" => $id_billet
    ]);
    return $req->fetchAll() ?: null;
}

// add new post

function addPost (PDO $pdo, string $title, string $content, string $pseudo, int $id): ?array{
    $req = $pdo->prepare('INSERT INTO billets 
                            (title, content, date_creation, autor, id_autor) 
                            VALUES (:title, :content, NOW(), :autor, :id_autor)');

    $req->execute([
        "title" => $title,
        "content" => $content,
        "autor" => $pseudo,
        "id_autor" => $id
    ]);

    $idPost = $pdo->lastInsertId();

    return getSingleBilletInfos($pdo, $idPost);
}

//add a like on a comment

function addALike (PDO $pdo, int $id):void {
    $getlikesnumber = $pdo->prepare('SELECT likes FROM billets WHERE id_billet = :id');
    $getlikesnumber->execute(['id' => $id]);
    $reponse = $getlikesnumber->fetch();

    $previousLikes = $reponse['likes'];
    $updatedLikes = $previousLikes + 1;

    $setLikes = $pdo->prepare('UPDATE billets SET likes = :likes WHERE id_billet = :id');
    $setLikes->execute([
        "likes" => $updatedLikes,
        "id" => $id
    ]);
}

//search User for autocompletion
function autocompletionSearch(PDO $pdo, string $subString): ?array {
    $allusers = getAllUsers($pdo);
    if($allusers === null) {
        return null;
    } else {
        foreach($allusers as $user) {
            if(stripos($user["pseudo"], $subString) !== false) {
                $selection[] = $user;
            }
        }
        return $selection;
    }
};

// Ajouter un message Flash
function addFlash (string $type, string $message):void{
    $_SESSION['flashes'][] = [
        'type' => $type,
        'message' => $message,
    ];
}

//Récupere les messages flash
function getFlashes ():array{
    $flashes = $_SESSION['flashes'] ?? [];
    unset($_SESSION['flashes']);
    return $flashes;
}

//générer une chaine aléatoire

function genererChaineAleatoire($longueur, $listeCar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $chaine = '';
    $max = mb_strlen($listeCar, '8bit') - 1;
    for ($i = 0; $i < $longueur; ++$i) {
        $chaine .= $listeCar[random_int(0, $max)];
    }
    return $chaine;
}

//Ajouter un commentaire
function addComment (PDO $pdo,int $id_billet, string $pseudo, string $content): ?int {
    $req = $pdo->prepare('INSERT INTO comments 
                        (id_billet, autor, content, date_comment) 
                        VALUES (:idBillet, :autor, :content, NOW())');

    $req->execute([
        'idBillet' => $id_billet,
        'autor' => $pseudo,
        'content' => $content
    ]);

    return $pdo->lastInsertId() ?: null;
}
