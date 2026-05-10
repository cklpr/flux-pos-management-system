<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Assuming middleware handles role authorization (Cashier/Admin)
        return true; 
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'nullable|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'payment_method' => 'required|string|in:cash,card,mobile',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'You must add at least one item to the cart to process a sale.',
            'items.*.product_id.exists' => 'One or more selected products are invalid.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'payment_method.in' => 'Please select a valid payment method.',
        ];
    }
}