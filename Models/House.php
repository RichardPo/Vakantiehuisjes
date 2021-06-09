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

        return $this->MakeArray($this->Query("SELECT * FROM houses WHERE id='$id'"));
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

    public function GetAvailableHouses($capacity, $startDate, $endDate)
    {
        $capacity = $this->ValidateInput($capacity);
        $startDate = $this->ValidateInput($startDate);
        $endDate = $this->ValidateInput($endDate);

        $houses = $this->MakeArray($this->Query("SELECT * FROM houses WHERE capacity >= '$capacity'"));
        $availableHouses = [];

        foreach ($houses as $house) {
            $houseId = $house["id"];

            $bookings = $this->MakeArray($this->Query("SELECT * FROM bookings WHERE house_id='$houseId' AND status='Goedgekeurd'"));
            $hasOverlappingBooking = false;

            foreach ($bookings as $booking) {
                $bookingStartDate = date("Y-m-d", strtotime($booking["start_date"]));
                $bookingEndDate = date("Y-m-d", strtotime($booking["end_date"]));

                if ((($startDate > $bookingStartDate) && ($startDate < $bookingEndDate)) || (($endDate > $bookingStartDate) && ($endDate < $bookingEndDate))) {
                    $hasOverlappingBooking = true;
                }
            }

            if (!$hasOverlappingBooking) {
                array_push($availableHouses, $house);
            }
        }

        return $availableHouses;
    }
}
