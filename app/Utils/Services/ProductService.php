<?php

namespace App\Utils\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;

class ProductService
{
    public function setLogo(Product $product, UploadedFile $file = null): void
    {
        $this->deleteLogo($product);
        if ($file) {
            $product->addMedia($file)->toMediaCollection(Product::MEDIA_COLLECTION_LOGO);
        }
        $product->refresh();
    }

    public function deleteLogo(Product $product): void
    {
        $product->media()->where('collection_name', Product::MEDIA_COLLECTION_LOGO)->first()?->delete();;
    }
}
