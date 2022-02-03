<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('blog.index')->with('posts', Posts::orderBy('updated_at', 'DESC')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048'
        ]);

        $newImageName = uniqid().'-'.$request->title.'.'.$request->image->extension();
        $request->image->move(public_path('images'), $newImageName);
        
        $table = new Posts;
        $table->title = $request->title;
        $table->description = $request->description;
        $table->image_path = $newImageName;
        $table->user_id = auth()->user()->id;
        $table->save();

        return redirect('/blog')->with('message', 'Your post has been added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $title
     * @return \Illuminate\Http\Response
     */
    public function show($title)
    {
        return view('blog.show')->with('post', Posts::firstWhere('title', $title));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($title)
    {
        return view('blog.edit')->with('post', Posts::firstWhere('title', $title));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $title)
    {
        Posts::where('title', $title)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect('/blog')->with('message', 'Your post has been updateded !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($title)
    {
        $post = Posts::where('title', $title);
        $post->delete();

        return redirect('/blog')->with('message', 'Your post has been deleted !');
    }
}
