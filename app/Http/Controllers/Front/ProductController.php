<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ProductController extends Controller
{
    public function list()
    {
        return view('front.product-list');
    }

    public function detail()
    {
        return view('front.product-detail');
    }

}
