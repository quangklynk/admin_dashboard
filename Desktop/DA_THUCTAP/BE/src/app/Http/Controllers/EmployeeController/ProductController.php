<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\List_Image;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProduct (){
        // $data = Product::all();
        $data = Product::with('category:id,name', 'listImage:id,image,idProduct')->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function createProduct(Request $request){

        if ($request->imgAvatar) {
            $file = $request->file('imgAvatar')->getClientOriginalName();
            // $filename = pathinfo($file, PATHINFO_FILENAME); đuôi file
            $filenameA = date('Y_m_d_H_i_s');
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $filename = "SP_A"  .  $filenameA . "." . $extension;
        }
        DB::beginTransaction();
        try {
            $pro = Product::updateOrCreate(
                ['id' => $request->id],
                [
                    'name' => $request->name,
                    'price' => $request->price,
                    'discount' => $request->discount,
                    'unit' => $request->unit,
                    'description' => $request->description,
                    'remark' => $request->remark,
                    'avatar' => $filename,
                    'view' => 0,
                    'idCategory' => $request->idCategory,
                    'flag' => 1,
                 ],
            );
            $request->file('imgAvatar')->move(public_path("/image/product"), $filename);
            
            if ($request->img1) {
                $file = $request->file('img1')->getClientOriginalName();
                $filename = date('Y_m_d_H_i_s');
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $filename = "SP_1" . $request->idProduct . $filename . "." . $extension;
                DB::table('list__images')->insert(
                            [
                                'image' => $filename,
                                'idProduct' => $pro->id
                            ],
                );
                $request->file('img1')->move(public_path("/image/product"), $filename);
            }

            if ($request->img2) {
                $file = $request->file('img2')->getClientOriginalName();
                $filename = date('Y_m_d_H_i_s');
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $filename = "SP_2" . $request->idProduct . $filename . "." . $extension;
                DB::table('list__images')->insert(
                            [
                                'image' => $filename,
                                'idProduct' => $pro->id
                            ],
                );
                $request->file('img2')->move(public_path("/image/product"), $filename);
            }
            if ($request->img3) {
                $file = $request->file('img3')->getClientOriginalName();
                $filename = date('Y_m_d_H_i_s');
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $filename = "SP_3" . $request->idProduct . $filename . "." . $extension;
                DB::table('list__images')->insert(
                            [
                                'image' => $filename,
                                'idProduct' => $pro->id
                            ],
                );
                $request->file('img3')->move(public_path("/image/product"), $filename);
            }
            if ($request->img4) {
                $file = $request->file('img4')->getClientOriginalName();
                $filename = date('Y_m_d_H_i_s');
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $filename = "SP_4" . $request->idProduct . $filename . "." . $extension;
                DB::table('list__images')->insert(
                            [
                                'image' => $filename,
                                'idProduct' => $pro->id
                            ],
                );
                $request->file('img4')->move(public_path("/image/product"), $filename);
            }
            
            DB::commit();
            return response()->json(['status' => 'successful',
                                     'messege' => 'ok']);
        } catch (Exception $th) {
            DB::rollBack();
            return  response()->json(['status' => 'failed',
                                    'messege' => $th]);
        }
    }

    public function getProductByID($id){
        $data = Product::with('category:id,name', 'listImage:id,image,idProduct')->where('id', $id)->first();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty Element']);
    }

    public function updateProductWithNotImage(Request $request, $id) {
        try {
            Product::where('id', $id)
                ->update(['name' => $request->name,
                          'price' => $request->price,
                          'discount' => $request->discount,
                          'unit' => $request->unit,
                          'description' => $request->description,
                          'remark' => $request->remark,
                          'idCategory' => $request->idCategory,
                        ]);
             return response()->json(['status' => 'successful']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed',
                                     'error' => $th]);
        }
    }


    // gửi 1-> 5 tấm hình, kt request, tạo chỉ tạo 1 cái avatar theo product, sửa thêm hình list_image
    public function updateProductImage(Request $request){
        //request: idPro, 
        DB::beginTransaction();
        try {

            // if ($request->imgAvatar) {
                $file = $request->file('imgAvatar')->getClientOriginalName();
                // $filename = pathinfo($file, PATHINFO_FILENAME); đuôi file
                $filenameA = date('Y_m_d_H_i_s');
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $filename = "SP_A"  .  $filenameA . "." . $extension;

                Product::updateOrCreate(
                    ['id' => $request->idPro],
                    [
                        'avatar' => $filename,
                     ],
                );

            // }
        
            // if ($request->img1) {
            //     $file = $request->file('img1')->getClientOriginalName();
            //     $filename = date('Y_m_d_H_i_s');
            //     $extension = pathinfo($file, PATHINFO_EXTENSION);
            //     $filename = "SP_1" . $request->idProduct . $filename . "." . $extension;
            //     List_Image::updateOrCreate(
            //                 ['id' => $request->idImg1],
            //                 [
            //                     'image' => $filename,
            //                     'idProduct' => $request->idPro,
            //                 ],
            //     );
            //     $request->file('img1')->move(public_path("/image/product"), $filename);
            // }

            // if ($request->img2) {
            //     $file = $request->file('img2')->getClientOriginalName();
            //     $filename = date('Y_m_d_H_i_s');
            //     $extension = pathinfo($file, PATHINFO_EXTENSION);
            //     $filename = "SP_2" . $request->idProduct . $filename . "." . $extension;
            //     List_Image::updateOrCreate(
            //         ['id' => $request->idImg2],
            //         [
            //             'image' => $filename,
            //             'idProduct' => $request->idPro,
            //         ],
            //     );
            //     $request->file('img2')->move(public_path("/image/product"), $filename);
            // }
            // if ($request->img3) {
            //     $file = $request->file('img3')->getClientOriginalName();
            //     $filename = date('Y_m_d_H_i_s');
            //     $extension = pathinfo($file, PATHINFO_EXTENSION);
            //     $filename = "SP_3" . $request->idProduct . $filename . "." . $extension;
            //     List_Image::updateOrCreate(
            //         ['id' => $request->idImg3],
            //         [
            //             'image' => $filename,
            //             'idProduct' => $request->idPro,
            //         ],
            //     );
            //     $request->file('img3')->move(public_path("/image/product"), $filename);
            // }
            // if ($request->img4) {
            //     $file = $request->file('img4')->getClientOriginalName();
            //     $filename = date('Y_m_d_H_i_s');
            //     $extension = pathinfo($file, PATHINFO_EXTENSION);
            //     $filename = "SP_4" . $request->idProduct . $filename . "." . $extension;
            //     List_Image::updateOrCreate(
            //         ['id' => $request->idImg4],
            //         [
            //             'image' => $filename,
            //             'idProduct' => $request->idPro,
            //         ],
            //     );
            //     $request->file('img4')->move(public_path("/image/product"), $filename);
            // }
            
            DB::commit();
            return response()->json(['status' => 'successful1',
                                     'messege' => 'ok']);
        } catch (Exception $th) {
            DB::rollBack();
            return  response()->json(['status' => 'failed',
                                    'messege' => $th]);
        }
    }
   
    public function deleteProductByID($id){
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

    public function backProductByID($id){
        try {
            DB::table('products')
              ->where('id', $id)
              ->update(['flag' => 1]);
            return response()->json(['status' => 'successful']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed',
                                     'error' => $th]);
        }
    }



    public function sreachByCate(Request $request) {
        //request: idCate
        $cate = $request->idCate;

        $data = Product::with('category:id,name', 'listImage:id,image,idProduct')->where('idCategory', $cate)->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function sreachByPrice(Request $request) {
        $data = Product::with('category:id,name', 'listImage:id,image,idProduct')->where('price','>=', $request->from)->where('price', '<=', $request->to)->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function sreachByName(Request $request) { // có thể thêm mới, tinh chỉnh sau, 
        $data = Product::with('category:id,name', 'listImage:id,image,idProduct')->where('name','like', $request->name)->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }   
}
