<?php

namespace App\Http\Controllers\CustomerController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
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
        } catch (Exception $th) {
            return response()->json(['status' => 'failed',
                                     'error' => $th]);
        }
    }

}
