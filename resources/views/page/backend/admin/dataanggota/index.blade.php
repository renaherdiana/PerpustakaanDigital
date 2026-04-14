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

/* BADGE STATUS */
.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
}

.badge-active{
    background:#d1fae5;
    color:#065f46;
}

.badge-inactive{
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

</style>

<div class="card card-custom">
    <div class="card-body">

        <h5 class="page-title">Kelola Data Anggota</h5>

        <div class="filter-area">

            <form method="GET" action="{{ route('admin.anggota.index') }}" class="filter-left">
                <input type="text" name="search" placeholder="Cari Nama Anggota..." value="{{ request('search') }}">

                <select name="status" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status')=='aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status')=='tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <button type="submit" style="padding:8px 14px; background:#4f7cff; color:white; border:none; border-radius:10px; cursor:pointer;">Cari</button>
            </form>

            <a href="{{ route('admin.anggota.create') }}" class="btn-add">
                <i class="bi bi-plus-lg"></i> Tambah Anggota
            </a>

        </div>

        <div class="table-responsive">

            <table class="table align-middle" id="anggotaTable">
               <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th> <!-- ganti NIS jadi Email -->
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($anggota as $item)
                    <tr data-status="{{ $item->status }}">
                        <td>{{ $loop->iteration + ($anggota->currentPage()-1) * $anggota->perPage() }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email }}</td> <!-- tampilkan email -->
                        <td>{{ $item->kelas }}</td>
                        <td>
                            @if($item->status == 'aktif')
                                <span class="badge badge-active">Aktif</span>
                            @else
                                <span class="badge badge-inactive">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-icons">
                                <a href="{{ route('admin.anggota.edit',$item->id) }}" 
                                class="icon-btn icon-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('admin.anggota.destroy',$item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="icon-btn icon-delete"
                                        onclick="return confirm('Yakin hapus anggota?')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                                <a href="{{ route('admin.anggota.show',$item->id) }}" 
                                class="icon-btn icon-show" title="Detail">
                                <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Data Anggota Belum Ada
                    </td>
                </tr>
                @endforelse
            </tbody>

            </table>

            <!-- PAGINATION -->
            <div class="d-flex justify-content-end mt-3">
                {{ $anggota->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>



@endsection