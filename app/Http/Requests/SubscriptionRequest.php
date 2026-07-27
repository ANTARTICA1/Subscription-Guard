<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'billing_cycle' => 'required|in:daily,weekly,monthly,yearly',
            'payment_date' => 'required|integer|min:1|max:366',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'auto_renew' => 'boolean',
            'reminder_days' => 'required|integer|min:1|max:30',
            'status' => 'required|in:active,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'name.required' => 'Nama subscription wajib diisi.',
            'amount.required' => 'Nominal wajib diisi.',
            'amount.min' => 'Nominal tidak boleh negatif.',
            'billing_cycle.required' => 'Siklus billing wajib dipilih.',
            'payment_date.required' => 'Tanggal pembayaran wajib diisi.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
        ];
    }
}
