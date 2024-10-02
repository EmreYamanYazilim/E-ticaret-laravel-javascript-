<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'name'              => ['required', 'string','min:2', 'max:125'],
            'short_description' => ['sometimes', 'nullable', 'max:255'],
            'description'       => ['sometimes', 'nullable', 'max:255'],
            'slug'              => ['sometimes', 'nullable', 'max:255','unique:categories,slug'],
        ];
    }


    public function prepareForValidation()
    {
        //slug yaparken güncelleme yaptığmızda aynı slugta str yapmadan verdiğimiz için aynı slug tekrardan verilebilir bunu engellemek için
        // prepreforvalidation kullanarak  koşullara dokunmadan önce  validation hazırlanırken burası çalışarak kontrol sağlıyorum
        if (!is_null($this->slug)) {
            $this->merge(['slug' => Str::slug($this->slug)]);
        }
    }
    public function messages()
    {
         $slugValue = $this->input('slug');
        return [
            //slugu ekrana yazdırarak uyarıyı verdirdim
            'unique' => 'Slug '.$slugValue .' zaten kullanılıyor.',
        ];
    }


}
