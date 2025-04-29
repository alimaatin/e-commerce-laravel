<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AdminProductRepository;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Http\Services\ProductImageService;
use Inertia\Inertia;

class AdminProductController extends Controller
{
    public function __construct(
        protected AdminProductRepository $products,
        protected ProductImageService $imageService
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

        if ($request->hasFile('image')) {
            $this->imageService->storeImage($request->file('image'));
            $validated['image'] = $request->file('image')->hashName();
        }

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
    
        if ($request->hasFile('image')) {
            $this->imageService->storeImage($request->file('image'));
            $validated['image'] = $request->file('image')->hashName();
        }
        
        $this->products->update($product, $validated);
    
        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }
}
