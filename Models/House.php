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

    public function GetAllByOwnerId($id)
    {
        $id = $this->ValidateInput($id);

        return $this->MakeArray($this->Query("SELECT * FROM houses WHERE user_id='$id'"));
    }

    public function GetAllByTitle($name)
    {
        $name = $this->ValidateInput($name);

        return $this->MakeArray($this->Query("SELECT * FROM houses WHERE title LIKE '%$name%'"));
    }

    public function GetPopularHouses($amount)
    {
        $houses = $this->GetAll();

        $housesWithAVGRatings = [];
        $ratings = [];

        foreach ($houses as $house) {
            $houseId = $house["id"];

            $rating = floatval($this->MakeArray($this->Query("SELECT AVG(rating) FROM reviews WHERE house_id='$houseId'"))[0]["AVG(rating)"]);

            array_push($ratings, $rating);

            $houseWithAVGRating = $house;
            $houseWithAVGRating["rating"] = $rating;
            $houseWithAVGRating["picture"] = $this->GetHousePictureByHouseId($houseId);
            array_push($housesWithAVGRatings, $houseWithAVGRating);
        }

        array_multisort($ratings, SORT_DESC, $housesWithAVGRatings);

        return array_slice($housesWithAVGRatings, 0, $amount);
    }

    public function GetHouseFilesByHouseId($id)
    {
        $id = $this->ValidateInput($id);

        return $this->MakeArray($this->Query("SELECT * FROM files WHERE house_id='$id'"));
    }

    public function GetHousePictureByHouseId($id)
    {
        $foundFiles = $this->MakeArray($this->Query("SELECT * FROM files WHERE house_id='$id'"));
        if (count($foundFiles) > 0) {
            return $foundFiles[0]["path"];
        } else {
            return "https://i.pinimg.com/736x/b3/cc/d5/b3ccd57b054a73af1a0d281265b54ec8.jpg";
        }
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

    public function CreateHouse($title, $type, $capacity, $price, $country, $city, $description, $userId)
    {
        $title = $this->ValidateInput($title);
        $type = $this->ValidateInput($type);
        $capacity = $this->ValidateInput($capacity);
        $price = $this->ValidateInput($price);
        $country = $this->ValidateInput($country);
        $city = $this->ValidateInput($city);
        $description = $this->ValidateInput($description);

        if ($this->Query("INSERT INTO houses (title, type, capacity, price, country, city, description, user_id) VALUES ('$title', '$type', '$capacity', '$price', '$country', '$city', '$description', '$userId')")) {
            return mysqli_insert_id($this->connection);
        } else {
            return false;
        }
    }

    public function EditHouse($id, $title, $type, $capacity, $price, $country, $city, $description)
    {
        $id = $this->ValidateInput($id);
        $title = $this->ValidateInput($title);
        $type = $this->ValidateInput($type);
        $capacity = $this->ValidateInput($capacity);
        $price = $this->ValidateInput($price);
        $country = $this->ValidateInput($country);
        $city = $this->ValidateInput($city);
        $description = $this->ValidateInput($description);

        return $this->Query("UPDATE houses SET title='$title', type='$type', capacity='$capacity', price='$price', country='$country', city='$city', description='$description' WHERE id='$id'");
    }

    public function DeleteHouse($id)
    {
        return $this->Query("DELETE FROM houses WHERE id='$id'");
    }

    public function AddHouseFile($houseId, $filePath, $fileType)
    {
        $filePath = $this->ValidateInput($filePath);
        $fileType = $this->ValidateInput($fileType);

        return $this->Query("INSERT INTO files (path, type, house_id) VALUES ('$filePath', '$fileType', '$houseId')");
    }
}
