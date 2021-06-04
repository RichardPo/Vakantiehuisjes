<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main">
    <div class="accommodation-title"><?= $house["title"]; ?></div>

    <?php
    if (count($files) > 0) :
    ?>
        <div class="slideshow-container">
            <?php
            foreach ($files as $file) :
            ?>

                <div class="mySlides fade">
                    <div class="img" style="background-image: url(<?= $file['path'] ?>);"></div>
                </div>

            <?php
            endforeach;
            ?>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <div style="text-align:center">
            <?php
            for ($i = 0; $i < count($files); $i++) :
            ?>

                <span class="dot" onclick="currentSlide(<?= $i + 1 ?>)"></span>

            <?php endfor; ?>
        </div>

    <?php endif; ?>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>