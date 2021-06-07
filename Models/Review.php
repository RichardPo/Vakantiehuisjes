<?php

class Review extends Model
{
    public function GetAllByHouseId($id)
    {
        $id = $this->ValidateInput($id);

        return $this->MakeArray($this->Query("SELECT * FROM reviews WHERE house_id='$id'"));
    }

    public function GetAllByUserId($id)
    {
        $id = $this->ValidateInput($id);

        return $this->MakeArray($this->Query("SELECT * FROM reviews WHERE user_id='$id'"));
    }

    public function PostReview($houseId, $userId, $rating, $title, $review)
    {
        $houseId = $this->ValidateInput($houseId);
        $userId = $this->ValidateInput($userId);
        $rating = $this->ValidateInput($rating);
        $title = $this->ValidateInput($title);
        $review = $this->ValidateInput($review);

        $rating = max(0, min(5, $rating));

        return $this->Query("INSERT INTO reviews (rating, title, review, house_id, user_id) VALUES ('$rating', '$title', '$review', '$houseId', '$userId')");
    }
}
