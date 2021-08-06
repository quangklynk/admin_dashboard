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
        //$data = Unit::with(['floor:id,numFloor', 'unitType:id,description', 'block:id,description'])->get();
        $data = DB::table('blogs')
        ->join('employees', 'blogs.idEmployee', '=', 'employees.id')
        ->select('blogs.id', 'blogs.image', 'employees.name as idEmployee', 'blogs.titleBlog', 'blogs.content')
        ->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function createBlog(Request $request){
        try {
            $file = $request->file('image')->getClientOriginalName();
            $filename = date('Y_m_d_H_i_s');
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $filename = "NV_" . $request->idEmployee .  $filename . "." . $extension;
            $data = Blog::updateOrCreate(
                ['id' => $request->id],
                [
                    'image' => $filename,
                    'titleBlog' => $request->titleBlog,
                    'content' => $request->content,
                    'idEmployee' => $request->idEmployee,
                 ],
            );
            if($data){
                $path = $request->file('image')->move(public_path("/image/blog"), $filename);
                return response()->json(['status' => 'successful',
                                        'data' => $data]);
            }
        } catch (Exception $e) {
            return  response()->json(['status' => 'failed1',
                                    'messege' => 'Add Blog Faile']);
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
            DB::table('blogs')->where('id', $id)->delete();
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
