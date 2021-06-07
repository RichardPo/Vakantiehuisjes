<?php

require "Models/User.php";
require "Models/Review.php";
require "Models/Booking.php";

class AccountController extends Controller
{
    private $user;
    private $review;
    private $booking;

    public function __construct()
    {
        $this->user = new User();
        $this->review = new Review();
        $this->booking = new Booking();

        if ($this->user->GetCurrentUser() == null) {
            if (isset($_POST["register"])) {
                $this->Register();
            } else if (isset($_POST["login"])) {
                $this->Login();
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
                $this->EditCredentials();
            } else if (isset($_POST["editInfo"])) {
                $this->EditInfo();
            } else if (isset($_GET["edit"])) {
                $this->view = "EditAccount.php";
                $this->data["title"] = "Account Bewerken";
                $this->data["userInfo"] = $this->user->GetUserInfoByID($this->user->GetCurrentUser()["id"]);
            } else {
                $this->view = "Account.php";
                $this->data["title"] = "Account";

                $userId = $this->user->GetCurrentUser()["id"];

                $this->data["reviews"] = $this->review->GetAllByUserId($userId);
                $this->data["userInfo"] = $this->user->GetUserInfoByID($userId);
                $this->data["bookings"] = $this->booking->GetAllBookingsByUserId($userId);
            }
        }

        $this->RenderView();
    }

    private function Register()
    {
        if ($this->user->CreateUser($_POST["username"], $_POST["password"], $_POST["role"])) {
            header("Location: account");
        } else {
            $this->view = "Register.php";
            $this->data["title"] = "Registreren";
            $this->data["message"] = "Er is een fout opgetreden tijdens het aanmaken van je account. Probeer het nog een keer.";
        }
    }

    private function Login()
    {
        if ($this->user->CheckUserCredentials($_POST["username"], $_POST["password"])) {
            $id = $this->user->GetUserByUsername($_POST["username"])["id"];
            $this->user->SetCurrentUser($id, $_POST["username"]);

            header("Location: account");
        } else {
            $this->view = "Login.php";
            $this->data["title"] = "Inloggen";
            $this->data["message"] = "Dat waren de verkeerde inloggegevens. Probeer het opnieuw.";
        }
    }

    private function EditCredentials()
    {
        if ($this->user->EditUserWithId($this->user->GetCurrentUser()["id"], $_POST["username"], $_POST["password"], $_POST["role"])) {
            $id = $this->user->GetCurrentUser()["id"];
            $username = $this->user->GetUserById($id)["username"];
            $this->user->SetCurrentUser($id, $username);
            header("Location: account");
        } else {
            $this->view = "EditAccount.php";
            $this->data["title"] = "Account Bewerken";
            $this->data["credentialsMessage"] = "Er is een fout opgetreden bij het bijwerken van je account. Probeer het nog een keer.";
        }
    }

    private function EditInfo()
    {
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
    }
}
