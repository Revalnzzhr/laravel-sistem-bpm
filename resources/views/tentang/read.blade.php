@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">


<div class="d-flex flex-column min-vh-100 p-5 pt-0">
    <div class="ms-5 ps-3">
        <div style="display: flex; align-items: center; ">
            <span style="color: #2654A1; font-size: 5rem; margin-right: 10px; cursor: pointer;" onclick="window.location.href='/tentang'">&#x2039;</span>
            <h2 style="color: #2654A1; margin: 0; padding-top:1rem;">Kelola Tentang</h2>
        </div>
    </div>


    <div class="table-container bg-white p-3 m-5 mt-0 rounded">
        <table class="table table-hover table-striped table-bordered">
            <thead style="text-align: center;">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @forelse ($tentangs as $tentang)
                <tr class="align-middle">
                    <td>{{$i++}}
                    </td>
                    <td>{{ $tentang->ten_category }}</td>
                    <td>
                        <form style="text-align: center;">
                            <a href="{{ route('tentang.show', $tentang->id) }}" class=" btn btn-success btn-sm me-1">
                                <i class="mdi mdi-eye"></i>
                            </a>
                            <a href="{{ route('tentang.edit', $tentang->id) }}" class="btn btn-primary btn-sm me-1">
                                <i class="mdi mdi-pencil"></i>
                            </a>

                        </form>
                    </td>
                </tr>
                @empty
                <tr class="align-middle">
                    <td colspan="6" class="text-center">Data tidak tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 CDN -->
<script>
    // Menampilkan SweetAlert jika ada pesan flash 'success'
    if (session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session("success")}}',
            icon: 'success',
            confirmButtonText: 'Tutup'
        });
</script>
@endsection

@endsection