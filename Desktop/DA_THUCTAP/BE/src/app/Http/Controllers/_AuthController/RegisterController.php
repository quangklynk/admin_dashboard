<?php

namespace App\Http\Controllers\_AuthController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\User;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function register (Request $request) {

        $file = $request->file('image')->getClientOriginalName();
        // $filename = pathinfo($file, PATHINFO_FILENAME); đuôi file
        $filename = date('Y_m_d_H_i_s');
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $filename = "NV_" . $request->name .  $filename . "." . $extension;

        $user = new User;
        DB::beginTransaction();
        try { 
            $user->email = $request->email;
            $user->flag = 1;
            $user->idRole = $request->idRole;
            $user->password = Hash::make($request->password);
            $user->save();
    
            $user_temp = User::where('email', $request->email)->first();
    
            $employee = new Employee;
            $employee->name = $request->name;
            $employee->address = $request->address;
            $employee->gender = $request->gender;
            $employee->image = $filename;
            $employee->idUser = $user_temp->id;
            $employee->save();
            
            DB::commit();
            return response()->json(['status' => 'successful']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed',
                                     'error' => $e]);
        }

        
        $path = $request->file('image')->move(public_path("/image/emloyee"), $filename);

        return response()->json(['status' => 'successful']);
    }
}
