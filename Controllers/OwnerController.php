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
    }

    private function ShowDeletePanel()
    {
        $this->view = "DeleteHouse.php";
        $this->data["title"] = "Verwijderen";
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

        if ($this->house->CreateHouse($title, $type, $capacity, $price, $country, $city, $description, $user["id"])) {
            header("Location: owner");
        } else {
            $this->view = "AddHouse.php";
            $this->data["message"] = "Er ging iets mis bij het aanmaken van de accommodatie. Zorg dat alle velden ingevuld zijn en probeer het nog een keer.";
        }
    }

    private function EditHouse($id, $user)
    {
        $house = $this->house->GetHouseById($id);
        if ($house == null) {
            return false;
        } else {
            if ($house["user_id"] == $user["id"]) {
                return $this->house->EditHouse($id);
            } else {
                return false;
            }
        }
    }

    private function DeleteHouse($id, $user)
    {
        $house = $this->house->GetHouseById($id);
        if ($house == null) {
            $this->view = "DeleteHouse.php";
            $this->data["message"] = "Er ging iets mis bij het verwijderen van dit huisje. Probeer het nog een keer.";
        } else {
            if ($house["user_id"] == $user["id"]) {
                if ($this->house->DeleteHouse($id)) {
                    header("Location: owner");
                }
            } else {
                $this->view = "DeleteHouse.php";
                $this->data["message"] = "Er ging iets mis bij het verwijderen van dit huisje. Probeer het nog een keer.";
            }
        }
    }
}
