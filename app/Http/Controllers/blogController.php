<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class blogController extends Controller
{
    public function getAllBlog()
    {
        
        try{
          $blog = Blog::orderBy('id', 'desc')->with('category')->get();
         
          if($blog){
            return response()->json([
                'message' => 'true',
                'data' => $blog
            ], 200);
          }
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'false',
                'error' => $e.getMessage(),
            ]);

        }
        
        
        //
        $blog = Blog::all();
        
    }

    public function addBlog(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required|string|max:255|unique:blogs',
            'description' => 'required|string|max:255',
            'requirements' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'category_id' => 'required'
           
        ]);
        $blog = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'link' => $request->link,
            'category_id' => $request->category_id,
            
        ]);
        
        $res = [
            'data' => $blog
        ];
        return Response()->json($res, 200);
    }

    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'title' => 'required|string|max:255|unique:blogs',
            'description' => 'required|string|max:255',
            'requirements' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'category_id' => 'required'
           
        ]);
        $blog = Blog::findOrFail($id);
       
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->requirements = $request->requirements;
        $blog->link = $request->link;
        $blog->category_id = $request->category_id;
        $blog->save();

        return response()->json([
            'message' => 'blog updated successfully',
            'data' => $blog
        ], 200);
        
    }

    public function destroy($id)
    {
        //
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return response()->json([
            'message' => 'Blog deleted Successfully',
            'data' => $blog
        ], 200);
    }

    public function search($search){
        try {
            $blog = Blog::where('title', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
            if($blog){
                return response()->json([
                    'success' => 'true',
                    'data' => $blog
                ]);
            }

        }
        catch (Exception $e) 
        {
            return response()->json([
                'success' => 'false',
                'data' => $e->getMessage(),
            ]);

        }
    }

    public function show($id)
    {
        try{

            $one = Blog::findOrFail($id)->with('category')->get();
            if($one){
                return response()->json([
                    'message' => 'success',
                    'blog' => $one
                ], 200);

            }
            

        }
        catch(Exception $e){
            return response()->json([
                'message' => 'false',
                'error' => $e.getMessage(),
            ]);

        }
        
    }

}
