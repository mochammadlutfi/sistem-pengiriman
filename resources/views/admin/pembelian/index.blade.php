<x-app-layout>
    
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Pembelian</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Data Pembelian
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
                            <a href="{{ route('admin.pembelian.create')}}" class="btn btn-primary">
                                Tambah
                            </a>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered datatable w-100">
                                <thead>
                                    <tr>
                                        <th width="60px">#</th>
                                        <th>Nomor</th>
                                        <th>Tanggal</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th width="60px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $d->nomor }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->tgl)->translatedFormat('d F Y') }}</td>
                                        <td>{{ $d->supplier }}</td>
                                        <td>{{ $d->status }}</td>
                                        <td>
                                            Rp {{ number_format($d->total,0,',','.') }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="d-flex dropdown-item justify-between justify-content-between" href="{{ route('admin.pembelian.edit', $d->id)}}">
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
                                url: "/pembelian/"+ id +"/delete",
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

