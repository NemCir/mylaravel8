<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'])->only(['store', 'destroy']);
        //Only auth users can add/delete posts, all other can see them
    }

    public function index() {
        //$posts = Post::get(); //return collection, all of it

        //return pagination xx per page, not all from db, but 2
        // with() is used for eager loading, it loads relationships together with collection of posts
        //$posts = Post::orderBy('created_at', 'desc')->with(['user', 'likes'])->paginate(20);
        $posts = Post::latest()->with(['user', 'likes'])->paginate(20);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post) {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'body' => 'required'
        ]);

        /*auth()->user()->posts()->create([
            'body' => $request->body
        ]);*/
        auth()->user()->posts()->create($request->only('body'));

        return back();
    }

    public function destroy(Post $post) {

        $this->authorize('delete', $post); //delete is method name in PostPolicy

        $post->delete();

        return back();
    }
}
