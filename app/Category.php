<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    public $timestamps = false;

    public $fillable = ['name'];

    /**
    * Get all childs of category
    * Very slow method...
    */
    public function childs()
    {
        return $this->hasMany('App\Category', 'parent', 'id');
    }
}
