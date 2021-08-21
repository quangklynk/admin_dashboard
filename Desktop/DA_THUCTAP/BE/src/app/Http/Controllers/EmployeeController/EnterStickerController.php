<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnterSticker;
use App\Models\DetailEnterSticker;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class EnterStickerController extends Controller
{
    public function getEnterSticker (){
        // $data = EnterSticker::all();
        $data = DB::table('enter_stickers')
        ->join('employees', 'enter_stickers.idEmployee', '=', 'employees.id')
        ->join('detail_enter_stickers', 'enter_stickers.id', '=', 'detail_enter_stickers.idSticker')
        ->join('products', 'products.id', '=', 'detail_enter_stickers.idProduct')
        ->select('enter_stickers.id',   'enter_stickers.flag', 'enter_stickers.dateAdd', 'employees.name as idEmployee', 'detail_enter_stickers.price', 'detail_enter_stickers.unit', 'products.name')
        ->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function enterSticker (Request $request) {
        DB::beginTransaction();
        try {
            $date = date("Y-m-d");
            $sticker = EnterSticker::updateOrCreate(
                ['id' => $request->id],
                [
                    'dateAdd' => $date,
                    'idEmployee' => $request->idEmployee,
                    'flag' => '0',
                ]
            );
          
            $list1 = $request->list;

            foreach ($list1 as $item) {
                DetailEnterSticker::updateOrCreate(
                    [
                        'idSticker' => $sticker->id,
                        'idProduct' => $item['idProduct'],
                    ],
                    [
                        'unit' => $item['unit'],
                        'price' => $item['price'],
                    ]
                );
            }

            DB::commit();
            return response()->json(['status' => $list1]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed1',
                                     'error' => $e]);
        }
    }

    public function moveDetailsToProduct ($id) {
        DB::beginTransaction();
        try {
            
            $enterSticker = EnterSticker::where('id', $id)->first();
            if ($enterSticker->flag == 1) {
                return response()->json(['status' => 'failed',
                'error' => 'saiiiii']);
            }

            $enterSticker = EnterSticker::where('id', $id)->update(['flag' => 1]);

            $listDetailsEnterSticker = DetailEnterSticker::where('idSticker', $id)->get();

            foreach ($listDetailsEnterSticker as $item) {
                $temp = Product::where('id', $item->idProduct)->first();
                Product::where('id', $item->idProduct)->update([
                    'unit' => $item->unit + $temp->unit,
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'successful']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed',
                                     'error' => $e]);
        }
    }

    public function deleteEnterStickerByID($id){
        try {
            $check = DB::table('enter_stickers')->where('id', $id);
            if ($check->flag == 0) {
                $check->delete();
            } else {
                return response()->json(['status' => 'failed']);
            }
            return response()->json(['status' => 'successful']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed',
                                     'error' => $th]);
        }
    }
}
