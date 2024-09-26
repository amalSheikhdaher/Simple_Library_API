<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\Categories\CategoryRequestService;

class StoreCategoryRequest extends FormRequest
{
    // The service that handles custom validation logic, attribute names, and error messages.
    protected $categoryRequestService;

    /**
     * Constructor for dependency injection of CategoryRequestService.
     * 
     * @param CategoryRequestService $categoryRequestService This service provides custom logic for handling validation attributes, messages, and failed validation responses.
     */
    public function __construct(CategoryRequestService $categoryRequestService)
    {
        $this->categoryRequestService = $categoryRequestService;
    }

    /**
     * Determine if the user is authorized to make this request.
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
            'name'        => $this->name ? ucwords(trim($this->name)) : null,
            'description' => $this->description ? ucfirst(trim($this->description)) : null,
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
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     * 
     * This method uses the `CategoryRequestService` to define custom attribute names (e.g., showing a user-friendly name in error messages).
     * 
     * @return array Custom attribute names.
     */
    public function attributes(): array
    {
        return  $this->categoryRequestService->attributes();
    }

    /**
     * Handle a failed validation attempt.
     * 
     * When validation fails, this method is called to provide a custom response.
     * It delegates the failed validation logic to `CategoryRequestService`.
     * 
     * @param \Illuminate\Contracts\Validation\Validator $validator The validator instance containing validation failures.
     */
    public function failedValidation($validator): void
    {
        $this->categoryRequestService->failedValidation($validator);
    }

    /**
     * Get custom validation error messages.
     * 
     * This method uses `CategoryRequestService` to retrieve custom error messages for validation failures.
     * 
     * @return array Custom validation error messages.
     */
    public function messages(): array
    {
        $messages = $this->categoryRequestService->messages();
        return $messages;
    }
}
