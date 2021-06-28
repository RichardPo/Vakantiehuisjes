<?php

require "Models/House.php";
require "Models/User.php";

class OwnerController extends Controller
{
    private $house;
    private $user;

    public function __construct()
    {
        $this->house = new House();
        $this->user = new User();

        $user = $this->user->GetCurrentUser();

        if ($user != null) {
            if ($_POST) {
                if (isset($_POST["add"])) {
                    $this->AddHouse(
                        $_POST["title"],
                        $_POST["type"],
                        $_POST["capacity"],
                        $_POST["country"],
                        $_POST["city"],
                        $_POST["price"],
                        $_POST["description"]
                    );
                } else if (isset($_POST["edit"])) {
                    $this->EditHouse(
                        $_POST["edit"],
                        $_POST["title"],
                        $_POST["type"],
                        $_POST["capacity"],
                        $_POST["country"],
                        $_POST["city"],
                        $_POST["price"],
                        $_POST["description"]
                    );
                } else if (isset($_POST["pictures"])) {
                    $this->UploadPictures($_POST["pictures"]);
                } else if (isset($_POST["delete_picture"])) {
                    $this->DeletePicture($_POST["delete_picture"], $_POST["house_id"]);
                } else if (isset($_POST["delete"])) {
                    $this->DeleteHouse($_POST["delete"]);
                }
            } else {
                if (isset($_GET["add"])) {
                    $this->data["title"] = "Accommodatie toevoegen";
                    $this->view = "AddHouse.php";
                } else if (isset($_GET["edit"])) {
                    $this->data["title"] = "Accommodatie bewerken";
                    $this->view = "EditHouse.php";

                    $this->data["id"] = $_GET["id"];
                } else if (isset($_GET["pictures"])) {
                    $this->data["title"] = "Afbeeldingen";
                    $this->view = "HousePictures.php";

                    $this->data["pictures"] = $this->house->GetHouseFilesByHouseId($_GET["id"]);
                    $this->data["id"] = $_GET["id"];
                } else if (isset($_GET["delete"])) {
                    $this->data["title"] = "Accommodatie verwijderen";
                    $this->view = "DeleteHouse.php";

                    $this->data["id"] = $_GET["id"];
                } else {
                    $this->data["title"] = "Verhuurderspaneel";
                    $this->view = "Owner.php";

                    $accommodations = $this->house->GetAllByOwnerId($user["id"]);
                    $this->data["houses"] = $accommodations;

                    $files = [];
                    foreach ($accommodations as $accommodation) {
                        $files[$accommodation["id"]] = $this->house->GetHousePictureByHouseId($accommodation["id"]);
                    }
                    $this->data["files"] = $files;
                }
            }
        } else {
            header("Location: account");
        }

        $this->RenderView();
    }

    private function AddHouse($title, $type, $capacity, $country, $city, $price, $description)
    {
        $user = $this->user->GetCurrentUser();

        if ($user != null) {
            if ($this->house->CreateHouse($title, $type, $capacity, $price, $country, $city, $description, $user["id"])) {
                header("Location: owner");
            } else {
                $this->view = "AddHouse.php";
                $this->data["title"] = "Accommodatie toevoegen";
                $this->data["message"] = "Er ging iets mis. Probeer het nog een keer.";
            }
        } else {
            header("Location: account");
        }
    }

    private function EditHouse($id, $title, $type, $capacity, $country, $city, $price, $description)
    {
        $user = $this->user->GetCurrentUser();

        if ($user != null) {
            $foundHouse = $this->house->GetHouseById($id);

            if ($foundHouse != null) {
                if ($foundHouse["user_id"] == $user["id"]) {
                    if ($this->house->EditHouse($id, $title, $type, $capacity, $price, $country, $city, $description)) {
                        header("Location: owner");
                    } else {
                        $this->view = "EditHouse.php";
                        $this->data["title"] = "Accommodatie toevoegen";
                        $this->data["message"] = "Er ging iets mis. Probeer het nog een keer.";
                    }
                } else {
                    $this->view = "EditHouse.php";
                    $this->data["title"] = "Accommodatie toevoegen";
                    $this->data["message"] = "Je kunt geen accommodaties bewerken van een ander!";
                }
            } else {
                $this->view = "EditHouse.php";
                $this->data["title"] = "Accommodatie toevoegen";
                $this->data["message"] = "Er ging iets mis. Probeer het nog een keer.";
            }
        } else {
            header("Location: account");
        }
    }

