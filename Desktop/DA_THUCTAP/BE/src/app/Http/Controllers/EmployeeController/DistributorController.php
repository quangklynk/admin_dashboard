<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;
use Illuminate\Support\Facades\DB;

class DistributorController extends Controller
{
    public function getDistributor (){
        $data = Distributor::all();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function createDistributor(Request $request){
        try {
            DB::table('distributors')->updateOrInsert(
                ['id' => $request->id],
                [
                    'name' => $request->name,
                    'address' => $request->address,
                    'email' => $request->email,
                ],
            );
            return response()->json(['status' => 'successful',
                                     'messege' => 'Add Distributor Success']);
        } catch (\Throwable $th) {
            return  response()->json(['status' => 'failed',
                                    'messege' => 'Add Distributor Failed']);
        }
    }

    public function getDistributorByID($id){
        $data = Distributor::where('id', $id)->first();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty Element']);
    }

    public function deleteDistributorByID($id){
        try {
            DB::table('distributors')
              ->where('id', $id)
              ->update(['flag' => 0]);
            return response()->json(['status' => 'successful']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed',
                                     'error' => $th]);
        }
    }
}
