<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main center">
    <div class="block">
        <div class="block-header center">
            Weet je zeker dat je deze accommodatie wilt verwijderen?
        </div>
        <div class="block-main">
            <form method="post" action="owner" class="center">
                <button type="submit" class="delete-btn" name="delete_id" value="<?= $id ?>">Ja</button>
                <?= isset($message) ? $message : "" ?>
            </form>
        </div>
    </div>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>