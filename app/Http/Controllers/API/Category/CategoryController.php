<?php

namespace App\Http\Controllers\API\Category;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Category\CategoryResource;

class CategoryController extends Controller
{
    public function getCategoryList(){
        $category = Category::get();
        return CategoryResource::collection($category);   
    }

}