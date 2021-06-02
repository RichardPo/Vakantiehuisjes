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
            <a href="accommodation?id=<?= $house['id'] ?>">
                <div class="house">
                    <div class="picture" style="background-image: url(https://static.ferienhausmiete.de/pictures/132225/bilder_original/132225_47046835491551.jpg);"></div>
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
            </a>
        <?php endforeach; ?>
    </div>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>