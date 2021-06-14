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
            $this->data["title"] = "Verhuurderspaneel";

            $this->data["houses"] = $this->house->GetAllByOwnerId($user["id"]);

            $this->view = "Owner.php";
            $this->RenderView();
        } else {
            header("Location: account");
        }
    }
}
