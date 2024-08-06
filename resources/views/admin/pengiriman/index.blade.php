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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportModal">
                                    Download Laporan
                                </button>
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
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.pengiriman.report') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Download Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-input-field label="Periode Tanggal" id="tgl" name="tgl"/>
                    <x-select-field label="Status" id="status" value="Pending" name="status" :options="[
                        ['label' => 'Menunggu Pickup', 'value' => 'Pending'],
                        ['label' => 'Dikirim', 'value' => 'Dikirim'],
                        ['label' => 'Diterima', 'value' => 'Diterima'],
                        ['label' => 'Selesai', 'value' => 'Selesai']
                    ]"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Download</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $("#field-tgl").flatpickr({
                altInput: true,
                altFormat: "j F Y",
                dateFormat: "Y-m-d",
                locale : "id",
                defaultDate: [new Date(Date.now() - 7 * 24 * 60 * 60 * 1000), new Date()],
                mode: "range"
            });
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

