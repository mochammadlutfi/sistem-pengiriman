<x-app-layout>
    
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Unit Kendaraan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Data Unit Kendaraan
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div>
    <div class="app-content"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-12"> 
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.unit.create')}}" class="btn btn-primary">
                                Tambah
                            </a>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered datatable w-100">
                                <thead>
                                    <tr>
                                        <th width="60px">No</th>
                                        <th>No Polisi</th>
                                        <th>Model</th>
                                        <th>Merk</th>
                                        <th>Tahun</th>
                                        <th>Kapasitas</th>
                                        <th>Status</th>
                                        <th width="60px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $d->no_polisi }}</td>
                                        <td>{{ $d->model }}</td>
                                        <td>{{ $d->merk }}</td>
                                        <td>{{ $d->tahun }}</td>
                                        <td>{{ $d->kapasitas }}</td>
                                        <td>{{ $d->status }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="d-flex dropdown-item justify-between justify-content-between" href="{{ route('admin.unit.edit', $d->id)}}">
                                                            Ubah
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="d-flex dropdown-item justify-between justify-content-between" href="#" onclick="hapus({{ $d->id }})">
                                                            Hapus
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
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
    </div>
    
    @push('scripts')
        <script>
        function hapus(id){
            $.confirm({
                title: 'Hapus Data!',
                content: 'Apakah Anda yakin ingin menghapus data ini?',
                buttons: {
                    cancel: {
                        text: 'Tidak, Batal',
                        btnClass: 'btn-red',
                    },
                    confirm: {
                        text: 'Ya, Hapus',
                        btnClass: 'btn-primary',
                        action : function () {
                            $.ajax({
                                url: "/unit/"+ id +"/delete",
                                type: "DELETE",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                success: function(data) {
                                    location.reload();
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                }
                            });
                        }
                    },
                }
            });
        }
        </script>
    @endpush

</x-app-layout>

