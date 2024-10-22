<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller
{

    public function __construct(public CategoryService $categoryService) // cunscturck sayesinde içinde altta this diyerek onu tanımlayabiliyorum
    {

    }
    // eğer yukarıdaki gibi __construck olarak tanımlamasaydım index içinde böylede alttaki gibi vererek tanımlama yapablirdim yukarıdaki tek 1 kere kullanıp her yerde kullanabilmek için ama bu örnek misal tek index içinde çalışacaktı her yerde ayrı ayrı tanımlamam gerekecekti alttakini gibi
    //        $categoryService = new CategoryService(category: new Category());

    // eğer genel olarak __construck olarak tanımadısak alternatif olarak  index içinde böyle tanımlayabilirdik         $categories= App::make(CategoryService::class);



    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Sayfa numarasını al ve session'a kaydet  UPDATE sonrası geri dönüş için kullanılabilir alternatif
        $page = $request->get('page', 1);
        session(['category_page' => $page]);

        // $categories = Category:: orderBy('id','desc')->paginate(4);
        $categories = $this->categoryService->getAllCategoriesPaginate(orderBy: ['name', 'ASC']);

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = Category::all();
        $categories = $this->categoryService->getAllCategories();

        return view('admin.category.create_edit')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {

        try {
            $this->categoryService->prepareDataForCreate()->create();
        //    $this->categoryService->create($data);

        alert()->success('Başarılı', 'Kategori Kayıt edildi');
        return redirect()->route('admin.category.index');

        } catch (Throwable $exception ) {
            if ($exception->getCode() == 400) {
                return redirect()
                    ->back()
                    ->withErrors(['slug' => $exception->getMessage()])
                    ->withInput();
            }
            alert()->error('Başarısız', 'Kategori Kayıt edilemedi');
        }


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
        return view('admin.category.create_edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->only('name', 'short_description', 'description');
        $slug = Str::slug($request->slug);
        if (is_null($request->slug)) {
            $slug = Str::slug(mb_substr($data['name'], 0, 70));
            $check = Category::query()->where('slug', $slug)->first();


            if ($check) {
                return redirect()
                    ->back()
                    ->withErrors(['slug' => 'Slug değeriniz boş veya başka bir kategori tarafından kullanılıyor olabilir'])
                    ->withInput();
            }
        }
        $data['slug'] = $slug;
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
        $category = Category::query()->where('id', $id)->first();
        if (is_null($category)) {
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
