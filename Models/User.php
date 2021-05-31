<?php

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

    public function GetUserByUsername($username)
    {
        $users = $this->MakeArray($this->Query("SELECT * FROM users WHERE username='$username'"));
        if (count($users) > 0) {
            return $users[0];
        } else {
            return null;
        }
    }

    public function GetUserInfoByID($id)
    {
        $userInfos = $this->MakeArray($this->Query("SELECT * FROM user_info WHERE user_id='$id'"));
        if (count($userInfos) > 0) {
            return $userInfos[0];
        } else {
            return null;
        }
    }

    public function CheckUserCredentials($username, $password)
    {
        $foundUsers = $this->MakeArray($this->Query("SELECT * FROM users WHERE username='$username'"));
        if (count($foundUsers) > 0) {
            $user = $foundUsers[0];
            return $user["username"] == $username && $user["password"] == hash("sha256", $password);
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

    public function SetCurrentUser($id, $username)
    {
        $_SESSION["user"]["id"] = $id;
        $_SESSION["user"]["username"] = $username;
    }

    public function ResetCurrentUser()
    {
        unset($_SESSION["user"]);
    }

    public function CreateUser($username, $password, $role)
    {
        $pass = hash("sha256", $password);

        $usersWithUsername = $this->Query("SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($usersWithUsername) > 0) {
            return false;
        } else {
            return $this->Query("INSERT INTO users (username, password, role) VALUES ('$username', '$pass', '$role')");
        }
    }

    public function EditUserWithId($id, $newUsername, $newPassword, $newRole)
    {
        $pass = hash("sha256", $newPassword);

        $usersWithUsername = $this->Query("SELECT * FROM users WHERE username='$newUsername'");
        if (mysqli_num_rows($usersWithUsername) > 0) {
            return false;
        } else {
            return $this->Query("UPDATE users SET username='$newUsername', password='$pass', role='$newRole' WHERE id='$id'");
        }
    }

    public function EditUserInfoWithUserId($id, $name, $email, $phone, $birthday, $country, $city, $street, $postalCode)
    {
        $userInfos = $this->Query("SELECT * FROM user_info WHERE user_id='$id'");
        if (mysqli_num_rows($userInfos) > 0) {
            return $this->Query("UPDATE user_info SET name='$name', email='$email', birthdate='$birthday', phone='$phone', country='$country', city='$city', street='$street', postal_code='$postalCode' WHERE user_id='$id'");
        } else {
            return $this->Query("INSERT INTO user_info (name, email, phone, birthday, country, city, street, postal_code, user_id) VALUES ('$name', '$email', '$phone', '$birthday', '$country', '$city', '$street', '$postalCode', '$id')");
        }
    }
}
