<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main">
    <div class="block">
        <div class="block-header">
            Welkom!
        </div>
        <div class="block-main">
            Zoek hier de perfecte accomodatie voor je vakantie:<br>
            <form>
                <input type="text" name="accomodation_name" placeholder="Naam van accomodatie..."/>
                <input type="submit" value="Zoeken"/>
            </form>
        </div>
    </div>

    <div class="block black">
        <div class="block-header">
            Of zoek met filters
        </div>
        <div class="block-main">
            <form>
                <label>Wanneer ga je?</label>
                <input type="date" name="date"/>
                <label>En met hoeveel personen?</label>
                <input type="number" name="amount"/>
                <input type="submit" value="Zoeken"/>
            </form>
        </div>
    </div>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>