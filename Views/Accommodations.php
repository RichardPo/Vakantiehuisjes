<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main">
    <div class="houses">
        <?php
        if (count($houses) == 0) {
            echo "Geen accomodaties gevonden";
        }

        foreach ($houses as $house) :
        ?>
            <div class="house" style="background-image: url(<?= $files[$house['id']] ?>);">
                <div class="text">
                    <div class="house-title"><?= $house["title"]; ?></div>
                    <button class="house-button" onclick="window.location = 'accommodation?id=<?= $house['id'] ?>';">Bekijken &#10095;</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>