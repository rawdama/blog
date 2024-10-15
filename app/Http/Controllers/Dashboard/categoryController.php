<?php

namespace App\Http\Controllers\Dashboard;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\CategoryTranslation;

class categoryController extends Controller
{
    protected $setting;
    public function __construct( Setting $setting)
    {
        $this->setting = $setting;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('dashboard.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('viewAny', $this->setting);
        $categories = Category::all();
        return view('dashboard.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->authorize('viewAny', $this->setting);
        $category =  Category::create($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;
            $category->update(['image' => $path]);
        }
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     */

        public function show(Category $category)
        {   
            $category = $category->load('children');
            $posts = Post::where('category_id' , $category->id)->paginate(15);
            
            return view('website.category' , compact('category','posts'));
        }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        $this->authorize('viewAny', $this->setting);
        $categories = Category::whereNull('parent')->orWhere('parent', 0)->get();
        return view('dashboard.categories.edit', compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $this->authorize('viewAny', $this->setting);
        $category->update($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;

            $category->update(['image' => $path]);
        }
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getCategoryDataTable(){
    
        $data=Category::select('*')->with('getParent');
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('title', function ($row) {
            foreach ($row->translations as $translation) {
                if ($translation->locale === app()->getLocale()) {
                    return $translation->title ?? 'No Title Available';
                }
            }
            return 'No Title Available';
        })
        ->addColumn('status', function ($row) {
            return $row->status == null ? __('words.not activated') : __('words.' . $row->status);
        })
        

        ->addColumn('action', function ($row) {
            if (auth()->user()->can('viewAny', $this->setting)){
                return $btn='<a href="' . Route('category.edit', $row->id) . '"  class="edit btn btn-success btn-sm" ><i class="fa fa-edit"></i></a>
                <a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm"  data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>';
            }
          
            
        })
        ->addColumn('parent', function ($row) {
            if ($row->parent == 0) {
                return trans('words.main category');
            }
            $parent = $row->parents;
            return $parent ? $parent->translate(app()->getLocale())->title : 'sub category';
        })
        ->addColumn('title', function ($row) {
            $translation = $row->translate(app()->getLocale());
            return $translation ? $translation->title : 'No Title Available';
        })
        ->rawColumns(['action','title','status'])
        ->make(true);
        
        }
        public function delete(Request $request)
    {
        
        $this->authorize('viewAny', $this->setting);
        if (is_numeric($request->id)) {
            Category::where('parent', $request->id)->delete();
            Category::where('id', $request->id)->delete();
        }

        return redirect()->route('category.index');
    }
        
}
