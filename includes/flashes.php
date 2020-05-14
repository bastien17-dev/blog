<?php foreach (getFlashes() as $flash) :
    ?>

        <div class="mx-auto alert alert-<?=$flash["type"]?> flash" style="margin-top: 20px">
            <?= $flash["message"] ?>
        </div>

<?php endforeach; ?>
