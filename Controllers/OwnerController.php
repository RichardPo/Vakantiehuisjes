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
        if ($user) {
            if (isset($_GET["add"])) {
                $this->ShowCreatePanel();
            } else if (isset($_GET["edit_id"])) {
                $this->ShowEditPanel();
            } else if (isset($_GET["delete_id"])) {
                $this->ShowDeletePanel();
            } else if (isset($_POST["add"])) {
                $this->CreateHouse($user);
            } else if (isset($_POST["edit_id"])) {
                $this->EditHouse($_POST["edit_id"], $user);
            } else if (isset($_POST["delete_id"])) {
                $this->DeleteHouse($_POST["delete_id"], $user);
            } else {
                $this->ShowPanel($user);
            }

            $this->RenderView();
        } else {
            header("Location: account");
        }
    }

    private function ShowPanel($user)
    {
        $this->data["title"] = "Verhuurderspaneel";

        $accommodations = $this->house->GetAllByOwnerId($user["id"]);
        $this->data["houses"] = $accommodations;

        $files = [];
        foreach ($accommodations as $accommodation) {
            $files[$accommodation["id"]] = $this->house->GetHousePictureByHouseId($accommodation["id"]);
        }
        $this->data["files"] = $files;

        $this->view = "Owner.php";
    }

    private function ShowCreatePanel()
    {
        $this->view = "AddHouse.php";
        $this->data["title"] = "Toevoegen";
    }

    private function ShowEditPanel()
    {
        $this->view = "EditHouse.php";
        $this->data["title"] = "Bewerken";
        $this->data["id"] = $_GET["edit_id"];
    }

    private function ShowDeletePanel()
    {
        $this->view = "DeleteHouse.php";
        $this->data["title"] = "Verwijderen";
        $this->data["id"] = $_GET["delete_id"];
    }

    private function CreateHouse($user)
    {
        $title = $_POST["title"];
        $type = $_POST["type"];
        $capacity = $_POST["capacity"];
        $price = $_POST["price"];
        $country = $_POST["country"];
        $city = $_POST["city"];
        $description = $_POST["description"];

        $insertedHouseId = $this->house->CreateHouse($title, $type, $capacity, $price, $country, $city, $description, $user["id"]);

        if ($insertedHouseId != false) {
            $this->UploadHousePictures($insertedHouseId);

            header("Location: owner");
        } else {
            $this->view = "AddHouse.php";
            $this->data["message"] = "Er ging iets mis bij het aanmaken van de accommodatie. Zorg dat alle velden ingevuld zijn en probeer het nog een keer.";
            $this->data["message"] = $this->house->GetError();
        }
    }

    private function EditHouse($id, $user)
    {
        $title = $_POST["title"];
        $type = $_POST["type"];
        $capacity = $_POST["capacity"];
        $price = $_POST["price"];
        $country = $_POST["country"];
        $city = $_POST["city"];
        $description = $_POST["description"];

        $house = $this->house->GetHouseById($id);
        if ($house["user_id"] == $user["id"] && $this->house->EditHouse($id, $title, $type, $capacity, $price, $country, $city, $description) && $house != null) {
            header("Location: owner");
        } else {
            $this->view = "EditHouse.php";
            $this->data["message"] = "Er ging iets mis bij het bewerken van dit huisje. Probeer het nog een keer.";
        }
    }

    private function DeleteHouse($id, $user)
    {
        $house = $this->house->GetHouseById($id);
        if ($house == null) {
            $this->view = "DeleteHouse.php";
            $this->data["message"] = "Er ging iets mis bij het verwijderen van dit huisje. Probeer het nog een keer.";
        } else {
            if ($house["user_id"] == $user["id"] && $this->house->DeleteHouse($id)) {
                header("Location: owner");
            } else {
                $this->view = "DeleteHouse.php";
                $this->data["message"] = "Er ging iets mis bij het verwijderen van dit huisje. Probeer het nog een keer.";
            }
        }
    }

    private function UploadHousePictures($houseId)
    {
        $countfiles = count($_FILES['pictures']['name']);

        for ($i = 0; $i < $countfiles; $i++) {
            $filename = basename($_FILES['pictures']['name'][$i]);

            if (!move_uploaded_file($_FILES['pictures']['tmp_name'][$i], SITE_ROOT . '/static/' . $filename) || !$this->house->AddHouseFile($houseId, '/static/' . $filename, "IMG")) {
                $err = true;
            }
        }
    }
}
