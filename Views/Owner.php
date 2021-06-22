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
                    <div class="house">
                        <div class="picture" style="background-image: url(<?= $files[$house['id']] ?>);" onclick="window.location = 'accommodation?id=<?= $house['id'] ?>';"></div>
                        <div class="text">
                            <div class="house-header">
                                <div class="house-title"><?= $house["title"]; ?></div>
                                <div class="house-info">
                                    <div class="house-actions">
                                        <i class="fas fa-edit edit" onclick="window.location = 'owner?edit_id=<?= $house['id'] ?>';"></i>
                                        <i class="fas fa-trash-alt delete" onclick="window.location = 'owner?delete_id=<?= $house['id'] ?>';"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="house-main">
                                <div class="house-description">
                                    <?= $house["description"]; ?>
                                </div>
                            </div>
                        </div>
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