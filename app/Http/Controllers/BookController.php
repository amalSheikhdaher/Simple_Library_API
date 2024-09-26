<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Services\Books\BookService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\BookResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\Books\StoreBookRequest;
use App\Http\Requests\Books\UpdateBookRequest;

class BookController extends Controller
{
    // This trait provides standardized methods for API responses.
    use ApiResponseTrait;

    // Dependency injection for BookService to handle business logic.
    protected BookService $bookService;

    /**
     * Constructor to inject the BookService into the controller.
     * 
     * @param BookService $bookService The service class responsible for handling business logic.
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
/**
     * Display a listing of books with pagination, including their associated categories.
     * 
     * @return JsonResponse Paginated list of books with categories in JSON format.
     */
    public function index(): JsonResponse
    {
        // Load books along with their associated categories, with pagination.
        $books = Book::with('category')->paginate(5);
        return $this->responseApi(
            BookResource::collection($books),
            'Books retrieved successfully',
            200
        );
    }

    /**
     * Store a newly created book in the database.
     * 
     * @param StoreBookRequest $request Validated request object containing book details.
     * @return JsonResponse Response with created book data and success message.
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $book = $this->bookService->store($request);
        return $this->responseApi(
            new BookResource($book),
            'Book Store Successfully',
            201
        );
    }

    /**
     * Display a single book's details.
     * 
     * @param Book $book The book instance to display.
     * @return JsonResponse Response with single book data and success message.
     */
    public function show(Book $book): JsonResponse
    {
        $book->load('category');
        return $this->responseApi(
            new BookResource($book),
            'Single Book data Show',
            200
        );
    }

    /**
     * Update an existing book in the database.
     * 
     * @param UpdateBookRequest $request Validated request object with updated book details.
     * @param Book $book The book instance to update.
     * @return JsonResponse Response with updated book data and success message.
     */
    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        $data = $this->bookService->update($book, $request->validated());
        return $this->responseApi(
            new BookResource($data),
            'Book Update Successfully',
            200
        );
    }

    /**
     * Remove a book from the database.
     * 
     * @param Book $book The book instance to delete.
     * @return JsonResponse Response with success message after deletion.
     */
    public function destroy(Book $book): JsonResponse
    {
        $this->bookService->delete($book);
        return $this->responseApi(
            true,
            'Book Delete Successfully',
            200
        );
    }

    /**
     * Display a listing of books that belong to a specific category.
     * 
     * @param Category $category The category instance.
     * @return JsonResponse List of books in the specified category in JSON format.
     */
    public function indexByCategory(Category $category): JsonResponse
    {
        $books = $category->books;
        return $this->responseApi(
            BookResource::collection($books),
            'Books retrieved successfully',
            200
        );
    }
}
