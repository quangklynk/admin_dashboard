<?php

namespace App\Http\Controllers\_AuthController;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    public function login (Request $request) {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $user = User::where('email', $request->email)->first();
            $data = DB::table('users')
            ->join('employees', 'users.id', '=', 'employees.idUser')
            ->join('roles', 'roles.id', '=', 'users.idRole')        
            ->select('employees.id', 'users.flag', 'employees.name', 'roles.role_name')
            ->where('users.email', $request->email)
            ->first();

            $tokenData = $user->createToken($user->email.'-'.now(), [$data->role_name]);
            $user->accessToken = $tokenData->accessToken;

            return response()->json(['data' => $data, 'token' => $user->accessToken]);
        }

        
        return response()->json(['email' => 'Sai ten truy cap hoac mat khau!'], 401);
    }
}//trả về quyền tên idnhân viên