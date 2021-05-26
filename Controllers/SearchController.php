<?php

require "Controllers/Controller.php";
require "Models/House.php";

class SearchController extends Controller
{
    private $house;

    public function __construct()
    {
        $this->house = new House();

        $this->data["title"] = "Zoeken";
        $this->data["houses"] = $this->house->GetAllByTitle($_GET["accomodation_name"]);

        $this->view = "Accommodations.php";
        $this->RenderView();
    }
}
