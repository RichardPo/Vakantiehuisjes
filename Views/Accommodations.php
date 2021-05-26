<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main">
    <h1>Accomodaties</h1>
    <div class="houses">
        <?php
        if (count($houses) == 0) {
            echo "Geen accomodaties gevonden";
        }

        foreach ($houses as $house) :
        ?>
            <div class="house">
                <div class="picture"></div>
                <div class="text">
                    <div class="house-header">
                        <div class="house-title"><?= $house["title"]; ?></div>
                        <div class="house-info">
                            € <?= $house["price"]; ?> p.p.p.n.
                            <span class="house-persons"><i class="fas fa-user"></i> <?= $house["capacity"] ?></span>
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
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>