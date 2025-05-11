<?php

namespace App\Http\Controllers;

use App\Actions\StoreImageAction;
use App\Repositories\ProductRepository;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Inertia\Inertia;

class AdminProductController extends Controller
{
    public function __construct(
        protected ProductRepository $products,
        protected StoreImageAction $storeImage
    ) {}

    public function index()
    {
        return Inertia::render('admin/products/index', [
            'products' => $this->products->getAllSorted()
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $validated['image'] = $this->storeImage->handle($request->file('image'));

        $this->products->create($validated);

        return redirect()->route('admin.products')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        return Inertia::render('admin/products/edit', [
            'product' => $product
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $validated['image'] = $this->storeImage->handle($request->file('image'));

        $this->products->update($product, $validated);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }
}
