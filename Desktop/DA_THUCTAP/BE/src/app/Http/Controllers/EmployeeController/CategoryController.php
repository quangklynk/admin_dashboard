<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function getCategory (){
        $data = DB::table('categories')
            ->join('distributors', 'distributors.id', '=', 'categories.idDistributor')
            ->join('manufacturers', 'manufacturers.id', '=', 'categories.idManufacturers')        
            ->select('categories.id', 'categories.name', 'manufacturers.name as idManufacturers', 'distributors.name as idDistributor')
            ->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function getCategory1 (){
        $data = DB::table('categories')
            ->join('distributors', 'distributors.id', '=', 'categories.idDistributor')
            ->join('manufacturers', 'manufacturers.id', '=', 'categories.idManufacturers')        
            ->select('categories.id', 'categories.name', 'manufacturers.name as idManufacturers', 'distributors.name as idDistributor')
            ->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function createCategory(Request $request){
        try {
            DB::table('categories')->updateOrInsert(
                ['id' => $request->id],
                [
                    'name' => $request->name,
                    'idManufacturers' => $request->idManufacturers,
                    'idDistributor' => $request->idDistributor,
                    'flag' => '1'
                 ],
            );
            return response()->json(['status' => 'successful',
                                     'messege' => 'Add Category Success']);
        } catch (\Throwable $th) {
            return  response()->json(['status' => 'failed',
                                    'messege' => 'Add Category Failed']);
        }
    }

    public function getCategoryByID($id){
        $data = Category::where('id', $id)->first();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty Element']);
    }

    public function deleteCategoryByID($id){
        try {
            DB::table('categories')->where('id', $id)->delete();
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
