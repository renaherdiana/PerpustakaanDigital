@extends('layouts.backend.superadmin.app')

@section('content')

<style>
/* ===== PAGE TITLE ===== */
.page-title {
    font-weight: 700;
    font-size: 20px;
    margin-bottom: 25px;
    color: #1e293b;
}

/* ===== CARD ===== */
.card-custom {
    border: none;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.05);
    padding: 20px;
}

/* ===== FILTER AREA ===== */
.filter-area {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    align-items: center;
    flex-wrap: wrap;
}

.filter-area .form-select,
.filter-area .form-control {
    border-radius: 12px;
    padding: 6px 12px;
}

/* ===== ADD BUTTON ===== */
.btn-add {
    background: linear-gradient(135deg,#7c6cf3,#9f8cff);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 8px 18px;
    font-weight: 500;
    text-decoration: none;
    transition: 0.3s;
}

.btn-add:hover {
    opacity: 0.9;
}

/* ===== TABLE ===== */
.table thead {
    background: #f8f8fb;
}

.table th {
    font-weight: 600;
    color: #555;
}

.table td {
    vertical-align: middle;
}

/* ===== PHOTO ===== */
.user-photo {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #f1f1ff;
}

/* ===== STATUS BADGE ===== */
.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    text-transform: capitalize;
}

.badge-active {
    background: #d1fae5;
    color: #065f46;
}

.badge-inactive {
    background: #fee2e2;
    color: #991b1b;
}

/* ===== ACTION ICONS ===== */
.action-icons {
    display: flex;
    gap: 8px;
}

.icon-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: 0.2s;
}

/* Edit */
.icon-edit {
    background: #eef2ff;
    color: #4f46e5;
}

.icon-edit:hover {
    background: #4f46e5;
    color: white;
}

/* Delete */
.icon-delete {
    background: #fee2e2;
    color: #dc2626;
}

.icon-delete:hover {
    background: #dc2626;
    color: white;
}

/* Detail */
.icon-show {
    background: #ecfdf5;
    color: #059669;
}

.icon-show:hover {
    background: #059669;
    color: white;
}

/* RESPONSIVE */
@media(max-width:768px){
    .filter-area {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<div class="card card-custom">
    <div class="card-body">

        <h5 class="page-title">Kelola Data Petugas</h5>

        <!-- FILTER & SEARCH -->
        <form method="GET" class="filter-area">

            <input type="text" name="search" placeholder="Cari Nama..." value="{{ request('search') }}" class="form-control" style="width:200px;">

            <select name="status" class="form-select" style="width:150px;">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status')=='aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidak aktif" {{ request('status')=='tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>

            <button type="submit" class="btn btn-primary">Filter</button>

            <div class="ms-auto">
                <a href="{{ route('superadmin.datauser.create') }}" class="btn-add">
                    + Tambah Petugas
                </a>
            </div>

        </form>

        <!-- TABLE -->
        <div class="table-responsive mt-3">
            <table class="table align-middle table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Photo</th>
                        <th>Nama Petugas</th>
                        <th>No Telephone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $key => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $key }}</td>
                        <td>
                            @if($user->photo)
                                <img src="{{ asset('storage/'.$user->photo) }}" class="user-photo">
                            @else
                                <img src="https://i.pravatar.cc/45?img={{ $key+1 }}" class="user-photo">
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            <span class="badge {{ $user->status == 'aktif' ? 'badge-active' : 'badge-inactive' }}">
                                {{ $user->status == 'tidak_aktif' ? 'Tidak Aktif' : ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-icons">
                                <a href="{{ route('superadmin.datauser.edit',$user->id) }}" class="icon-btn icon-edit" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('superadmin.datauser.destroy',$user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="icon-btn icon-delete" title="Hapus" onclick="return confirm('Yakin hapus petugas?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                                <a href="{{ route('superadmin.datauser.show',$user->id) }}" class="icon-btn icon-show" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data Petugas Belum Ada</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="mt-3 d-flex justify-content-end">
                {{ $users->links() }}
            </div>
        </div>

    </div>
</div>

@endsection