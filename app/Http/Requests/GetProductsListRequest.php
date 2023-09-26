<?php

namespace App\Http\Requests;

use App\Utils\Interfaces\ProductFilter;
use Illuminate\Foundation\Http\FormRequest;

class GetProductsListRequest extends FormRequest implements ProductFilter
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => 'nullable|string|min:1|max:255',
            'category_id' => 'nullable|int|exists:categories,id'
        ];
    }

    public function hasSearch(): bool
    {
        return $this->has('search') && !is_null($this->getSearch());
    }

    public function getSearch(): string | null
    {
        return $this->input('search');
    }

    public function hasCategoryId(): bool
    {
        return $this->has('category_id') && !is_null($this->getCategoryId());
    }

    public function getCategoryId(): int | null
    {
        return $this->input('category_id');
    }
}
