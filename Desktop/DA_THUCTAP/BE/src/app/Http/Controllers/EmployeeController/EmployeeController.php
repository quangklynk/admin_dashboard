<?php

namespace App\Http\Controllers\EmployeeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\User;

class EmployeeController extends Controller
{
    public function getEmployee (){
        $data = DB::table('employees')
            ->join('users', 'users.id', '=', 'employees.idUser')
            ->join('roles', 'roles.id', '=', 'users.idRole')        
            ->select('employees.id', 'users.email' ,'users.flag', 'employees.name', 'roles.role_name', 'employees.address', 'employees.image')
            ->get();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty List']);
    }

    public function getEmployeeByID($id){
        $data = Employee::where('id', $id)->first();
        if($data){
            return response()->json(['status' => 'successful',
                                    'data' => $data]);
        }
        return  response()->json(['status' => 'failed',
                                    'messege' => 'Empty Element']);
    }

    // public function deleteEmployeeByID($id){
    //     try {
    //         DB::table('employees')->where('id', $id)->delete();
    //         return response()->json(['status' => 'successful']);
    //     } catch (\Throwable $th) {
    //         return response()->json(['status' => 'failed',
    //                                  'error' => $th]);
    //     }
    // }

    public function deleteEmployeeByID($id){
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
