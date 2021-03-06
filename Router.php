<?php

require "Models/Model.php";
require "Controllers/Controller.php";

class Router
{
    private $controller;

    private $routes = [
        "" => "HomeController",
        "home" => "HomeController",
        "search" => "AccommodationController",
        "account" => "AccountController",
        "accommodations" => "AccommodationController",
        "accommodation" => "DetailController",
        "owner" => "OwnerController"
    ];

    public function __construct($url)
    {
        $key = $this->ParseUrl($url);
        if (array_key_exists($key, $this->routes)) {
            $route = $this->routes[$key];

            require "Controllers/" . $route . ".php";
            $this->controller = new $route();
        } else {
            echo "Page not found.";
        }
    }

    private function ParseUrl($url)
    {
        $urlParts = explode("/", $url);
        $pageWithParameters = $urlParts[count($urlParts) - 1];
        $page = explode("?", $pageWithParameters)[0];

        return $page;
    }
}
