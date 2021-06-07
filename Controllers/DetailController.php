<?php

require "Models/House.php";
require "Models/User.php";
require "Models/Review.php";
require "Models/Booking.php";

class DetailController extends Controller
{
    private $house;
    private $user;
    private $review;
    private $booking;

    private $accommodation;

    public function __construct()
    {
        $this->house = new House();
        $this->user = new User();
        $this->review = new Review();
        $this->booking = new Booking();

        $this->data["title"] = "Accommodatie";

        if (isset($_GET["id"])) {
            $houseId = $_GET["id"];
            $foundHouses = $this->accommodation = $this->house->GetHouseById($houseId);
            if (count($foundHouses) > 0) {
                $accommodation = $foundHouses[0];

                if (isset($_POST["book"])) {
                    $this->Book($houseId, $accommodation["capacity"]);
                } else if (isset($_POST["review"])) {
                    $this->PostReview($houseId);
                }

                $this->view = "Accommodation.php";
                $this->data["house"] = $accommodation;
                $this->data["files"] = $this->house->GetHouseFilesByHouseId($houseId);
                $this->data["reviews"] = $this->review->GetAllByHouseId($houseId);
                $this->RenderView();
            }
        } else {
            header("Location: home");
        }
    }

    private function PostReview($houseId)
    {
        $title = $_POST["title"];
        $rating = $_POST["rating"];
        $review = $_POST["main"];

        $currentUser = $this->user->GetCurrentUser();
        if ($currentUser != null) {
            $userId = $currentUser["id"];

            if ($this->review->PostReview($houseId, $userId, $rating, $title, $review) == false) {
                $this->data["message"] = "Er ging iets mis bij het posten van je review. Probeer het nog een keer.";
            } else {
                $this->data["message"] = "Je review is gepost!";
            }
        } else {
            $this->data["message"] = "Je moet ingelogd zijn om een review achter te laten.";
        }
    }

    private function Book($houseId, $houseCapacity)
    {
        $personAmount = $_POST["numberOfPersons"];
        $fromDate = $_POST["fromDate"];
        $toDate = $_POST["toDate"];
        $remarks = $_POST["remarks"];

        $currentUser = $this->user->GetCurrentUser();
        if ($currentUser != null) {
            if ($personAmount <= $houseCapacity) {
                $userId = $currentUser["id"];

                if ($this->booking->AddBooking($houseId, $userId, $fromDate, $toDate, $personAmount, $remarks)) {
                    $this->data["message"] = "Je booking wordt verwerkt!";
                } else {
                    $this->data["message"] = "Er ging iets mis bij het booken van deze accommodatie. Probeer het nog een keer.";
                }
            } else {
                $this->data["message"] = "De booking kon niet worden gemaakt omdat de capaciteit van deze acccommodatie niet voldoet.";
            }
        } else {
            $this->data["message"] = "Je moet ingelogd zijn om een accommodatie te booken.";
        }
    }
}
