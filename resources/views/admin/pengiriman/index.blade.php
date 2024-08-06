<x-app-layout>
    
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Pengiriman</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Data Pengiriman
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
                        @if(auth()->user()->level != 'Driver')
                        <div class="card-header">
                            <a href="{{ route('admin.pengiriman.create')}}" class="btn btn-primary">
                                Tambah
                            </a>
                            <div class="card-tools">
                            </div>
                        </div>
                        @endif
                        <div class="card-body">
                            <table class="table table-bordered datatable w-100">
                                <thead>
                                    <tr>
                                        <th width="60px">#</th>
                                        <th>Nomor</th>
                                        <th>Pelanggan</th>
                                        <th>Tujuan</th>
                                        <th>Surat Jalan</th>
                                        <th>Kendaraan</th>
                                        <th>Driver</th>
                                        <th>Status</th>
                                        <th width="60px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $d->nomor }}</td>
                                        <td>{{ $d->pelanggan->nama }}</td>
                                        <td>{{ $d->tujuan }}</td>
                                        <td>{{ $d->surat_jalan }}</td>
                                        <td>{{ $d->kendaraan->no_polisi }}</td>
                                        <td>{{ $d->driver->nama }}</td>
                                        <td>{{ $d->status }}</td>
                                        <td>
                                            
                                            @if(auth()->user()->level != 'Driver')
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="d-flex dropdown-item justify-between justify-content-between" href="{{ route('admin.pengiriman.show', $d->id)}}">
                                                            Detail
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="d-flex dropdown-item justify-between justify-content-between" href="{{ route('admin.pengiriman.edit', $d->id)}}">
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
                                                @else
                                                <a class="btn btn-primary btn-sm" href="{{ route('admin.pengiriman.show', $d->id)}}">
                                                    Detail
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @endif
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
                                url: "/pelanggan/"+ id +"/delete",
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

