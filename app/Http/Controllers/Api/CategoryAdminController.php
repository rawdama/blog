<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Setting;
use App\Http\Resources\CategoryResource;

class CategoryAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $setting;
    public function __construct( Setting $setting)
    {
        $this->setting = $setting;
    }
    public function index()
    {
        //
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
        
        $this->authorize('viewAny', $this->setting);
        $category =  Category::create($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;
            $category->update(['image' => $path]);
        }
        return CategoryResource::make($category);
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, Category $CategoryAdmin)
    {
        $this->authorize('viewAny', $this->setting);
        $id=$CategoryAdmin->id;
        $CategoryAdmin->update($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;

            $CategoryAdmin->update(['image' => $path]);
        }
        $CategoryAdmin=Category::find($id);
        return CategoryResource::make($CategoryAdmin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Category $CategoryAdmin)
    {
         $CategoryAdmin->delete();
         return response()->json('deleted successfully');
    }
}