    private function DeleteHouse($id)
    {
        $user = $this->user->GetCurrentUser();

        if ($user != null) {
            $foundHouse = $this->house->GetHouseById($id);

            if ($foundHouse != null) {
                if ($foundHouse["user_id"] == $user["id"]) {
                    if ($this->house->DeleteHouse($id)) {
                        header("Location: owner");
                    } else {
                        $this->view = "DeleteHouse.php";
                        $this->data["title"] = "Accommodatie verwijderen";
                        $this->data["message"] = "Er ging iets mis. Probeer het nog een keer.";
                    }
                } else {
                    $this->view = "DeleteHouse.php";
                    $this->data["title"] = "Accommodatie verwijderen";
                    $this->data["message"] = "Je kunt geen accommodaties van anderen verwijderen.";
                }
            } else {
                $this->view = "DeleteHouse.php";
                $this->data["title"] = "Accommodatie verwijderen";
                $this->data["message"] = "Er ging iets mis. Probeer het nog een keer.";
            }
        } else {
            header("Location: account");
        }
    }

    private function UploadPictures($id)
    {
        $user = $this->user->GetCurrentUser();

        if ($user != null) {
            $foundHouse = $this->house->GetHouseById($id);

            if ($foundHouse != null) {
                if ($foundHouse["user_id"] != $user["id"]) {
                    $this->view = "Error.php";
                    $this->data["title"] = "Fout opgetreden";

                    $this->data["message"] = "Je kan geen bestanden uploaden voor accommodaties van anderen.";

                    return;
                }
            } else {
                $this->view = "Error.php";
                $this->data["title"] = "Fout opgetreden";

                $this->data["message"] = "Je kan geen bestanden uploaden voor accommodaties die niet bestaan.";

                return;
            }
        } else {
            header("Location: account");

            return;
        }

        $fileCount = count($_FILES["fileToUpload"]["name"]);

        if ($fileCount > 0) {
            $target_dir = "static/";

            for ($i = 0; $i < $fileCount; $i++) {
                $target_file = $target_dir . basename("/" . uniqid("accommodation_picture_") . "." . strtolower(pathinfo($_FILES["fileToUpload"]["name"][$i], PATHINFO_EXTENSION)));
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 500000) {
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if (
                    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif"
                ) {
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $this->view = "Error.php";
                    $this->data["title"] = "Fout opgetreden";

                    $this->data["message"] = "Het bestand kon niet geupload worden.";
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                        $this->house->AddHouseFile($id, $target_file, "IMG");

                        header("Location: owner");
                    } else {
                    }
                }
            }
        }
    }

    private function DeletePicture($id, $houseId)
    {
        $user = $this->user->GetCurrentUser();

        if ($user != null) {
            $foundHouse = $this->house->GetHouseById($houseId);

            if ($foundHouse != null) {
                if ($foundHouse["user_id"] != $user["id"]) {
                    $this->view = "Error.php";
                    $this->data["title"] = "Fout opgetreden";

                    $this->data["message"] = "Je kan geen bestanden verwijderen voor accommodaties van anderen.";

                    return;
                }
            } else {
                $this->view = "Error.php";
                $this->data["title"] = "Fout opgetreden";

                $this->data["message"] = "Je kan geen bestanden verwijderen voor accommodaties die niet bestaan.";

                return;
            }
        } else {
            header("Location: account");

            return;
        }

        $file = $this->house->GetHouseFileByFileId($id);
        if ($file != null) {
            $path = $file["path"];
            if (unlink($path)) {
                $this->house->DeleteHouseFile($id);

                header("Location: owner");
            } else {
                $this->view = "Error.php";
                $this->data["title"] = "Fout opgetreden";

                $this->data["message"] = "Het bestand kon niet worden verwijderd.";
            }
        } else {
            $this->view = "Error.php";
            $this->data["title"] = "Fout opgetreden";

            $this->data["message"] = "Dit bestand bestaat niet.";
        }
    }
}
