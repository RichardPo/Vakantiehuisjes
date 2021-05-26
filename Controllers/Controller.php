<?php

class Controller
{
    protected $view;
    protected $data = [];

    public function RenderView()
    {
        extract($this->data);
        require "Views/" . $this->view;
    }
}
