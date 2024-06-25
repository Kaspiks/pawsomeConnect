<?php


// app/Structs/MenuItem.php

namespace App\Structs;

class MenuItem
{
    public $title;
    public $url;
    public $children;

    public function __construct($title, $url, $children = [])
    {
        $this->title = $title;
        $this->url = $url;
        $this->children = $children;
    }
}
