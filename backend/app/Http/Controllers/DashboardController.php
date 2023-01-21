<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'authors' => Author::count(),
            'books'   => Book::count(),
        ];
    }
}
