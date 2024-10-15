<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class IndexController extends Controller
{
    public function index(){
        $categories_with_posts = Category::with(['posts'=>function ($q){
            $q->limit(2);
        }])->get();
       return view('website.index' , compact('categories_with_posts'));
    }
}
