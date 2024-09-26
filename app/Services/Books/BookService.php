<?php

namespace App\Services\Books;

use App\Models\Book;
use Illuminate\Support\Facades\Log;
use Exception;

class BookService
{
    /**
     * Store a newly created book in the database.
     * 
     * @param object $data The validated request object containing the book data (e.g., title, author, etc.).
     * @return \App\Models\Book The created Book instance.
     * @throws \Exception If the creation of the book fails, an exception is thrown.
     */
    public function store($data): Book
    {
        try {
            return Book::create([
                'title'        => $data->title,
                'author'       => $data->author,
                'published_at' => $data->published_at,
                'is_active'    => $data->is_active,
                'category_id'  => $data->category_id
            ]);
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception('Failed to created book: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing book in the database.
     * 
     * @param \App\Models\Book $book The book instance to be updated.
     * @param array $data The array containing updated book data.
     * @return \App\Models\Book The updated Book instance.
     * @throws \Exception If the update operation fails, an exception is thrown.
     */
    public function update(Book $book, $data): Book
    {
        try {
            $book->update([
                'title'        => $data['title'] ?? $book->title,
                'author'       => $data['author'] ?? $book->author,
                'published_at' => $data['published_at'] ?? $book->published_at,
                'is_active'    => $data['is_active'] ?? $book->is_active,
                'category_id'  => $data['category_id'] ?? $book->category_id,
            ]);
            return $book;
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception('Failed to updated book: ' . $e->getMessage());
        }
    }

    /**
     * Delete a book from the database.
     * 
     * @param \App\Models\Book $book The book instance to be deleted.
     * @return void
     * @throws \Exception If the deletion operation fails, an exception is thrown.
     */
    public function delete(Book $book): void
    {
        try {
            $book->delete();
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception('Failed to deleted book: ' . $e->getMessage());
        }
    }
}
