<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function getBlog (){
        $data = Blog::all();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function createBlog(Request $request){
        try {
            DB::table('blog')->updateOrInsert(
                ['id' => $request->id],
                [
                    'image' => $request->image,
                    'titleBlog' => $request->titleBlog,
                    'content' => $request->content,
                    'idEmployee' => $request->idEmployee
                 ],
            );
            return response()->json(['status' => 'successful',
                                     'messege' => 'Add Blog Success']);
        } catch (\Throwable $th) {
            return  response()->json(['status' => 'failed',
                                    'messege' => 'Add Blog Failed']);
        }
    }

    public function getBlogByID($id){
        $data = Blog::where('id', $id)->first();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty Element']);
    }

    public function deleteBlogByID($id){
        try {
            DB::table('blog')->where('id', $id)->delete();
            return response()->json(['status' => 'successful']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed',
                                     'error' => $th]);
        }
    }

    // public function deleteBlogByID($id){
    //     try {
    //         DB::table('blog')
    //           ->where('id', $id)
    //           ->update(['flag' => 0]);
    //         return response()->json(['status' => 'successful']);
    //     } catch (\Throwable $th) {
    //         return response()->json(['status' => 'failed',
    //                                  'error' => $th]);
    //     }
    // }

}
