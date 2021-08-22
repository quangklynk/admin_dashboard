<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Product;
use App\Models\Detail_Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function getAllOrder()
    {
        $data = Orders::with('detailOrder:idOrder,unit,price,idProduct', 'status:id,description')->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function confirmOrder($id)
    {
        DB::beginTransaction();
        try {
        if ($od = Orders::where(['id' => $id, 
                            'idStatus' => 1])
                ->update(['idStatus' => 2])) 
            {
                DB::commit();
                return response()->json(['status' => 'lưu ok']);
            }
            DB::rollBack();
            return response()->json(['status' => 'failed1',
                                     'error' => 'Không đổi được']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed1',
                                     'error' => $e]);
        }
    }

    public function completeOrder($id)
    {
        DB::beginTransaction();
        try {
        if ($od = Orders::where(['id' => $id, 
                            'idStatus' => 2])
                ->update(['idStatus' => 3])) 
            {
                DB::commit();
                return response()->json(['status' => 'lưu ok']);
            }
            DB::rollBack();
            return response()->json(['status' => 'failed1',
                                     'error' => 'Không đổi được']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed1',
                                     'error' => $e]);
        }
    }
}
