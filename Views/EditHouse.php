<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main center">
    <div>
        <form action="owner" method="post">
            <h1>Accommodatie bewerken</h1>

            <label>Naam</label>
            <input type="text" name="title" />

            <label>Type</label>
            <select name="type">
                <option value="bungalow">Bungalow</option>
                <option value="vrijstaandhuis">Vrijstaand huis</option>
                <option value="tent">Tent</option>
                <option value="hotel">Hotel</option>
            </select>

            <label>Capaciteit</label>
            <input type="number" name="capacity" />

            <label>Land</label>
            <input type="text" name="country" />

            <label>Stad</label>
            <input type="text" name="city" />

            <label>Prijs per persoon per nacht</label>
            <input type="number" name="price" />

            <label>Beschrijving</label>
            <textarea name="description"></textarea>

            <button type="submit" name="edit" value="<?= $id ?>">Bewerken</button><br>

            <?= isset($message) ? $message : "" ?>
        </form>
    </div>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>