<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main">
    <form action="" method="post">
        <input type="text" name="username" />
        <input type="password" name="password" />
        <input type="submit" name="login" value="Inloggen" />
    </form>
    <?= isset($message) ? $message : "" ?>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>