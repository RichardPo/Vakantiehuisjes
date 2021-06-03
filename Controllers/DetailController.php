<?php

require "Models/House.php";

class DetailController extends Controller
{
    private $house;

    public function __construct()
    {
        $this->house = new House();

        $this->data["title"] = "Accommodatie";

        if (isset($_GET["id"])) {
            $houseId = $_GET["id"];
            $foundHouses = $this->accommodation = $this->house->GetHouseById($houseId);
            if (count($foundHouses) > 0) {
                $accommodation = $foundHouses[0];

                $this->view = "Accommodation.php";
                $this->data["house"] = $accommodation;
                $this->data["files"] = $this->house->GetHouseFilesByHouseId($houseId);
                $this->RenderView();
            }
        } else {
            header("Location: home");
        }
    }
}
