<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    
    public function create(Request $request){
        
        $post = Post::create($request->all());
        
        return response()->json($post);
    }
    
    public function update(Request $request, $id){
        
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->views = $request->input('views');
        $post->save();
        
        return response()->json($post);
    }
    public function view( $id){
        
        $post = Post::find($id);
        
        return response()->json($post);
    }
    
    public function delete( $id){
        
        $post = Post::find($id);
        $post->delete();
        
        return response()->json('Removed successfully.');
    }
    
    public function index(){
        
        $post = Post::all();
        
        return response()->json($post);
    }
}
