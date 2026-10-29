<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice Buku #{{ $book->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        .header { border-bottom: 2px solid #2563eb; padding-bottom: 12px; margin-bottom: 20px; }
        h1 { color: #2563eb; margin: 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f3f4f6; width: 30%; }
        img { max-width: 160px; max-height: 160px; }
        .footer { margin-top: 30px; text-align: right; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE BUKU</h1>
        <p>No. INV-{{ str_pad((string) $book->id, 6, '0', STR_PAD_LEFT) }}</p>
    </div>

    <table>
        <tr><th>Judul</th><td>{{ $book->title }}</td></tr>
        <tr><th>Deskripsi</th><td>{{ $book->description ?: '-' }}</td></tr>
        <tr><th>Status</th><td>{{ $book->status }}</td></tr>
        <tr><th>Tanggal</th><td>{{ $book->created_at?->format('d-m-Y H:i') }}</td></tr>
        @if ($book->image)
        <tr><th>Gambar</th><td><img src="{{ public_path('storage/'.$book->image) }}" alt="{{ $book->title }}"></td></tr>
        @endif
    </table>

    <div class="footer">Dicetak pada {{ now()->format('d-m-Y H:i') }}</div>
</body>
</html>
