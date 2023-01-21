<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return array
     */
    public function __invoke(Request $request)
    {
        return [
            'products' => Product::count()
        ];
    }
}
