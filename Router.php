<?php

    class Router 
    {
        private $controller;

        private $routes = [
            "home" => "HomeController"
        ];

        public function __construct($url)
        {
            $route = $this->routes[$this->ParseUrl($url)];

            require "Controllers/" . $route . ".php";

            $this->controller = new $route();
        }

        private function ParseUrl($url) {
            $urlParts = explode("/", $url);
            $page = $urlParts[2];
            return $page;
        }
    }

?>