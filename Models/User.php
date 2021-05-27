<?php

require "Models/Model.php";

class User extends Model
{
    public function GetAll()
    {
        return $this->MakeArray($this->Query("SELECT * FROM users"));
    }

    public function GetAllByID($id)
    {
        return $this->MakeArray($this->Query("SELECT * FROM users WHERE id='$id'"));
    }

    public function CheckUserCredentials($username, $password)
    {
        $foundUsers = $this->MakeArray($this->Query("SELECT * FROM users WHERE username='$username'"));
        if (count($foundUsers) > 0) {
            $user = $foundUsers[0];
            return $user["username"] == $username && $user["password"] == $password;
        } else {
            return false;
        }
    }

    public function GetCurrentUser()
    {
        if (isset($_SESSION["user"])) {
            return $_SESSION["user"];
        } else {
            return null;
        }
    }

    public function SetCurrentUser($username, $password)
    {
        $_SESSION["user"] = ["username" => $username, "password" => $password];
    }

    public function ResetCurrentUser()
    {
        unset($_SESSION["user"]);
    }
}
