<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\News;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index() {
        $news = News::all(); 
    
        // Lọc banner theo loại
        $banner_main = Banner::where('type', 0)->get();
        $banner_sub_1 = Banner::where('type', 1)->get();
        $banner_sub_2 = Banner::where('type', 2)->get();  
    
        return view('user.index', [
            'news' => $news,
            'banner_main' => $banner_main,
            'banner_sub_1' => $banner_sub_1,
            'banner_sub_2' => $banner_sub_2,
        ]);
    }
    
}
