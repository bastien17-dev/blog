<?php

require_once __DIR__ . '/../config/bootstrap.php';

// header
$page_title = 'Créer un compte';
require_once __DIR__ . '/../includes/header.php';

if (isset($_POST['register']) ){
    $enteredPseudo = htmlspecialchars($_POST['pseudo']);
    $enteredPass = htmlspecialchars($_POST['pass']);

    if(getuserbyPseudo($pdo, $enteredPseudo)) {
        addFlash('danger', 'Pseudo dejà utilisé');
    } else {
         $user = insertnewUser($pdo, $enteredPseudo,$enteredPass);

         if($user === null) {
             addFlash('danger', 'Un problème est survenue lors de l\'inscription');
         } else {
             addFlash('success', 'Vous avez été inscrit ! Vous pouvez vous connecter');
             session_write_close();
             header('Location: login.php');
         }
    }

}

?>

<form method="post" action="createAccount.php" style="width: 50%; margin-top: 40px" class="mx-auto">
    <?php
    include __DIR__ . '/../includes/flashes.php';
    ?>
    <div class="form-group">
        <label for="pseudo">Pseudo</label>
        <input type="text" id="pseudo" name="pseudo" class="form-control pseudo" value="<?= $_POST['pseudo'] ?? '' ?>">
    </div>
    <div class="form-group">
        <label for="pass">Mot de passe</label>
        <input type="password" id="pass" name="pass" class="form-control pass">
    </div>
    <div class="form-group">
        <label for="passConfirm">Confirmer mot de passe</label>
        <input type="password" id="passConfirm" class="form-control passConfirm">
        <div class="alert text-danger" style="display: none; padding: 0; width: 200%">Les deux mots de passes doivent être identiques</div>
    </div>
    <input type="submit" class="btn btn-primary submit" name="register" disabled>

</form>
    <script src="<?= BASE_URL . 'public/scriptsJS/createAccount.js' ?>"></script>

<?php
//get footer
include __DIR__ . '/../includes/footer.php';