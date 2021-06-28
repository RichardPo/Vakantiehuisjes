<?php include "Resources/Includes/header_home.inc.php"; ?>

<div class="main home">
    <?php
    if (count($popularHouses) == 3) :
    ?>
        <div class="featured-houses">
            <div class="featured-house" style="background-image: url('<?= $popularHouses[0]['picture'] ?>');">
                <div class="f-title">
                    <?= $popularHouses[0]["title"] ?> (aanbevolen)
                </div>

                <button class="f-button" onclick="window.location = 'accommodation?id=<?= $popularHouses[0]['id'] ?>';">Bekijken &#10095;</button>
            </div>

            <div class="featured-house" style="background-image: url('<?= $popularHouses[1]['picture'] ?>');">
                <div class="f-title">
                    <?= $popularHouses[1]["title"] ?> (aanbevolen)
                </div>

                <button class="f-button" onclick="window.location = 'accommodation?id=<?= $popularHouses[1]['id'] ?>';">Bekijken &#10095;</button>
            </div>

            <div class="featured-house" style="background-image: url('<?= $popularHouses[2]['picture'] ?>');">
                <div class="f-title">
                    <?= $popularHouses[2]["title"] ?> (aanbevolen)
                </div>

                <button class="f-button" onclick="window.location = 'accommodation?id=<?= $popularHouses[2]['id'] ?>';">Bekijken &#10095;</button>
            </div>
        </div>

    <?php endif; ?>

    <div class="block">
        <div class="block-header">
            Welkom!
        </div>
        <div class="block-main">
            Zoek hier de perfecte accommodatie voor je vakantie:<br>
            <form action="search" method="get">
                <input type="text" name="accommodation_name" placeholder="Naam van accommodatie..." />
                <input type="submit" value="Zoeken" />
            </form>
        </div>
    </div>

    <div class="block">
        <div class="block-header">
            Of zoek met filters
        </div>
        <div class="block-main">
            <form action="search" method="get">
                <label>Wanneer ga je?</label>
                <input type="date" name="startDate" />

                <label>Tot wanneer?</label>
                <input type="date" name="endDate" />
                <label>En met hoeveel personen?</label>

                <input type="number" name="amount" />
                <input type="submit" value="Zoeken" />
            </form>
        </div>
    </div>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>