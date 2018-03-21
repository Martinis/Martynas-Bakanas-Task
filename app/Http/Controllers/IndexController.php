<?php
namespace App\Http\Controllers;

set_time_limit(0);
ini_set('max_execution_time', 0);

use Illuminate\Http\Request;
use App\Category;
use App\Helpers\CustomCategory;

class IndexController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    private function createNodes($parent, $iteration)
    {
        if ($iteration == 30) {
            return;
        }
        for ($i = 0; $i < 30; $i++) {
            $node = new Category();
            $node->name = substr(md5(rand()), 0, 7);
            $node->appendToNode($parent)->save();
        }
        $this->createNodes($node, $iteration+1);
    }

    /**
    * Function for recursive population with random categories and their childs for testing purposes
    *
    */
    public function populate()
    {
        for ($i = 0; $i < 20; $i++) {
            $parent = Category::create(['name' => substr(md5(rand()), 0, 7)]);
            $iteration = 0;
            $this->createNodes($parent, $iteration);
        }
    }

    /**
    * Iterative method to return categories in tree view
    *
    * @return array
    */
    private function to_tree($array)
    {
        $flat = array();
        $tree = array();
        foreach ($array as $category) {
            if (!isset($flat[$category->id])) {
                $flat[$category->id] = new CustomCategory($category->id, $category->name, 0);
            }
            if ($category->parent_id != null) {
                $flat[$category->id]->depth++;
                $flat[$category->parent_id]->children[$category->id] = $flat[$category->id];
            } else {
                $tree[$category->id] = $flat[$category->id];
            }
        }

        return $tree;
    }
    
    /**
    * Retrieve all categories in database, format into tree
    *
    * @return json
    */
    public function getCategories(Request $request)
    {
        if ($request->type == 'option1'){
            return Category::withDepth()->get()->toTree()->toJson();            
        } else if ($request->type == 'option2'){
            return json_encode($this->to_tree(Category::get()));
        } else {
            return 'fail';
        }
    }

    /**
    * Add new category, simple validation with notifications in front
    *
    * @return array('color class', 'font awesome icon fa-x', 'message')
    */
    public function addCategory(Request $request)
    {
        $input = $request->all();
        if (isset($request->parent) && $request->parent > 0) {
            $parent = Category::findOrFail($request->parent);
            if (!$parent) {
                return json_encode(['red', 'thumbs-o-down', 'Your parent category wasn\'t found. Most likely you\'re trying to hack something...']);
            }
            $node = new Category($input);
            $node->appendToNode($parent)->save();
        } else {
            Category::create($input);
        }
        return json_encode(['green', 'smile-o', 'You successfully created your category']);
    }

    /**
    * Remove category function
    *
    * @return array('color class', 'font awesome icon fa-x', 'message')
    */

    public function removeCategory(Request $request)
    {
        $node = Category::findOrFail($request->id);
        if ($node) {
            $node->delete();
            return json_encode(['green', 'thumbs-o-up', 'You successfully deleted '.$node->name.' and all of its childs']);
        }
        return json_encode(['red', 'exclamation', 'Something went wrong...']);
    }
}
