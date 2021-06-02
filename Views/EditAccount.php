<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main center">
    <div>
        <form action="" method="post">
            <h1>Inloggegevens bewerken</h1>
            <label>Gebruikersnaam</label>
            <input type="text" name="username" />
            <label>Wachtwoord</label>
            <input type="password" name="password" />
            <label>Rol</label>
            <select name="role">
                <option value="bezoeker">Bezoeker / huurder</option>
                <option value="verhuurder">Verhuurder</option>
            </select>

            <input type="submit" name="editCredentials" value="Updaten" /><br>
            <?= isset($credentialsMessage) ? $credentialsMessage : "" ?>
        </form>

        <br><br>

        <form action="" method="post">
            <h1>Account bewerken</h1>
            <label>Volledige naam</label>
            <input type="text" name="name" value='<?= isset($userInfo["name"]) ? $userInfo["name"] : "" ?>' />
            <label>E-mail</label>
            <input type="email" name="email" value='<?= isset($userInfo["email"]) ? $userInfo["email"] : "" ?>' />
            <label>Telefoonnummer</label>
            <input type="text" name="phone" value='<?= isset($userInfo["phone"]) ? $userInfo["phone"] : "" ?>' />
            <label>Geboortedatum</label>
            <input type="date" name="birthday" value='<?= isset($userInfo["birthday"]) ? $userInfo["birthday"] : "" ?>' />
            <label>Land</label>
            <input type="text" name="country" value='<?= isset($userInfo["country"]) ? $userInfo["country"] : "" ?>' />
            <label>Woonplaats</label>
            <input type="text" name="city" value='<?= isset($userInfo["city"]) ? $userInfo["city"] : "" ?>' />
            <label>Straat</label>
            <input type="text" name="street" value='<?= isset($userInfo["street"]) ? $userInfo["street"] : "" ?>' />
            <label>Postcode</label>
            <input type="text" name="postal_code" value='<?= isset($userInfo["postal_code"]) ? $userInfo["postal_code"] : "" ?>' />

            <input type="submit" name="editInfo" value="Verzenden" /><br>
            <?= isset($accountMessage) ? $accountMessage : "" ?>
        </form>
    </div>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>