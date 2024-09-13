<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:125'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->symbols()->numbers()],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ad Soyad alanı zoruludur',
            'name.min' => 'Ad Soyad alanı en az 2 karakter olmalıdır',
            'name.max' => 'Ad Soyad alanı en fazla 125 karakter olmalıdır',
            //  Validation Customizing bölümünü sadece yapılabiliceğini göstermek için yaptım devam ettirmeyeceğim github reposunda hazır olarak var ordadanda alarabiliriz
            //sitenin varsayılan dilini  app içinde locale Tr yapınca türkçe olarak değiştiriyor

        ];
    }


}
