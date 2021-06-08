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

    public function GetAllAvailableHousesByCapacity($maxCapacity)
    {
        $maxCapacity = $this->ValidateInput($maxCapacity);

        return $this->MakeArray($this->Query("SELECT * FROM houses WHERE capacity <= $maxCapacity"));
    }
}
