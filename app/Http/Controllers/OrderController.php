<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function invoice(Book $book)
    {
        return Pdf::loadView('invoices.book', ['book' => $book])
            ->download('invoice_' . $book->id . '.pdf');
    }
}
