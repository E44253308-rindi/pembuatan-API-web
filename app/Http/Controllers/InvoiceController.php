<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function preview(Book $book)
    {
        return Pdf::loadView('invoices.book', ['book' => $book])
            ->stream("invoice-buku-{$book->id}.pdf");
    }

    public function download(Book $book)
    {
        return Pdf::loadView('invoices.book', ['book' => $book])
            ->download("invoice-buku-{$book->id}.pdf");
    }
}
