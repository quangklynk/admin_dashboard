<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnterSticker;
use App\Models\DetailEnterSticker;
use App\Models\Product;

class EnterStickerController extends Controller
{
    public function enterSticker (Request $request) {
        DB::beginTransaction();
        try {
            $date = date("Y/m/d");
            $sticker = EnterSticker::updateOrCreate([
                ['id' => $request->id],
                [
                    'dateAdd' => $date,
                    'idEmployee' => $request->idEmployee,
                ]
            ]);

            $list1 = $request->list;

            foreach ($list1 as $item) {
                DetailEnterSticker::updateOrCreate([
                    [
                        'idSticker' => $sticker->id,
                        'idProduct' => $item->idProduct,
                    ],
                    [
                        'unit' => $item->unit,
                        'price' => $item->price,
                    ]
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

    public function moveDetailsToProduct ($id) {
        DB::beginTransaction();
        try {
            $enterSticker = EnterSticker::where('id', $id)->update(['flag' => 1]);

            $listDetailsEnterSticker = DetailEnterSticker::where('idSticker', $id)->get();

            foreach ($listDetailsEnterSticker as $item) {
                Product::where('id', $item->idProduct)->update([
                    'unit' => $item->unit,
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
}
