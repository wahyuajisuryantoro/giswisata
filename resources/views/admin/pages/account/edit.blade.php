@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="col-12 col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4>Edit Akun Admin</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.akun.update', $admin->id_admin) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_admin" value="{{ $admin->id_admin }}">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $admin->username }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $admin->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (ubah jika perlu)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
