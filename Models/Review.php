<?php

class Review extends Model
{
    public function GetAllByHouseId($id)
    {
        return $this->MakeArray($this->Query("SELECT * FROM reviews WHERE house_id='$id'"));
    }

    public function GetAllByUserId($id)
    {
        return $this->MakeArray($this->Query("SELECT * FROM reviews WHERE user_id='$id'"));
    }
}
