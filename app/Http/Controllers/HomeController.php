<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Landing page of the store. The catalog itself lives in ProductController.
     */
    public function index(): View
    {
        $viewData = [
            'title' => __('home.title'),
        ];

        return view('home.index')->with('viewData', $viewData);
    }
}
