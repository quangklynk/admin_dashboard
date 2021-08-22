<?php

namespace App\Http\Controllers\CustomerController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Product;
use App\Models\Detail_Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // --Order
    public function orderCustomer (Request $request) {
        DB::beginTransaction();
        try {
            $date = date("Y-m-d");
            $order = Orders::updateOrCreate(
                ['id' => $request->id],
                [
                    'idUser' => $request->idUser,
                    'idStatus' => '1',
                    'address' => $request->address,
                    'note' => ' ',
                ]
            );
          
            $list1 = $request->list_cart;

            foreach ($list1 as $item) {
                $temp = Product::where('id', $item['idProduct'])->first();
                if ($temp->unit - $item['unit'] > 0) {
                    Product::where('id', $item['idProduct'])->update([
                        'unit' =>  $temp->unit - $item['unit'],
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json(['status' => 'failed1',
                                            'error' => 'Không đủ số lượng']);
                }
                
                Detail_Order::updateOrCreate(
                    [
                        'idOrder' => $order->id,
                        'idProduct' => $item['idProduct'],
                    ],
                    [
                        'unit' => $item['unit'],
                        'price' => $item['price'],
                    ]
                );

                DB::table('carts')
                ->where('idCustomer', $request->idCustomer)
                ->where('idProduct', $item['idProduct'])
                ->delete();
            }

            DB::commit();
            return response()->json(['status' => 'lưu ok']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed1',
                                     'error' => $e]);
        }
    }

    public function getOrder ($id){
        // $data = EnterSticker::all();
        $product = DB::table('detail__orders')
        ->join('orders', 'orders.id', '=', 'detail__orders.idOrder')
        ->join('products', 'detail__orders.idProduct', '=', 'products.id')
        ->select('products.name', 'detail__orders.idProduct', 'products.avatar')
        ->where('orders.idUser', $id)
        ->distinct()
        ->get();
        $data = Orders::with('detailOrder:idOrder,unit,price,idProduct', 'status:id,description')->where('idUser', $id)->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data,
                                    'product' => $product]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    // làm ở đây nha
    public function cancelOrder($id)
    {   //id = idOrder
        # code...
        // idStatus -> 3
        DB::beginTransaction();
        try {

            $od = Orders::where('id', $id)->update(['idStatus' => 3]);
            $d_od = Detail_Order::where('idOrder', $id)->get();

            foreach ($d_od as  $item) {
                $pro = Product::where('id', $item->idProduct)->first();
                $pro->unit = (int)$pro->unit + (int)$item->unit;
                $pro->save();
            }


            DB::commit();
            return response()->json(['status' => 'lưu ok']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed1',
                                     'error' => $e]);
        }


    }
}
