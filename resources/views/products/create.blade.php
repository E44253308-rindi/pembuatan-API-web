<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 720px;">
        <div class="card-header bg-white">
            <h1 class="h4 mb-0">Tambah Produk</h1>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="sku" class="form-label">SKU</label>
                    <input type="text" class="form-control @error('sku') is-invalid @enderror"
                           id="sku" name="sku" value="{{ old('sku') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                               id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror"
                               id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" step="1" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Produk</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                           id="image" name="image" accept="image/jpeg,image/png,image/webp">
                    <div class="form-text">Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.</div>
                </div>

                <div class="mb-4">
                    <img id="image-preview" src="#" alt="Preview gambar produk"
                         class="d-none rounded border" style="width: 180px; height: 180px; object-fit: cover;">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Produk</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function (event) {
        const preview = document.getElementById('image-preview');
        const file = event.target.files[0];

        if (!file) {
            preview.classList.add('d-none');
            preview.removeAttribute('src');
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    });
</script>
</body>
</html>
