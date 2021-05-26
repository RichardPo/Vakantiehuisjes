<?php

require "Models/Model.php";

class House extends Model
{
    public function GetAll()
    {
        return $this->MakeArray($this->Query("SELECT * FROM houses"));
    }

    public function GetAllByID($id)
    {
        return $this->MakeArray($this->Query("SELECT * FROM houses WHERE id='$id'"));
    }

    public function GetAllByTitle($name)
    {
        return $this->MakeArray($this->Query("SELECT * FROM houses WHERE title='$name'"));
    }
}
