<?php

namespace App\Http\Controllers\Api;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::paginate(2);
        return CategoryResource::collection($categories);
    }
    public function navbarCategories(){
         $categories = Category::with('children')->where('parent' , 0)->orWhere('parent' , null)->get();
       return CategoryCollection::make($categories);

    }
    public function indexPageCategoriesWithPosts(){
        $categories_with_posts = Category::with(['posts'=>function ($q){
            $q->with('user')->limit(2);
        }])->get();
        return CategoryCollection::make($categories_with_posts);
        

    }
    public function show($id){
        $category=Category::findOrFail($id);
        return CategoryResource::make($category);

    }
}
