<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main center">
    <form action="" method="post">
        <h1>Inloggen</h1>
        <label>Gebruikersnaam</label>
        <input type="text" name="username" />
        <label>Wachtwoord</label>
        <input type="password" name="password" />
        <input type="submit" name="login" value="Inloggen" /><br>
        <?= isset($message) ? $message : "" ?>
    </form>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>