<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateProductRequest;
use App\Http\Requests\GetProductsListRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Utils\Repositories\ProductRepository;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function list(GetProductsListRequest $request): Response
    {
        $productsPaginator = $this->productRepository->getQueryByFilter($request)
            ->with(['category', 'user'])
            ->paginate()
            ->through(fn($product) => ProductResource::make($product));

        return Inertia::render('Products', [
            'paginator' => $productsPaginator
        ]);
    }

    public function create(CreateUpdateProductRequest $request)
    {
        $product = Product::query()->create(array_merge($request->validated(), [
            'created_by' => $request->user()->getKey()
        ]));
    }

    public function update(Product $product, CreateUpdateProductRequest $request)
    {
        $product->update($request->validated());
    }

    public function delete(Product $product)
    {
        $product->delete();
    }

    public function get(Product $product)
    {

    }
}
