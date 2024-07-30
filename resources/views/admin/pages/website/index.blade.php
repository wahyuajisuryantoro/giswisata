@extends('admin.layouts.app')

@section('content')
<div class="page-heading">
    <h3>Pengaturan Maps</h3>
</div>
    <section class="section" id="index-page">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Maps Sumba Barat</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWisataModal">
                            Tambah Wisata
                        </button>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="map-container">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal untuk menambahkan wisata -->
    <div class="modal fade" id="addWisataModal" tabindex="-1" aria-labelledby="addWisataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWisataModalLabel">Tambah Wisata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.wisata.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_admin" value="{{ Auth::guard('admin')->user()->id_admin }}">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" required>
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" required>
                        </div>
                        <div class="mb-3">
                            <label for="img_url" class="form-label">URL Gambar</label>
                            <input type="url" class="form-control" id="img_url" name="img_url" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit wisata -->
    <div class="modal fade" id="editWisataModal" tabindex="-1" aria-labelledby="editWisataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editWisataModalLabel">Edit Wisata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editWisataForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_id_admin" name="id_admin">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="edit_longitude" name="longitude" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="edit_latitude" name="latitude" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_img_url" class="form-label">URL Gambar</label>
                            <input type="url" class="form-control" id="edit_img_url" name="img_url" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }

        .map-container {
            position: relative;
            width: 100%;
            height: 500px;
        }
    </style>
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.js"></script>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoidmFscmVuZGEiLCJhIjoiY2x3cmQxNnV3MGNiaDJscTYyMnlmbTcwaSJ9.jZD6nYx3tJaQm9Z6FKyX2A';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/satellite-streets-v12',
            center: [119.1942, -9.3767],
            zoom: 9
        });

        map.addControl(new mapboxgl.NavigationControl());
        map.scrollZoom.disable();

        map.on('load', function() {
            const locations = @json($wisatas);

            locations.forEach(function(location) {
                const marker = new mapboxgl.Marker()
                    .setLngLat([location.longitude, location.latitude])
                    .setPopup(new mapboxgl.Popup({
                            offset: 30
                        })
                        .setHTML(`
                            <strong>${location.nama}</strong><br>
                            <img src="${location.img_url}" alt="${location.nama}" style="width:100%;"><br>
                            <button class="btn btn-warning btn-sm" onclick="openEditModal(${location.id_wisata})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteLocation(${location.id_wisata})">Hapus</button>
                        `))
                    .addTo(map);
            });
        });

        function openEditModal(id) {
            const location = @json($wisatas).find(wisata => wisata.id_wisata === id);
            if (location) {
                document.getElementById('edit_id_admin').value = location.id_admin;
                document.getElementById('edit_nama').value = location.nama;
                document.getElementById('edit_deskripsi').value = location.deskripsi;
                document.getElementById('edit_longitude').value = location.longitude;
                document.getElementById('edit_latitude').value = location.latitude;
                document.getElementById('edit_img_url').value = location.img_url;
                document.getElementById('editWisataForm').action = `/admin/wisata/${location.id_wisata}`;
                new bootstrap.Modal(document.getElementById('editWisataModal')).show();
            }
            document.getElementById('editWisataForm').onsubmit = function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                formData.append('_method', 'PUT');
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                }).then(response => {
                    console.log(response);
                    return response.json();
                }).then(data => {
                    if (data.success) {
                        Swal.fire('Success', data.success, 'success').then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.error || 'There was an error updating the entry.', 'error');
                    }
                }).catch(error => {
                    Swal.fire('Error', error.toString(), 'error');
                });
            };
        }


            function deleteLocation(id) {
                if (confirm('Apakah Anda yakin ingin menghapus lokasi ini?')) {
                    fetch(`/admin/wisata/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => {
                        if (response.headers.get('content-type')?.includes('application/json')) {
                            return response.json();
                        } else {
                            throw new Error('Invalid JSON response');
                        }
                    }).then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil', data.success, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal', data.error || 'Gagal menghapus wisata.', 'error');
                        }
                    }).catch(error => {
                        Swal.fire('Gagal', error.message, 'error');
                    });
                }
            }
    </script>
@endpush
