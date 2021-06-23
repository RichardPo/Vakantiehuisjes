<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main">
    <div class="block">
        <div class="block-header">
            Mijn accommodaties
        </div>
        <div class="block-main">
            <div class="houses">
                <?php
                if (count($houses) == 0) {
                    echo "Geen accomodaties gevonden";
                }

                foreach ($houses as $house) :
                ?>
                    <div class="house" style="background-image: url(<?= $files[$house['id']] ?>);">
                        <div class="house-title"><?= $house["title"]; ?></div>
                        <div class="house-actions center">
                            <div class="edit" onclick="window.location = 'owner?edit_id=<?= $house['id'] ?>'"><i class="fas fa-edit"></i></div>
                            <div class="delete" onclick="window.location = 'owner?delete_id=<?= $house['id'] ?>'"><i class="fas fa-trash-alt"></i></div>
                        </div>
                        <button class="house-button">Bekijken &#10095;</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <form>
                <button type="submit" name="add" value="true">Accommodatie toevoegen</button>
            </form>
        </div>
    </div>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>