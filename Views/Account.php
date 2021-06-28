<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main">
    <div class="block">
        <div class="block-header">Mijn informatie</div>
        <div class="block-main">
            Naam: <?= isset($userInfo["name"]) ? $userInfo["name"] : "-" ?><br>
            E-mail: <?= isset($userInfo["email"]) ? $userInfo["email"] : "-" ?><br>
            Telefoonnummer: <?= isset($userInfo["phone"]) ? $userInfo["phone"] : "-" ?><br>
            Geboortedatum: <?= isset($userInfo["birthday"]) ? $userInfo["birthday"] : "-" ?><br>
            Land: <?= isset($userInfo["country"]) ? $userInfo["country"] : "-" ?><br>
            Woonplaats: <?= isset($userInfo["city"]) ? $userInfo["city"] : "-" ?><br>
            Straat: <?= isset($userInfo["street"]) ? $userInfo["street"] : "-" ?><br>
            Postcode: <?= isset($userInfo["postal_code"]) ? $userInfo["postal_code"] : "-" ?><br>
            <form>
                <button type="submit" name="edit" value="true">Account bewerken</button>
            </form>

            <?php
            if ($role == "verhuurder") :
            ?>
                <form action="owner">
                    <button type="submit">Mijn verhuurderspaneel</button>
                </form>
            <?php endif; ?>

            <form>
                <button type="submit" name="logout" value="true">Uitloggen</button>
            </form>
        </div>
    </div>

    <div class="block">
        <div class="block-header">Mijn recensies</div>
        <div class="block-main">
            <?php
            if (count($reviews) == 0) {
                echo "Je hebt nog geen recensies gegeven.";
            }

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

            <?php endforeach; ?>
        </div>
    </div>

    <div class="block">
        <div class="block-header">Mijn bookingen</div>
        <div class="block-main">
            <?php
            if (count($bookings) == 0) {
                echo "Je hebt nog geen accommodaties gebookt.";
            }

            foreach ($bookings as $booking) :
            ?>

                <div class="booking">
                    <div class="booking-title">
                        <?= $booking["title"]; ?>
                    </div>
                    <div class="booking-main">
                        <i class="fas fa-info-circle"></i> <?= $booking["status"] ?><br>
                        <?= $booking["start_date"] . " tot " . $booking["end_date"] ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>