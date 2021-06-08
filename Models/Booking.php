<?php

class Booking extends Model
{
    public function AddBooking($houseId, $userId, $fromDate, $toDate, $amountOfPersons, $remarks)
    {
        $houseId = $this->ValidateInput($houseId);
        $userId = $this->ValidateInput($userId);
        $fromDate = $this->ValidateInput($fromDate);
        $toDate = $this->ValidateInput($toDate);
        $amountOfPersons = $this->ValidateInput($amountOfPersons);
        $remarks = $this->ValidateInput($remarks);

        return $this->Query("INSERT INTO bookings (house_id, user_id, start_date, end_date, status, number_persons, remarks) VALUES ('$houseId', '$userId', '$fromDate', '$toDate', 'Wordt verwerkt', '$amountOfPersons', '$remarks')");
    }

    public function GetAllBookings()
    {
        return $this->MakeArray($this->Query("SELECT bookings.id AS bookingId, bookings.user_id AS bookingUserId, bookings.house_id, bookings.start_date, bookings.end_date, bookings.status, bookings.number_persons, bookings.remarks, houses.* FROM bookings LEFT JOIN houses ON bookings.house_id = houses.id"));
    }

    public function GetAllBookingsByUserId($id)
    {
        $id = $this->ValidateInput($id);

        $bookings = $this->GetAllBookings();
        $userBookings = [];
        foreach ($bookings as $booking) {
            if ($booking["bookingUserId"] == $id) {
                array_push($userBookings, $booking);
            }
        }

        return $userBookings;
    }

    public function GetAllBookingsByHouseId($id)
    {
        $id = $this->ValidateInput($id);

        $bookings = $this->GetAllBookings();

        $houseBookings = [];
        foreach ($bookings as $booking) {
            if ($booking["house_id"] == $id) {
                array_push($houseBookings, $booking);
            }
        }

        return $houseBookings;
    }

    public function GetAllAcceptedBookingsByHouseId($id)
    {
        $bookings = $this->GetAllBookingsByHouseId($id);

        $acceptedBookings = [];
        foreach ($bookings as $booking) {
            if ($booking["status"] == "Goedgekeurd") {
                array_push($acceptedBookings, $booking);
            }
        }

        return $acceptedBookings;
    }

    public function IsGivenDateOverlappingWithBookingByHouseId($date, $houseId)
    {
        $date = $this->ValidateInput($date);

        $houseBookings = $this->GetAllAcceptedBookingsByHouseId($houseId);
        if (count($houseBookings) > 0) {
            $date = date("Y-m-d", strToTime($date));

            foreach ($houseBookings as $booking) {
                $startDate = date("Y-m-d", strToTime($booking["start_date"]));
                $endDate = date("Y-m-d", strToTime($booking["end_date"]));

                if (($date >= $startDate) && ($date <= $endDate)) {
                    return true;
                }
            }

            return false;
        } else {
            return false;
        }
    }
}
