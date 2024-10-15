<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Trait\UploadImage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class postsController extends Controller
{
    use UploadImage;
    protected $postmodel;
    public function __construct(Post $post) {
        $this->postmodel = $post;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('dashboard.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        if (count($categories)>0) {
            return view('dashboard.posts.create' , compact('categories'));
        }
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $post = Post::create(array_merge(
            $request->except('image', '_token'),
            ['user_id' => auth()->user()->id]
        ));
        if ($request->has('image')) {
           $post->update(['image'=>$this->upload($request->image)]);
        }
       return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('website.post' , compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update' , $post);
        $categories = Category::all();
       return view('dashboard.posts.edit' , compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update' , $post);
        $post->update($request->except('image','_token'));
        $post->update(['user_id'=>auth()->user()->id]);
        if ($request->has('image')) {
            $post->update(['image'=>$this->upload($request->image)]);
         }
         return redirect()->route('post.index' , $post);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getPostDataTable()
    {

        $data = Post::select('*')->with('category');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if(auth()->user()->can('update',$row )){return '
                    <a href="' . route('post.edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                    <a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm" data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>
                ';}else{
                    return;
                }
                
            })
            ->addColumn('category_name', function ($row) {
                return $row->category->translate(app()->getLocale())->title;
            })
            ->addColumn('title', function ($row) {
                return $row->translate(app()->getLocale())->title;
            })
            ->rawColumns(['action', 'title', 'category_name'])
            ->make(true);
            
    }
    public function delete (Request $request)
    {

        $this->authorize('update' , $post);
       if(is_numeric($request->id)){
           Post::where('id' , $request->id)->delete();
       }
       return redirect()->route('post.index');
    }

}
