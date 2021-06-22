<?php

require "Models/House.php";
require "Models/Booking.php";

class AccommodationController extends Controller
{
    private $house;
    private $booking;

    public function __construct()
    {
        $this->house = new House();
        $this->booking = new Booking();

        $this->data["title"] = "Zoeken";

        $accommodations = [];
        if (isset($_GET["accommodation_name"])) {
            $accommodations = $this->house->GetAllByTitle($_GET["accommodation_name"]);
        } else if (isset($_GET["startDate"]) && isset($_GET["endDate"]) && isset($_GET["amount"])) {
            $accommodations = $this->house->GetAvailableHouses($_GET["amount"], $_GET["startDate"], $_GET["endDate"]);
        } else {
            $accommodations = $this->house->GetAll();
        }
        $this->data["houses"] = $accommodations;

        $files = [];
        foreach ($accommodations as $accommodation) {
            $files[$accommodation["id"]] = $this->house->GetHousePictureByHouseId($accommodation["id"]);
        }
        $this->data["files"] = $files;

        $this->view = "Accommodations.php";
        $this->RenderView();
    }
}
