<?php

class House extends Model
{
    public function GetAll()
    {
        return $this->MakeArray($this->Query("SELECT * FROM houses"));
    }

    public function GetHouseById($id)
    {
        $id = $this->ValidateInput($id);

        $foundHouses = $this->MakeArray($this->Query("SELECT * FROM houses WHERE id='$id'"));

        if (count($foundHouses) > 0) {
            return $foundHouses[0];
        } else {
            return null;
        }
    }

    public function GetAllByTitle($name)
    {
        $name = $this->ValidateInput($name);

        return $this->MakeArray($this->Query("SELECT * FROM houses WHERE title LIKE '%$name%'"));
    }

    public function GetHouseFilesByHouseId($id)
    {
        $id = $this->ValidateInput($id);

        return $this->MakeArray($this->Query("SELECT * FROM files WHERE house_id='$id'"));
    }

    public function GetAvailableHouses($amountOfPersons, $startDate, $endDate)
    {
        $amountOfPersons = $this->ValidateInput($amountOfPersons);
        $startDate = date("Y-m-d", strtotime($this->ValidateInput($startDate)));
        $endDate = date("Y-m-d", strtotime($this->ValidateInput($endDate)));

        $houses = $this->MakeArray($this->Query("SELECT * FROM houses WHERE capacity >= '$amountOfPersons'"));
        $availableHouses = [];

        foreach ($houses as $house) {
            $houseId = $house["id"];

            $bookings = $this->MakeArray($this->Query("SELECT * FROM bookings WHERE house_id='$houseId'"));
            $hasOverlappingBooking = false;

            foreach ($bookings as $booking) {
                $bookingStartDate = date("Y-m-d", strtotime($booking["start_date"]));
                $bookingEndDate = date("Y-m-d", strtotime($booking["end_date"]));

                if (($startDate >= $bookingStartDate && $startDate <= $bookingEndDate) || ($bookingStartDate >= $startDate && $bookingStartDate <= $endDate)) {
                    $hasOverlappingBooking = true;
                }
            }

            if (!$hasOverlappingBooking) {
                array_push($availableHouses, $house);
            }
        }

        return $availableHouses;
    }

    public function IsHouseAvailable($houseId, $amountOfPersons, $startDate, $endDate)
    {
        $availableHouses = $this->GetAvailableHouses($amountOfPersons, $startDate, $endDate);

        foreach ($availableHouses as $house) {
            if ($house["id"] == $houseId) {
                return true;
            }
        }

        return false;
    }
}
