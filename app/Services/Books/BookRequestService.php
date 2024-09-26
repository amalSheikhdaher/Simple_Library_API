<?php

namespace App\Services\Books;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class BookRequestService extends FormRequest
{
    /**
     *  get array of  BookRequestService attributes 
     *
     * @return array   of attributes
     */
    public function attributes()
    {
        return  [
            'title'        => 'Book Title',
            'author'       => 'Author Name',
            'published_at' => 'Published Date',
            'is_active'    => 'Book Status',
            'category_id'  => 'Category'
        ];
    }

    /**
     *  get array of  BookRequestService messages 
     * @return array   of messages
     */
    public function messages(): array
    {
        return [
            'title.required'       => 'The book title is required.',
            'title.max'            => 'The book title must not exceed 255 characters.',
            'author.required'      => 'The author is required.',
            'author.max'           => 'The author name must not exceed 255 characters.',
            'published_at.date'    => 'The published date must be a valid date.',
            'is_active.required'   => 'The status of the book is required.',
            'is_active.boolean'    => 'The status must be true or false.',
            'category_id.required' => 'The category is required.',
            'category_id.exists'   => 'The selected category does not exist.',
        ];
    }

    /**
     *  
     * @param $validator
     *
     * throw a exception
     */
    public function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'status'  => 'error',
                'message' => "Verification failed, please check that the value entered are correct",
                'errors'  => $validator->errors()
            ],
            422
        ));
    }
}
