<?php

class Router
{
    private $controller;

    private $routes = [
        "" => "HomeController",
        "home" => "HomeController",
        "search" => "SearchController",
        "account" => "AccountController"
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
        $pageWithParameters = $urlParts[2];
        $page = explode("?", $pageWithParameters)[0];

        return $page;
    }
}
