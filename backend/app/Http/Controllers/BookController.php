<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $query = Book::with('author');
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
        if ($request->per_page == 'all') {
            $request->merge(['per_page' => $query->count()]);
        }

        $books = $query->latest()->paginate($request->get('per_page', config('constant.pagination')));
        return BookResource::collection($books);
    }
}
