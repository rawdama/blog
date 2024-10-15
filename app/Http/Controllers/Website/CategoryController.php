<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {   dd(123);
        $category = $category->load('children');
        $posts = Post::where('category_id' , $category->id)->paginate(15);
        
        return view('website.category' , compact('category','posts'));
    }

}
