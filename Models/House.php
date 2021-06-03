<?php

class House extends Model
{
    public function GetAll()
    {
        return $this->MakeArray($this->Query("SELECT * FROM houses"));
    }

    public function GetHouseById($id)
    {
        return $this->MakeArray($this->Query("SELECT * FROM houses WHERE id='$id'"));
    }

    public function GetAllByTitle($name)
    {
        return $this->MakeArray($this->Query("SELECT * FROM houses WHERE title LIKE '%$name%'"));
    }

    public function GetHouseFilesByHouseId($id)
    {
        return $this->MakeArray($this->Query("SELECT * FROM files WHERE house_id='$id'"));
    }
}
