<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(){
     $name = 'Banners';
     $icon = 'fa fa-file-import mr-1';
     return view('banner.index', compact('name', 'icon'));
    }
}
