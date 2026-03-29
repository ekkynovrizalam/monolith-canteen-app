@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Daftar Produk</h1>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->stock > 0)
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal{{ $product->id }}">
                                Order
                            </button>
                        @else
                            <span class="badge bg-secondary">Stok Habis</span>
                        @endif
                    </td>
                </tr>

                {{-- Order Modal for each product --}}
                @if($product->stock > 0)
                <div class="modal fade" id="orderModal{{ $product->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $product->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="orderModalLabel{{ $product->id }}">Order - {{ $product->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-2">Harga: <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></p>
                                    <p class="mb-3 text-muted">Stok tersedia: {{ $product->stock }}</p>
                                    <div class="mb-3">
                                        <label for="quantity{{ $product->id }}" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                               id="quantity{{ $product->id }}" name="quantity" 
                                               min="1" max="{{ $product->stock }}" value="1" required>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Pesan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Belum ada produk. Silakan jalankan seeder.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
