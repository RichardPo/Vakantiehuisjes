<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main">

    <?php

    if (isset($message)) {
        echo "Er is een fout opgetreden: " . $message;
    } else {
        header("Location: home");
    }

    ?>

</div>

<?php include "Resources/Includes/footer.inc.php"; ?>