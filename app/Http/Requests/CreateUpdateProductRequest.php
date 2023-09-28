<?php

namespace App\Http\Requests;

use App\Rules\Boolean;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class CreateUpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:3|max:1000',
            'price' => 'required|int|min:0',
            'category_id' => 'required|int|exists:categories,id',
            'logo' => 'nullable|image',
            'logo_updated' => [
                'nullable',
                new Boolean
            ]
        ];
    }

    public function getInsertData(): array
    {
        return array_merge($this->only([
            'title',
            'description',
            'price',
            'category_id'
        ]), [
            'user_id' => $this->user()->getKey()
        ]);
    }

    public function logoUpdated(): bool
    {
        return $this->boolean('logo_updated');
    }

    public function getLogo(): ?UploadedFile
    {
        return $this->file('logo');
    }
}
