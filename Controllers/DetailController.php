<?php

require "Models/House.php";

class DetailController extends Controller
{
    private $house;

    private $accommodation;

    public function __construct()
    {
        $this->house = new House();

        $this->data["title"] = "Accommodatie";

        if (isset($_GET["id"])) {
            $foundHouses = $this->accommodation = $this->house->GetAllByID($_GET["id"]);
            if (count($foundHouses) > 0) {
                $this->accommodation = $foundHouses[0];
            }
        } else {
            header("Location: home");
        }

        $this->view = "Accommodation.php";
        $this->data["accommodation"] = $this->accommodation;
        $this->RenderView();
    }
}
