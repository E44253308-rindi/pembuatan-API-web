<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(Book::latest()->get(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $data['image'] = $this->processImage($request);
        $book = Book::create($data);

        return response()->json($book, 201);
    }

    public function show(string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book, 200);
    }

    public function update(Request $request, string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|integer',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $oldImage = $book->image;
            $data['image'] = $this->processImage($request);
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        $book->update($data);
        return response()->json($book->fresh(), 200);
    }

    public function destroy(string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        $book->delete();

        return response()->json(['message' => 'Book deleted'], 200);
    }

    private function processImage(Request $request): ?string
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        $filename = 'books/'.Str::uuid().'.jpg';
        $image = (new ImageManager(new Driver()))
            ->read($request->file('image')->getRealPath())
            ->cover(800, 800);

        Storage::disk('public')->put($filename, $image->toJpeg(85));
        return $filename;
    }
}
