<?php include "Resources/Includes/header.inc.php"; ?>

<div class="main">
    <?= isset($message) ? $message : "" ?>

    <div class="block">
        <div class="block-header">
            Geuploade foto's voor deze accommodatie
        </div>
        <div class="block-main">
            <div class="accommodation-pictures">
                <?php
                if (count($pictures) > 0) {
                    foreach ($pictures as $picture) :
                ?>

                        <div class="accommodation-picture" style="background-image: url('<?= $picture["path"] ?>');">
                            <div class="picture-actions">
                                <form action="owner" method="post">
                                    <input type="hidden" name="house_id" value="<?= $picture["house_id"] ?>" />
                                    <button type="submit" name="delete_picture" value="<?= $picture["id"] ?>"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </div>

                <?php
                    endforeach;
                } else {
                    echo "Geen afbeeldingen gevonden.";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="block">
        <div class="block-header">
            Foto's uploaden
        </div>
        <div class="block-main">
            <form action="owner" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload[]" multiple />
                <button type="submit" name="pictures" value="<?= $id; ?>">Uploaden</button>
            </form>
        </div>
    </div>
</div>

<?php include "Resources/Includes/footer.inc.php"; ?>