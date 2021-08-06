<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function getRole (){
        $data = Role::all();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }
}
