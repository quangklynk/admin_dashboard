<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use Illuminate\Support\Facades\DB;

class SlideController extends Controller
{
    public function getSlide (){
        $data = Slide::all();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function createSlide(Request $request){
        try {
            DB::table('slides')->updateOrInsert(
                ['id' => $request->id],
                [
                    'image' => $request->image,
                    'idEmployee' => $request->idEmployee
                 ],
            );
            return response()->json(['status' => 'successful',
                                     'messege' => 'Add Slide Success']);
        } catch (\Throwable $th) {
            return  response()->json(['status' => 'failed',
                                    'messege' => 'Add Slide Failed']);
        }
    }

    public function getSlideByID($id){
        $data = Slide::where('id', $id)->first();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty Element']);
    }

    public function deleteSlideByID($id){
        try {
            DB::table('slides')->where('id', $id)->delete();
            return response()->json(['status' => 'successful']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'failed',
                                     'error' => $th]);
        }
    }
}
