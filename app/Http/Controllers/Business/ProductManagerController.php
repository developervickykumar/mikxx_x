<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductVariant;
use App\Models\ProductInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('can:manage,business');
    }

    public function index(Business $business)
    {
        // Cache key for product management
        $cacheKey = "business.{$business->id}.products.management";
        
        // Get all data with caching
        $data = Cache::remember($cacheKey, 300, function () use ($business) {
            return [
                'products' => $business->products()
                    ->with(['categories', 'variants', 'inventory', 'media'])
                    ->withCount('orders')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10),
                
                'categories' => $business->productCategories()
                    ->withCount('products')
                    ->get(),
                
                'inventory' => $business->productInventory()
                    ->with('product')
                    ->orderBy('updated_at', 'desc')
                    ->paginate(20),
                
                'settings' => $business->product_management_settings
            ];
        });

        return view('business.admin.products.index', compact('business', 'data'));
    }

    public function createProduct(Business $business, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'sku' => 'required|string|max:255|unique:products,sku',
            'barcode' => 'nullable|string|max:255|unique:products,barcode',
            'weight' => 'nullable|numeric|min:0',
            'weight_unit' => 'nullable|string|in:g,kg,oz,lb',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:product_categories,id',
            'is_visible' => 'boolean',
            'is_featured' => 'boolean',
            'media' => 'nullable|array',
            'media.*' => 'file|mimes:jpeg,png,gif|max:10240',
            'variants' => 'nullable|array',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.sku' => 'required|string|max:255',
            'variants.*.inventory' => 'required|integer|min:0',
            'inventory' => 'required|integer|min:0'
        ]);

        $product = $business->products()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'compare_at_price' => $validated['compare_at_price'] ?? null,
            'cost_price' => $validated['cost_price'],
            'sku' => $validated['sku'],
            'barcode' => $validated['barcode'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'weight_unit' => $validated['weight_unit'] ?? null,
            'is_visible' => $validated['is_visible'] ?? true,
            'is_featured' => $validated['is_featured'] ?? false
        ]);

        if (!empty($validated['categories'])) {
            $product->categories()->attach($validated['categories']);
        }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('products/' . $business->id, 'public');
                $product->media()->create([
                    'path' => $path,
                    'type' => 'image',
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType()
                ]);
            }
        }

        if (!empty($validated['variants'])) {
            foreach ($validated['variants'] as $variant) {
                $product->variants()->create([
                    'name' => $variant['name'],
                    'price' => $variant['price'],
                    'sku' => $variant['sku'],
                    'inventory' => $variant['inventory']
                ]);
            }
        } else {
            $product->inventory()->create([
                'quantity' => $validated['inventory'],
                'low_stock_threshold' => 5
            ]);
        }

        // Clear the product management cache
        Cache::forget("business.{$business->id}.products.management");

        return response()->json(['message' => 'Product created successfully', 'product' => $product]);
    }

    public function updateProduct(Business $business, Product $product, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:255|unique:products,barcode,' . $product->id,
            'weight' => 'nullable|numeric|min:0',
            'weight_unit' => 'nullable|string|in:g,kg,oz,lb',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:product_categories,id',
            'is_visible' => 'boolean',
            'is_featured' => 'boolean',
            'media' => 'nullable|array',
            'media.*' => 'file|mimes:jpeg,png,gif|max:10240',
            'remove_media' => 'nullable|array',
            'remove_media.*' => 'exists:media,id',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.sku' => 'required|string|max:255',
            'variants.*.inventory' => 'required|integer|min:0',
            'remove_variants' => 'nullable|array',
            'remove_variants.*' => 'exists:product_variants,id',
            'inventory' => 'required|integer|min:0'
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'compare_at_price' => $validated['compare_at_price'] ?? null,
            'cost_price' => $validated['cost_price'],
            'sku' => $validated['sku'],
            'barcode' => $validated['barcode'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'weight_unit' => $validated['weight_unit'] ?? null,
            'is_visible' => $validated['is_visible'] ?? $product->is_visible,
            'is_featured' => $validated['is_featured'] ?? $product->is_featured
        ]);

        if (isset($validated['categories'])) {
            $product->categories()->sync($validated['categories']);
        }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('products/' . $business->id, 'public');
                $product->media()->create([
                    'path' => $path,
                    'type' => 'image',
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType()
                ]);
            }
        }

        if (!empty($validated['remove_media'])) {
            $mediaToRemove = $product->media()->whereIn('id', $validated['remove_media'])->get();
            foreach ($mediaToRemove as $media) {
                Storage::disk('public')->delete($media->path);
                $media->delete();
            }
        }

        if (!empty($validated['variants'])) {
            foreach ($validated['variants'] as $variant) {
                if (isset($variant['id'])) {
                    $product->variants()->find($variant['id'])->update([
                        'name' => $variant['name'],
                        'price' => $variant['price'],
                        'sku' => $variant['sku'],
                        'inventory' => $variant['inventory']
                    ]);
                } else {
                    $product->variants()->create([
                        'name' => $variant['name'],
                        'price' => $variant['price'],
                        'sku' => $variant['sku'],
                        'inventory' => $variant['inventory']
                    ]);
                }
            }
        }

        if (!empty($validated['remove_variants'])) {
            $product->variants()->whereIn('id', $validated['remove_variants'])->delete();
        }

        if ($product->variants()->count() === 0) {
            $product->inventory()->updateOrCreate(
                ['product_id' => $product->id],
                ['quantity' => $validated['inventory']]
            );
        }

        // Clear the product management cache
        Cache::forget("business.{$business->id}.products.management");

        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
    }

    public function deleteProduct(Business $business, Product $product)
    {
        // Delete associated media files
        foreach ($product->media as $media) {
            Storage::disk('public')->delete($media->path);
            $media->delete();
        }

        $product->delete();

        // Clear the product management cache
        Cache::forget("business.{$business->id}.products.management");

        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function updateInventory(Business $business, Product $product, Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'variant_id' => 'nullable|exists:product_variants,id'
        ]);

        if ($validated['variant_id']) {
            $variant = $product->variants()->findOrFail($validated['variant_id']);
            $variant->update(['inventory' => $validated['quantity']]);
        } else {
            $product->inventory()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'quantity' => $validated['quantity'],
                    'low_stock_threshold' => $validated['low_stock_threshold'] ?? 5
                ]
            );
        }

        // Clear the product management cache
        Cache::forget("business.{$business->id}.products.management");

        return response()->json(['message' => 'Inventory updated successfully']);
    }

    public function updateSettings(Business $business, Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array'
        ]);

        $business->update([
            'product_management_settings' => $validated['settings']
        ]);

        // Clear the product management cache
        Cache::forget("business.{$business->id}.products.management");

        return response()->json(['message' => 'Settings updated successfully']);
    }
} 