<?php

session_start();

define('SITE_ROOT', realpath(dirname(__FILE__)));

require "Router.php";

$router = new Router($_SERVER['REQUEST_URI']);
