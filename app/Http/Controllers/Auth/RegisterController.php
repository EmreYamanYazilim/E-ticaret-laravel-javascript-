<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegisterEvent;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Cache;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    //RegisterRequest  olarak özel request'te hazırladım ama ben backend tarafından değil  frontendt tarafından gelen uyarıları yaptığım yoldan devam edeceğim
    public function register(RegisterRequest $request)
    {

        $data = $request->only('name', 'email', 'password');

        $user = User::create(attributes: $data);
        event(new UserRegisterEvent($user));
        dd("Event Çalıştı");

    }

    public function verify(Request $request)
    {
        $userID = Cache::get('verify_token_' . $request->token);

        if (!$userID) {
            dd('user yok');
        }
        $user = User::findOrFail($userID);
        $user->email_verified_at = now();
        $user->save();
        //gelen tokeni silme işlemi
        Cache::forget('verify_token_' . $request->token);
        dd('E-posta doğrulama başarılı');
    }

}