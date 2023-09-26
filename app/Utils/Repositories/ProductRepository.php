<?php

namespace App\Utils\Repositories;

use App\Models\Product;
use App\Utils\Interfaces\ProductFilter;
use Illuminate\Contracts\Database\Query\Builder;

class ProductRepository
{
    public function getQueryByFilter(ProductFilter $filter): Builder
    {
        $query = Product::query();
        if ($filter->hasSearch()) {
            $query->search($filter->getSearch());
        }
        if ($filter->hasCategoryId()) {
            $query->where('category_id', $filter->getCategoryId());
        }

        return $query;
    }
}
