<?php

    require "Controllers/Controller.php";
    require "Models/House.php";

    class HomeController extends Controller 
    {
        private $house;

        public function __construct()
        {
            $this->house = new House();

            $this->data["houses"] = $this->house->GetAll();

            $this->view = "Home.php";
            $this->RenderView();
        }
    }

?>