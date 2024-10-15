<?php

namespace App\Http\Controllers\Api;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated =Validator::make($request->all(),[
            'category_id' => 'required|integer|exists:categories,id',
        ]);
        if($validated->fails()){
            return response()->json(['error' => $validated->errors()], 422);
        }
       // dd($request->all());
        $posts=Post::with('category')->where('category_id',$request->category_id)->paginate(25);
        return PostResource::collection($posts);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $post=Post::findOrFail($id);
        return PostResource::make($post);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
