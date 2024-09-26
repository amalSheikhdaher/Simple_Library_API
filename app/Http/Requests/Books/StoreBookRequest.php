<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\Books\BookRequestService;

class StoreBookRequest extends FormRequest
{
    // The service that handles custom validation logic, attribute names, and error messages.
    protected $bookRequestService;

    /**
     * Constructor for dependency injection of BookRequestService.
     * 
     * @param BookRequestService $bookRequestService This service provides custom logic for handling validation attributes, messages, and failed validation responses.
     */
    public function __construct(BookRequestService $bookRequestService)
    {
        $this->bookRequestService = $bookRequestService;
    }

    /**
     * Determine if the user is authorized to make this request.
     * 
     * @return bool Always returns true for authorization, allowing any user to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     * 
     * This method is called before validation begins. It allows us to modify the incoming request data.
     * Here, we are formatting and sanitizing input data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title'  => $this->title ? ucwords(trim($this->title)) : null,
            'author' => $this->author ? ucwords(trim($this->author)) : null,
            'is_active' => $this->has('is_active') ? filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN) : true,
            'published_at' => $this->published_at ? date('Y-m-d', strtotime($this->published_at)) : null
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'published_at' => 'required|date_format:Y-m-d',
            'is_active'    => 'required|boolean',
            'category_id'  => 'required|exists:categories,id'
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     * 
     * This method uses the `BookRequestService` to define custom attribute names (e.g., showing a user-friendly name in error messages).
     * 
     * @return array Custom attribute names.
     */
    public function attributes(): array
    {
        return  $this->bookRequestService->attributes();
    }

    /**
     * Handle a failed validation attempt.
     * 
     * When validation fails, this method is called to provide a custom response.
     * It delegates the failed validation logic to `BookRequestService`.
     * 
     * @param \Illuminate\Contracts\Validation\Validator $validator The validator instance containing validation failures.
     */
    public function failedValidation($validator): void
    {
        $this->bookRequestService->failedValidation($validator);
    }

    /**
     * Get custom validation error messages.
     * 
     * This method uses `BookRequestService` to retrieve custom error messages for validation failures.
     * 
     * @return array Custom validation error messages.
     */
    public function messages(): array
    {
        $messages = $this->bookRequestService->messages();
        return $messages;
    }
}
