<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        //$posts = Post::get(); //return collection, all of it

        //return pagination xx per page, not all from db, but 2
        // with() is used for eager loading, it loads relationships together with collection of posts
        $posts = Post::with(['user', 'likes'])->paginate(20);
        
        return view('posts.index', [
            'posts' => $posts
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
}
