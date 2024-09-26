<?php

namespace App\Services\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequestService extends FormRequest
{
    /**
     *  get array of  CategoryRequestService attributes 
     *
     * @return array   of attributes
     */
    public function attributes(): array
    {
        return  [
            'name'        => 'Category name',
            'description' => 'Category description'
        ];
    }

    /**
     * Customize the validation error messages.
     * 
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'   => 'The category name is required.',
            'name.unique'     => 'This category name is already taken. Please choose another.',
            'name.max'        => 'The category name may not be longer than 255 characters.',
            'description.max' => 'The description may not be longer than 500 characters.'
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