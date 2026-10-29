<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Daftar Produk</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($products->isEmpty())
        <div class="alert alert-info">Belum ada produk.</div>
    @else
        <div class="row g-3">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        @if ($product->image)
                            <img src="{{ route('products.image', $product) }}"
                                 class="card-img-top" alt="{{ $product->name }}"
                                 style="height: 220px; object-fit: cover;">
                        @else
                            <div class="bg-secondary-subtle d-flex align-items-center justify-content-center"
                                 style="height: 220px;">Tidak ada gambar</div>
                        @endif
                        <div class="card-body">
                            <h2 class="h5 card-title">{{ $product->name }}</h2>
                            <p class="mb-1"><strong>SKU:</strong> {{ $product->sku }}</p>
                            <p class="mb-1"><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="mb-0"><strong>Stok:</strong> {{ $product->stock }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>
