<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::latest()->get();

        if ($request->is('api/*')) {
            return response()->json($products);
        }

        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->processImage($request->file('image'));
        }

        $product = Product::create($data);

        if ($request->expectsJson()) {
            return response()->json($product, 201);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'sku' => 'sometimes|required|string|max:100|unique:products,sku,'.$product->id,
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'description' => 'sometimes|nullable|string',
            'image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                $this->deleteImage($product->image);
            }
            $data['image'] = $this->processImage($request->file('image'));
        }

        $product->update($data);
        return response()->json($product->fresh());
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            $this->deleteImage($product->image);
        }
        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }

    private function processImage($file): string
    {
        $filename = Str::uuid().'.'.$file->extension();
        Storage::disk('local')->putFileAs('product', $file, $filename);

        return 'product/'.$filename;
    }

    private function deleteImage(string $image): void
    {
        Storage::disk('local')->delete($image);

        // Mendukung penghapusan produk lama yang gambarnya tersimpan di lokasi lama.
        File::delete(public_path($image));
        Storage::disk('public')->delete($image);
    }

    public function image(Product $product)
    {
        if (!$product->image) {
            abort(404);
        }

        if (Storage::disk('local')->exists($product->image)) {
            return response()->file(Storage::disk('local')->path($product->image));
        }

        $publicImage = public_path($product->image);
        if (File::exists($publicImage)) {
            return response()->file($publicImage);
        }

        abort(404);
    }
}
