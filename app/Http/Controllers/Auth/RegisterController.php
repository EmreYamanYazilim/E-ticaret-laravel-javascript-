<?php

namespace App\Http\Controllers\Auth;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    //RegisterRequest  olarak özel request'te hazırladım ama ben backend tarafından değil  frontendt tarafından gelen uyarıları yaptığım yoldan devam edeceğim
    public function register(RegisterRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // 'password' => Hash::make($request->password),
        ];
        // only ile yanlızca o fieldleri alabileceği anlamına gelir
        $data = $request->only('name', 'email', 'password');
        //execpt Hariç tut alttaki gibi password haricinde tüm verileri tutmaya yaarar
        $data = $request->except('password');
        dd($data);
        return User::create($data);

    }
}