<?php
namespace App\Helpers;

class CustomCategory
{
    public $name;
    public $id;
    public $depth;
    public $children = [];

    public function __construct($id, $name, $depth)
    {
        $this->name = $name;
        $this->id = $id;
        $this->depth = $depth;
    }
}
