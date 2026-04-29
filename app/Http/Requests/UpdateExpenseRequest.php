<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'title'        => ['sometimes', 'string', 'max:150'],
        'description'  => ['nullable', 'string', 'max:1000'],
        'amount'       => ['sometimes', 'numeric', 'min:0.01', 'max:999999.99'],
        'category'     => ['sometimes', 'in:food,travel,office,health,other'],
        'expense_date' => ['sometimes', 'date', 'before_or_equal:today'],
        'receipt'      => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
    ];
    }
}
