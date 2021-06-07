<?php

require "Models/House.php";

class AccommodationController extends Controller
{
    private $house;

    public function __construct()
    {
        $this->house = new House();

        $this->data["title"] = "Zoeken";

        $accommodations = [];

        if (isset($_GET["accommodation_name"])) {
            $accommodations = $this->house->GetAllByTitle($_GET["accommodation_name"]);
        } else {
            $accommodations = $this->house->GetAll();
        }

        $this->data["houses"] = [];

        foreach ($accommodations as $accommodation) {
            $accommodationFiles = $this->house->GetHouseFilesByHouseId($accommodation["id"]);
            if (count($accommodationFiles) > 0) {
                $accommodation["pictureURL"] = $accommodationFiles[0]["path"];
            } else {
                $accommodation["pictureURL"] = "https://i.pinimg.com/736x/b3/cc/d5/b3ccd57b054a73af1a0d281265b54ec8.jpg";
            }

            array_push($this->data["houses"], $accommodation);
        }

        $this->view = "Accommodations.php";
        $this->RenderView();
    }
}
