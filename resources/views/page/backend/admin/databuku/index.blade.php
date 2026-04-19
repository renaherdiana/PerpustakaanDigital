@extends('layouts.backend.admin.app')

@section('content')

<style>
.page-title{
    font-weight:700;
    font-size:20px;
    margin-bottom:25px;
    color:#3b3b3b;
}

.card-custom{
    border:none;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
    padding:20px;
}

/* FILTER */
.filter-area{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.filter-left{
    display:flex;
    gap:15px;
}

.filter-left input{
    min-width:250px;
    padding:8px 12px;
    border-radius:10px;
    border:1px solid #e0e0e0;
    font-size:14px;
}

.filter-left select{
    padding:8px 12px;
    border-radius:10px;
    border:1px solid #e0e0e0;
    font-size:14px;
}

/* TABLE */
.table thead{
    background:#f8f8fb;
}

.table th{
    font-weight:600;
    color:#555;
}

.table td{
    vertical-align:middle;
}

/* BOOK COVER */
.book-cover{
    width:45px;
    height:60px;
    object-fit:cover;
    border-radius:6px;
    border:2px solid #f1f1ff;
}

/* BADGE */
.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
}

.badge-available{
    background:#d1fae5;
    color:#065f46;
}

.badge-empty{
    background:#fee2e2;
    color:#991b1b;
}

/* BUTTON TAMBAH */
.btn-add{
    background:#4f7cff;
    color:white;
    border:none;
    padding:10px 18px;
    font-size:14px;
    font-weight:600;
    border-radius:10px;
    display:flex;
    align-items:center;
    gap:6px;
    text-decoration:none;
}

.btn-add:hover{
    background:#3f6df0;
}

/* ACTION ICONS */
.action-icons{
    display:flex;
    gap:8px;
}

.icon-btn{
    width:34px;
    height:34px;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:16px;
    border:none;
    cursor:pointer;
    text-decoration:none;
    transition:0.2s;
}

/* EDIT */
.icon-edit{
    background:#eef2ff;
    color:#4f46e5;
}

.icon-edit:hover{
    background:#4f46e5;
    color:white;
}

/* DELETE */
.icon-delete{
    background:#fee2e2;
    color:#dc2626;
}

.icon-delete:hover{
    background:#dc2626;
    color:white;
}

/* DETAIL */
.icon-show{
    background:#ecfdf5;
    color:#059669;
}

.icon-show:hover{
    background:#059669;
    color:white;
}

/* PAGINATION CUSTOM */
.pagination .page-item .page-link{
    color:#4f7cff;
}
.pagination .page-item.active .page-link{
    background:#4f7cff;
    border-color:#4f7cff;
    color:white;
}
</style>

@php
$kategoris = $bukus->pluck('kategori')->unique();
@endphp

<div class="card card-custom">
    <div class="card-body">

        <h5 class="page-title">Kelola Data Buku</h5>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="filter-area">

            <form method="GET" action="{{ route('admin.databuku.index') }}" class="filter-left">
                <input type="text" name="search" placeholder="Cari Judul Buku..." value="{{ request('search') }}">

                <select name="kategori" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori')==$kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                    @endforeach
                </select>
                <button type="submit" style="padding:8px 14px; background:#4f7cff; color:white; border:none; border-radius:10px; cursor:pointer;">Cari</button>
            </form>

            <a href="{{ route('admin.databuku.create') }}" class="btn-add">
                <i class="bi bi-plus-lg"></i> Tambah Buku
            </a>

        </div>

        <div class="table-responsive">
            <table class="table align-middle" id="bukuTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Photo</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bukus as $buku)
                        <tr>
                            <td>{{ $loop->iteration + ($bukus->currentPage()-1)*$bukus->perPage() }}</td>
                            <td>
                                @if($buku->photo)
                                    <img src="{{ asset('storage/'.$buku->photo) }}" class="book-cover">
                                @else
                                    <img src="https://picsum.photos/60/90" class="book-cover">
                                @endif
                            </td>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->penulis }}</td>
                            <td>{{ $buku->kategori }}</td>
                            <td>{{ $buku->stok }}</td>
                            <td>Rp {{ number_format($buku->harga, 0, ',', '.') }}</td>
                            <td>
                                @if($buku->status == 'Tersedia')
                                    <span class="badge badge-available">Tersedia</span>
                                @else
                                    <span class="badge badge-empty">Habis</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('admin.databuku.edit',$buku->id) }}" class="icon-btn icon-edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.databuku.destroy',$buku->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="icon-btn icon-delete" onclick="return confirm('Yakin hapus buku?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.databuku.show',$buku->id) }}" class="icon-btn icon-show">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Data Buku Belum Ada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION ANGKA MIRIP <12> -->
        @php
            $totalPages = $bukus->lastPage();
            $currentPage = $bukus->currentPage();
        @endphp

        @if($totalPages > 1)
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <!-- Previous -->
                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $bukus->url($currentPage - 1) }}">Previous</a>
                </li>

                <!-- Page Numbers -->
                @for($i = 1; $i <= $totalPages; $i++)
                    @if($i == 1 || $i == $totalPages || ($i >= $currentPage - 2 && $i <= $currentPage + 2))
                        @if($i == $currentPage)
                            <li class="page-item active">
                                <span class="page-link">{{ $i }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $bukus->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @elseif($i == 2 && $currentPage > 4)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @elseif($i == $totalPages - 1 && $currentPage < $totalPages - 3)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                @endfor

                <!-- Next -->
                <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $bukus->url($currentPage + 1) }}">Next</a>
                </li>
            </ul>
        </nav>
        @endif

    </div>
</div>



@endsection