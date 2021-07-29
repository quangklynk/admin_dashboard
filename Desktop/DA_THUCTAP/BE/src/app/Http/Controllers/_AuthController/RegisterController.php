<?php

namespace App\Http\Controllers\_AuthController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\User;
use App\Models\Employee;

class RegisterController extends Controller
{
    public function register (Request $request) {
        $user = new User;
        // $user->fill($request->all());

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
        $employee->image = $request->image;
        $employee->idUser = $user_temp->id;
        $employee->save();

        return response()->json(['status' => 'successful']);
    }
}
