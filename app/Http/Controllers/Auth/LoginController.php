<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // $credentials['status'] = 1;   // status eklemek istersek statusuda 1 olanı getirmesini istersek gerekli durumda  kullanılacak
        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember))
        {
            $user = Auth::user();
            // if ($user->email_verified_at !== null)  // alternatif =)
            if (!$user->hasVerifiedEmail())
            {
            // email doğrulanmadıysa method-> içeriği !is_null($this->email_verified_at)
            Auth::logout();
            alert()->warning('Uyarı','Giriş yapabilmeniz için öncelikle mailinizi doğrulamanız gerekmektedir.');
            return redirect()->back();
            }

        }
            $user = Auth::user();
            // deneme olarak hasRole yapıyorum sonra middleware yaparak düzenleyeceğim
            if ($user->hasRole(['super-admin', 'category-manager','product-manager', 'order-manager', 'user-manager']))
            {
                return redirect()->route('admin.index');
            }
            return redirect()->route('index');


            // return redirect()->intended('/admin');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }
}
