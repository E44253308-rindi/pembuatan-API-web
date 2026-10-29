<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_book_image_can_be_uploaded_and_processed(): void
    {
        Storage::fake('public');

        $response = $this->postJson('/api/books', [
            'title' => 'Buku Test',
            'description' => 'Validasi upload gambar',
            'status' => 1,
            'image' => UploadedFile::fake()->image('book.jpg', 1200, 900),
        ]);

        $response->assertCreated();
        $response->assertJsonPath('title', 'Buku Test');
        Storage::disk('public')->assertExists($response->json('image'));
    }

    public function test_product_image_can_be_uploaded_and_resized(): void
    {
        Storage::fake('public');

        $response = $this->postJson('/api/products', [
            'name' => 'Novel Laravel',
            'sku' => 'NOV-LARAVEL-001',
            'price' => 125000,
            'stock' => 10,
            'description' => 'Validasi upload produk',
            'image' => UploadedFile::fake()->image('product.jpg', 1200, 900),
        ]);

        $response->assertCreated();
        $response->assertJsonPath('name', 'Novel Laravel');
        $this->assertFileExists(public_path($response->json('image')));
        @unlink(public_path($response->json('image')));
    }

    public function test_book_invoice_pdf_can_be_downloaded(): void
    {
        $book = \App\Models\Book::create([
            'title' => 'Buku PDF',
            'description' => 'Validasi invoice',
            'status' => 1,
        ]);

        $response = $this->get("/books/{$book->id}/invoice/download");

        $response->assertOk();
        $this->assertStringContainsString('application/pdf', $response->headers->get('content-type'));
    }
}
