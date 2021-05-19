<?php

    require "Models/Model.php";

    class House extends Model
    {
        public function GetAll() {
            return $this->MakeArray($this->Query("SELECT * FROM houses"));
        }
    }

?>