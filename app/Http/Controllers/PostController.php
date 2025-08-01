<?php

namespace App\Http\Controllers;


use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use \Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Gate;
class PostController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [
            new Middleware('auth:sanctum',except:['index','show'])
        ];
    }
    public function index()
    {
        return Post::with('user')->latest()->get();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields=$request->validate([
            "title"=> "required|max:255",
            "body"=> "required",
        ]);
        $post=$request->user()->Posts()->create($fields);
        return ['post' => $post,'user' => $post->user];
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return ['post' => $post,'user' => $post->user];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize(
            'modify',$post
        );
        $fields=$request->validate([
            "title"=> "required",
            "body"=> "required",
        ]);
        $post->update($fields);
        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
         Gate::authorize(
            'modify',$post
        );
        $post->delete();
        return response()->json(null,200);
    }
}
