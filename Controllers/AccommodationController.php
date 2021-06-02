<?php

require "Models/House.php";

class AccommodationController extends Controller
{
    private $house;

    public function __construct()
    {
        $this->house = new House();

        $this->data["title"] = "Zoeken";

        if (isset($_GET["accommodation_name"])) {
            $this->data["houses"] = $this->house->GetAllByTitle($_GET["accommodation_name"]);
        } else {
            $this->data["houses"] = $this->house->GetAll();
        }

        $this->view = "Accommodations.php";
        $this->RenderView();
    }
}
