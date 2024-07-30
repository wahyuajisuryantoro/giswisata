@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manajemen Akun</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-lg">
                                <a href="{{ route('admin.akun.add') }}" class="btn btn-outline-primary">Tambah Admin</a>
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->username }}</td>
                                        <td>{{ $admin->nama }}</td>
                                        <td>
                                            <a href="{{ route('admin.akun.edit', ['id' => $admin->id_admin]) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('admin.akun.destroy', ['id' => $admin->id_admin]) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
