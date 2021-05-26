<?php

require "Controllers/Controller.php";

class HomeController extends Controller
{
    public function __construct()
    {
        $this->data["title"] = "Home";

        $this->view = "Home.php";
        $this->RenderView();
    }
}
