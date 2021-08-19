<?php

namespace App\Http\Controllers\CustomerController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{

    public function getCustomer (){
        // $data = Customer::all();
        $data = DB::table('customers')
            ->join('users', 'users.id', '=', 'customers.idUser')   
            ->select('customers.id', 'users.email' ,'users.flag', 'customers.name', 'customers.address', 'customers.phone', 'customers.image')
            ->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function getCustomerByID($id){
        $data =  DB::table('customers')
                ->join('users', 'users.id', '=', 'customers.idUser')
                ->select('customers.id', 'users.email' , 'customers.name','customers.phone', 'customers.address', 'customers.image')
                ->where('customers.id', $id)->first();
        if($data){
            return response()->json(['status' => 'khách hàng nè',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty Element']);
    }


    public function updateCustomerWithNotImage(Request $request) {
        try {
            Customer::where('id', $request->id)
                ->update(['name' => $request->name,
                          'address' => $request->address,
                          'phone' => $request->phone]);
             return response()->json(['status' => 'successful']);
        } catch (Exception $th) {
            return response()->json(['status' => 'failed',
                                     'error' => $th]);
        }
    }


    public function updateCustomerWithImage(Request $request) {
        $file = $request->file('image')->getClientOriginalName();
        // $filename = pathinfo($file, PATHINFO_FILENAME); đuôi file
        $filename = date('Y_m_d_H_i_s');
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $filename = "KH_" . $request->name .  $filename . "." . $extension;
        try {
            Customer::where('id', $request->id)
                ->update(['image' => $filename]);
            $path = $request->file('image')->move(public_path("/image/customer"), $filename);
            return response()->json(['status' => 'successful']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed',
                                     'error' => $e]);
        }
    }

    public function addToCart(Request $request) {
        try {
            Cart::updateOrCreate(
                [
                    'idCustomer' => $request->idCustomer,
                    'idProduct' =>$request->idProduct
                ],
                [
                    'unit' => $request->unit,
                ],
            );
            return response()->json(['status' => 'successful']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed',
                                     'error' => $e]);
        }
    }

    public function showCart($id) {
        try {
            $data = DB::table('carts')
                ->join('products', 'carts.idProduct', '=', 'products.id')
                ->select('products.name', 'products.price', 'carts.unit')
                ->where('carts.idCustomer', $id)
                ->get();
            return response()->json(['status' => 'successful']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed',
                                     'error' => $e]);
        }
    }

    
    public function deleteCustomerByID($id){
        try {
            DB::table('users')
              ->where('email', $id)
              ->update(['flag' => 0]);
            return response()->json(['status' => 'successful']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed',
                                     'error' => $th]);
        }
    }

}
