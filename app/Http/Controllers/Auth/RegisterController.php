<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegisterEvent;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
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
        // event(new UserRegisterEvent($user));

        // $remember = $request->has('remember');
        // Auth::login($user, $remember);
        alert()->info('Bilgilendirme', 'Lütfen size gelen bilgilendirmeyi onaylayın');

        return redirect()->back();

    }

    public function verify(Request $request)
    {
        $userID = Cache::get('verify_token_' . $request->token);

        if (!$userID) {
            alert()->warning('Uyarı', 'Tokenin geçerlilik süresi dolmuş');
            return redirect()->route('register');
        }
        // $user = User::findOrFail($userID);
        // $user->email_verified_at = now();
        // $user->save();

        $userQuery = User::query()
            ->where('id', $userID);
        $user = $userQuery->firstOrFail();
        $user->email_verified_at = now();
        $user->save();
        // $userQuery->update(['email_verified_at' => now()]);

        //gelen tokeni silme işlemi
        // Cache::forget('verify_token_' . $request->token);

        Auth::login($user);
        alert()->success('Başarılı', 'Hesabınız oynaylandı');
        if ($user->hasRole(['super-admin', 'category-manager','product-manager', 'order-manager', 'user-manager']))
        {
            return redirect()->route('admin.index');
        }
        return redirect()->route('index');
    }

}
