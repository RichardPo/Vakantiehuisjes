<?php

require "Controllers/Controller.php";
require "Models/User.php";

class AccountController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();

        if (isset($_GET["logout"])) {
            $this->user->ResetCurrentUser();

            $this->data["title"] = "Uitloggen";
            $this->view = "Login.php";
            header("location: account");
        } else if ($this->user->GetCurrentUser() != null) {
            $this->data["title"] = "Account";
            $this->view = "Account.php";
        } else if (isset($_POST["login"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            if (empty($username) || empty($password)) {
                $this->data["message"] = "Vul allebei de velden in.";
            } else if ($this->user->CheckUserCredentials($username, $password)) {
                $this->user->SetCurrentUser($username, $password);
                header("Location: account");
            } else {
                $this->data["message"] = "Verkeerde inloggegevens! Probeer het opnieuw.";
            }

            $this->data["title"] = "Inloggen";
            $this->view = "Login.php";
        } else {
            $this->data["title"] = "Inloggen";
            $this->view = "Login.php";
        }

        $this->RenderView();
    }
}
