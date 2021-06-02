<?php

class Model
{
    private $connection;
    private $server = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "vakantiehuisjes";

    public function __construct()
    {
        $this->connection = mysqli_connect($this->server, $this->username, $this->password, $this->db);
    }

    public function Query($query)
    {
        return mysqli_query($this->connection, $query);
    }

    public function MakeArray($queryResult)
    {
        if (is_a($queryResult, "mysqli_result")) {
            $list = [];
            while ($row = mysqli_fetch_assoc($queryResult)) {
                array_push($list, $row);
            }
            return $list;
        } else {
            return false;
        }
    }

    public function GetError()
    {
        return mysqli_error($this->connection);
    }

    protected function ValidateInput($input)
    {
        return mysqli_real_escape_string($this->connection, $input);
    }
}
