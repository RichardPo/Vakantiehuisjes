<?php

session_start();

require "Router.php";

$router = new Router($_SERVER['REQUEST_URI']);
