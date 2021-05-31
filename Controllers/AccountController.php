<?php

require "Models/User.php";
require "Models/Review.php";

class AccountController extends Controller
{
    private $user;
    private $review;

    public function __construct()
    {
        $this->user = new User();
        $this->review = new Review();

        if ($this->user->GetCurrentUser() == null) {
            if (isset($_POST["register"])) {
                if ($this->user->CreateUser($_POST["username"], $_POST["password"], $_POST["role"])) {
                    header("Location: account");
                } else {
                    $this->view = "Register.php";
                    $this->data["title"] = "Registreren";
                    $this->data["message"] = "Er is een fout opgetreden tijdens het aanmaken van je account. Probeer het nog een keer.";
                }
            } else if (isset($_POST["login"])) {
                if ($this->user->CheckUserCredentials($_POST["username"], $_POST["password"])) {
                    $id = $this->user->GetUserByUsername($_POST["username"])["id"];
                    $this->user->SetCurrentUser($id, $_POST["username"]);

                    header("Location: account");
                } else {
                    $this->view = "Login.php";
                    $this->data["title"] = "Inloggen";
                    $this->data["message"] = "Dat waren de verkeerde inloggegevens. Probeer het opnieuw.";
                }
            } else if (isset($_GET["register"])) {
                $this->view = "Register.php";
                $this->data["title"] = "Registreren";
            } else {
                $this->view = "Login.php";
                $this->data["title"] = "Inloggen";
            }
        } else {
            if (isset($_GET["logout"])) {
                $this->user->ResetCurrentUser();

                header("Location: account");
            } else if (isset($_POST["editCredentials"])) {
                if ($this->user->EditUserWithId($this->user->GetCurrentUser()["id"], $_POST["username"], $_POST["password"], $_POST["role"])) {
                    header("Location: account");
                } else {
                    $this->view = "EditAccount.php";
                    $this->data["title"] = "Account Bewerken";
                    $this->data["credentialsMessage"] = "Er is een fout opgetreden bij het bijwerken van je account. Probeer het nog een keer.";
                }
            } else if (isset($_POST["editInfo"])) {
                $name = $_POST["name"];
                $email = $_POST["email"];
                $phone = $_POST["phone"];
                $birthday = $_POST["birthday"];
                $country = $_POST["country"];
                $city = $_POST["city"];
                $street = $_POST["street"];
                $postalCode = $_POST["postal_code"];

                if ($this->user->EditUserInfoWithUserId($this->user->GetCurrentUser()["id"], $name, $email, $phone, $birthday, $country, $city, $street, $postalCode)) {
                    header("Location: account");
                } else {
                    $this->view = "EditAccount.php";
                    $this->data["title"] = "Account Bewerken";
                    $this->data["accountMessage"] = "Er is een fout opgetreden bij het bijwerken van je account. Probeer het nog een keer.";
                }
            } else if (isset($_GET["edit"])) {
                $this->view = "EditAccount.php";
                $this->data["title"] = "Account Bewerken";
            } else {
                $this->view = "Account.php";
                $this->data["title"] = "Account";

                $this->data["reviews"] = $this->review->GetAllByUserId($this->user->GetCurrentUser()["id"]);
                $this->data["userInfo"] = $this->user->GetUserInfoByID($this->user->GetCurrentUser()["id"]);
            }
        }

        $this->RenderView();
    }
}