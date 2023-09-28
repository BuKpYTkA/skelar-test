<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /** @var Product */
    public $resource;

    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['category'] = JsonResource::make($this->whenLoaded('category'));
        $data['user'] = JsonResource::make($this->whenLoaded('user'));
        $data['logo_url'] = $this->resource->getLogoUrlWhenLoaded();

        return $data;
    }
}
