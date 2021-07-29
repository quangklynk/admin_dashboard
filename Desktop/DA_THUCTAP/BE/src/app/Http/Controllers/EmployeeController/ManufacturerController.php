<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manufacture;
use Illuminate\Support\Facades\DB;


class ManufacturerController extends Controller
{
    public function getManufacturer (){
        $data = Manufacturer::all();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function createManufacturer(Request $request){
        try {
            DB::table('manufacturers')->updateOrInsert(
                ['id' => $request->id],
                [
                    'name' => $request->name,
                 ],
            );
            return response()->json(['status' => 'successful',
                                     'messege' => 'Add Manufacturer Success']);
        } catch (\Throwable $th) {
            return  response()->json(['status' => 'failed',
                                    'messege' => 'Add Manufacturer Failed']);
        }
    }

    public function getManufacturerByID($id){
        $data = Manufacturer::where('id', $id)->first();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty Element']);
    }

    public function deleteManufacturerByID($id){
        try {
            DB::table('manufacturers')->where('id', $id)->delete();
            return response()->json(['status' => 'successful']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed',
                                     'error' => $th]);
        }
    }
}
