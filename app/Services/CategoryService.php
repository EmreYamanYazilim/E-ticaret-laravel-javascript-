<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{

    private array $prepareData = [];
    public function __construct(public Category $category)
    {

    }

    public function getAllCategories(): Collection
    {
        return $this->category::all();
    }

    public function getAllCategoriesPaginate(int $page=5, $orderBy = ['id', 'DESC']): LengthAwarePaginator
    {
        return $this->category::orderBy($orderBy[0],$orderBy[1])->paginate($page);
    }

    public function create(array $data = null)
    {
        if (is_null($data)) {
            $data = $this->prepareData;
        }
        return $this->category::create($data);

    }

    public function prepareDataForCreate() : self
    {
        $data = request()->only('name', 'short_description', 'description');
        $slug = $this->slugGenerate($data['name'],request()->slug);
        $data['slug'] = $slug;
        $data['status'] = request()->has('status');
        if (request()->parent_id != -1) {
            $data['parent_id'] = request()->parent_id;
        }
        $this->prepareData = $data;
        return $this;
    }


    public function checkSlug(string $slug) : Category | null
    {
        return $this->category::query()->where('slug', $slug)->first();


    }

    public function slugGenerate(string $name,string|null $slug) :string
    {
        if (is_null($slug))
        {
            $slug  = Str::slug(mb_substr($name, 0, 70));
            $check = $this->checkSlug($slug);
            if ($check)
            {
                throw new \Exception('Slug değeriniz boş veya daha önce farklı bir kategori tarafından kullanılıyor olablir.', 400);
            }
        }
        else
        {
            $slug = Str::slug($slug);
        }

        return $slug;
    }



}
