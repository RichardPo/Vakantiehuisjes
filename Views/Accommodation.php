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

    <div class="block">
        <div class="block-header">
            Beschrijving
        </div>
        <div class="block-main">
            <?= $house["description"]; ?>
        </div>
    </div>

    <div class="block">
        <div class="block-header">
            Details
        </div>
        <div class="block-main">
            Type: <?= $house["type"]; ?><br>
            Aantal personen: <?= $house["capacity"]; ?><br>
            P.p.p.n.: € <?= $house["price"]; ?><br>
            Land: <?= $house["country"]; ?><br>
            Stad: <?= $house["city"]; ?>
        </div>
    </div>

    <div class="block">
        <div class="block-header">
            Accommodatie boeken?
        </div>
        <div class="block-main">
            <form method="POST">
                <label>Aantal personen</label>
                <input type="number" name="numberOfPersons" />

                <label>Van (datum)</label>
                <input type="date" name="fromDate" />

                <label>Tot (datum)</label>
                <input type="date" name="toDate" />

                <label>Opmerkingen</label>
                <textarea name="remarks"></textarea>

                <input type="submit" name="book" value="Boeken" /><br>

                <?= empty($bookingMessage) ? "" : $bookingMessage ?>
            </form>
        </div>
    </div>

    <div class="block">
        <div class="block-header">
            Schrijf een review
        </div>
        <div class="block-main">
            <form method="POST">
                <label>Titel</label>
                <input type="text" name="title" />

                <label>Rating (1-5)</label>
                <input type="number" name="rating" min="1" max="5" />

                <label>Review</label>
                <textarea name="main"></textarea>

                <input type="submit" name="review" value="Posten" /><br>

                <?= empty($reviewMessage) ? "" : $reviewMessage ?>
            </form>
        </div>
    </div>

    <div class="block">
        <div class="block-header">
            Reviews
        </div>
        <div class="block-main reviews">
            <?php
            if (count($reviews) <= 0) {
                echo "Deze accommodatie heeft nog geen reviews.";
            } else {
                foreach ($reviews as $review) :
            ?>

                    <div class="review">
                        <div class="review-title">
                            <?= $review["title"]; ?>
                        </div>
                        <div class="review-main">
                            <i class="fas fa-star"></i> <?= $review["rating"]; ?><br>
                            <?= $review["review"] ?>
                        </div>
                    </div>

            <?php
                endforeach;
            }
            ?>
        </div>
    </div>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>