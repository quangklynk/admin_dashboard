<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProduct (){
        $data = Product::all();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function createProduct(Request $request){
        try {
            DB::table('products')->updateOrInsert(
                ['id' => $request->id],
                [
                    'name' => $request->name,
                    'price' => $request->price,
                    'discount' => $request->discount,
                    'unit' => $request->unit,
                    'description' => $request->description,
                    'remark' => $request->remark,
                    'avatar' => $request->avatar,
                    'view' => 0,
                    'idCategory' => $request->idCategory,
                    'idDistributor' => $request->idDistributor,
                    'flag' => 1,
                 ],
            );
            return response()->json(['status' => 'successful',
                                     'messege' => 'Add Product Success']);
        } catch (\Throwable $th) {
            return  response()->json(['status' => 'failed',
                                    'messege' => 'Add Product Failed']);
        }
    }

    public function getProductByID($id){
        $data = Product::where('id', $id)->first();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty Element']);
    }

    public function deleteBlogByID($id){
        try {
            DB::table('products')
              ->where('id', $id)
              ->update(['flag' => 0]);
            return response()->json(['status' => 'successful']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed',
                                     'error' => $th]);
        }
    }
}
