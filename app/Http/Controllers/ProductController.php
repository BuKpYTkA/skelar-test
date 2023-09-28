<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateProductRequest;
use App\Http\Requests\GetProductsListRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Utils\Repositories\ProductRepository;
use App\Utils\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductService $productService
    )
    {
    }

    public function list(GetProductsListRequest $request): Response
    {
        // totally unnecessary in this case, but I guess it won't hurt anyone :)
        $productsPaginator = $this->productRepository->getQueryByFilter($request)
            ->with(['category', 'user', 'media'])
            ->latest()
            ->paginate()
            ->through(fn($product) => ProductResource::make($product));

        return Inertia::render('Products', [
            'paginator' => $productsPaginator
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('CreateProduct', [
            // could be paginated for scroll-loading dropdown
            'categories' => Category::all()
        ]);
    }

    public function store(CreateUpdateProductRequest $request): ProductResource
    {
        $product = Product::query()->create($request->getInsertData());
        if ($request->logoUpdated()) {
            $this->productService->setLogo($product, $request->getLogo());
        }

        return ProductResource::make($product);
    }

    public function update(Product $product): Response
    {
        $product->load('category');

        return Inertia::render('UpdateProduct', [
            'product' => ProductResource::make($product),
            // could be paginated for scroll-loading dropdown
            'categories' => Category::all()
        ]);
    }

    public function save(Product $product, CreateUpdateProductRequest $request): ProductResource
    {
        $product->update($request->getInsertData());
        if ($request->logoUpdated()) {
            $this->productService->setLogo($product, $request->getLogo());
        }

        return ProductResource::make($product);
    }

    public function delete(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json();
    }
}
