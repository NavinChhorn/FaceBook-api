<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts =Post::all();
        if(count($posts)==0){
            return response()->json(['message'=>'No data','data'=>'null']);
        }
        return response()->json(['message'=>'success','data'=>$posts],200);
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
        $validator =Validator::make($request->all(),[
            'title'=>'required|max:50',
            'descr'=>'min:5',
            'user_id'=>'required',
        ]);
        if ($validator->fails()){
            return $validator->errors();
        }
        $post = Post::create($validator->validated());
        
        return response()->json(["message"=>"post created successfully", 'data'=>$post],200);

    }
        
        
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $user= User::find($id)->post;
        return $user;
    }

    
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:50',
            'descr'=>'min:5',
            'user_id'=>'required',

        ]);

        if($validator->fails()){
           
            return $validator->errors();
        }
        else{
            $post = Post::find($id);
            $post->update([
                'title'=> $request->input('title'),
                'descr'=>$request->input('descr'),
                'user_id'=>$request->input('user_id'),
            ]);
        }
        return response()->json(['success'=>true,'data'=>$post],200);
    }


    public function destroy( $id)
    {
        if($id!=null){
            $post = Post::find($id);
            $post->delete();
            return response()->json(['message'=>'success'],200);
        }
        

    }
}
