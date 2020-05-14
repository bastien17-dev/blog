<?php

require_once __DIR__ . '/../config/bootstrap.php';

// header
$page_title = 'Connexion';
require_once __DIR__ . '/../includes/header.php';

if (isset($_POST['login'])){
    $enteredPseudo = htmlspecialchars($_POST['pseudo']);
    $enteredPass = htmlspecialchars($_POST['pass']);

    $user = getuserbyPseudo($pdo, $enteredPseudo);

    if($user === null) {
        addFlash('danger', 'Pseudo inconnu');
    } elseif(!password_verify($enteredPass, $user['password'])){
        addFlash('danger', 'mot de passe incorrect');
    } else {
        $_SESSION['user']=[
                "id" => $user['id_user'],
                "pseudo" => $user['pseudo']
        ];

        session_write_close();
        header('Location: account.php');
    }
}
?>

<form method="post" action="login.php" style="width: 50%" class="mx-auto">
    <?php include_once __DIR__ . '/../includes/flashes.php';  ?>
    <div class="form-group">
        <label for="pseudo">Pseudo</label>
        <input type="text" id="pseudo" name="pseudo" class="form-control pseudo" value="<?= $_POST['pseudo'] ?? '' ?>">
    </div>
    <div class="form-group">
        <label for="pass">Mot de passe</label>
        <input type="password" id="pass" name="pass" class="form-control pass">
    </div>
    <input type="submit" class="btn btn-primary connection-submit" name="login" disabled>
</form>
    <script src="<?= BASE_URL . 'public/scriptsJS/connection.js' ?>" ></script>

<?php
//get footer
include __DIR__ . '/../includes/footer.php';
