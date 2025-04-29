<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'postal_code' => 'required|numeric|digits:10',

            'order' => 'required|array|min:1',
            'order.*.product_id' => 'required|exists:products,id',
            'order.*.quantity' => 'required|integer|min:1',
            'order.*.price' => 'required|numeric|min:0',
        ];
    }

    protected function prepareForValidation()
    {
        if (is_string($this->order)) {
            $decoded = json_decode($this->order, true);
            $this->merge(['order' => $decoded]);
        }
    }
}
