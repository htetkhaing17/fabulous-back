<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function all()
    {
        $categories = Category::with('children.children.children.children.children.children')->where('menu', 0)->get();

          return response()->json(['data' => collect($categories)->filter()->all()]);
    }   

  
    
}
