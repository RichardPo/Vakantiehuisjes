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
            $foundHouse = $this->house->GetHouseById($houseId);
            if ($foundHouse != null) {
                if (isset($_POST["book"])) {
                    $this->Book($houseId);
                } else if (isset($_POST["review"])) {
                    $this->PostReview($houseId);
                }

                $this->view = "Accommodation.php";
                $this->data["house"] = $foundHouse;
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

            if ($this->review->CanUserPostReview($houseId, $userId)) {

                if ($this->review->PostReview($houseId, $userId, $rating, $title, $review) == false) {
                    $this->data["reviewMessage"] = "Er ging iets mis bij het posten van je review. Probeer het nog een keer.";
                } else {
                    $this->data["reviewMessage"] = "Je review is gepost!";
                }
            } else {
                $this->data["reviewMessage"] = "Je kan geen reviews plaatsen bij accommodaties die je niet bezocht hebt.";
            }
        } else {
            $this->data["reviewMessage"] = "Je moet ingelogd zijn om een review achter te laten.";
        }
    }

    private function Book($houseId)
    {
        $personAmount = $_POST["numberOfPersons"];
        $fromDate = $_POST["fromDate"];
        $toDate = $_POST["toDate"];
        $remarks = $_POST["remarks"];

        $fromDateTimeStamp = strtotime($fromDate);
        $toDateTimeStamp = strtotime($toDate);

        if (($toDateTimeStamp > $fromDateTimeStamp) && ($fromDateTimeStamp > time())) {
            $currentUser = $this->user->GetCurrentUser();
            if ($currentUser != null) {
                if ($this->house->IsHouseAvailable($houseId, $personAmount, $fromDate, $toDate)) {
                    $userId = $currentUser["id"];

                    if ($this->booking->AddBooking($houseId, $userId, $fromDate, $toDate, $personAmount, $remarks)) {
                        $this->data["bookingMessage"] = "Je booking wordt verwerkt!";
                    } else {
                        $this->data["bookingMessage"] = "Er ging iets mis bij het booken van deze accommodatie. Probeer het nog een keer.";
                    }
                } else {
                    $this->data["bookingMessage"] = "De booking kon niet worden gemaakt omdat deze accommodatie niet beschikbaar is.";
                }
            } else {
                $this->data["bookingMessage"] = "Je moet ingelogd zijn om een accommodatie te booken.";
            }
        } else {
            $this->data["bookingMessage"] = "Je kan alleen een accommodatie booken voor in de toekomst. Zorg er ook voor dat de begindatum vroeger is dan de einddatum.";
        }
    }
}
