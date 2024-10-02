<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Sayfa numarasını al ve session'a kaydet  UPDATE sonrası geri dönüş için kullanılabilir alternatif
        $page = $request->get('page', 1);
        session(['category_page' => $page]);

        $categories = Category:: orderBy('id','desc')->paginate(4);
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.category.create_edit')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $data = $request->only('name','short_description', 'description');
        $slug = Str::slug($request->slug);
        if (is_null($request->slug)) {
            $slug  = Str::slug(mb_substr($data['name'],0,70));
            $check = Category::query()->where('slug',$slug)->first();


            if ($check) {
                return redirect()
                ->back()
                ->withErrors(['slug' => 'Slug değeriniz boş veya başka bir kategori tarafından kullanılıyor olabilir'])
                ->withInput();
            }
        }
            $data['slug']   = $slug;
            $data['status'] = $request->has('status');

            Category::create($data);

            alert()->success('Başarılı', 'Kategori Kayıt edildi');
            return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('admin.category.create_edit', compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->only('name','short_description', 'description');
        $slug = Str::slug($request->slug);
        if (is_null($request->slug)) {
            $slug  = Str::slug(mb_substr($data['name'],0,70));
            $check = Category::query()->where('slug',$slug)->first();


            if ($check) {
                return redirect()
                ->back()
                ->withErrors(['slug' => 'Slug değeriniz boş veya başka bir kategori tarafından kullanılıyor olabilir'])
                ->withInput();
            }
        }
            $data['slug']   = $slug;
            $data['status'] = $request->has('status');

            $category->update($data);
            alert()->success('Başarılı', 'Kategori Güncellendi');
        // Session'dan sayfa numarasını al
            $page = session('category_page', 1);
        // Sayfa numarası ile yönlendirme yap
            return redirect()->route('admin.category.index', ['page' => $page]);


        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }

    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $category = Category::query()->where('id',$id)->first();
        if (is_null($category))
        {
        //json direk içinde verebiliriz  ben haric ve zincirleme olarak yapacağım
            return response()
                ->json()
                ->setData(['message' => 'Kategori bulunamadı'])
                ->setStatusCode(404)
                ->setCharset('utf-8')
                ->header('Content-Type', 'application/json')
                ->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        }

        $category->status = !$category->status;
        $category->save();

        return response()
        ->json()
        ->setData($category)
        ->setStatusCode(200)
        ->setCharset('utf-8')
        ->header('Content-Type', 'application/json')
        ->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
