<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main center">
    <form action="" method="post">
        <h1>Registreren</h1>
        <label>Gebruikersnaam</label>
        <input type="text" name="username" />
        <label>Wachtwoord</label>
        <input type="password" name="password" />
        <label>Rol</label>
        <select name="role">
            <option value="bezoeker">Bezoeker / huurder</option>
            <option value="verhuurder">Verhuurder</option>
        </select>
        <input type="submit" name="register" value="Inloggen" /><br>
        <?= isset($message) ? $message : "" ?>
    </form>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>