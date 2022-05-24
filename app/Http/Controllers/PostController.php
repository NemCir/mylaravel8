<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        //$posts = Post::get(); //return collection, all of it

        $posts = Post::paginate(20);//return pagination 2 per page, not all from db, but 2
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
