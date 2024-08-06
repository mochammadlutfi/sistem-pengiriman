<x-app-layout>
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Pembelian</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pengiriman.index')}}">Pengiriman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $data->nomor }}
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
                            <h3 class="card-title fs-3">
                            @if($data->status == 'Draft')
                                <span class="badge bg-warning">Menunggu Persetujuan</span>
                            @elseif($data->status == 'Pending')
                                <span class="badge bg-primary">Menunggu Penerimaan</span>
                            @elseif($data->status == 'Diterima')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Dibatalkan</span>
                            @endif
                            </h3>
                            <div class="card-tools">
                                @if(auth()->user()->level == 'Pimpinan')
                                <button type="button" class="btn btn-primary" onclick="updateStatus('Pending')">
                                    <i class="fa fa-check me-1"></i>
                                    Setuju
                                </button>
                                <button type="button" class="btn btn-danger" onclick="updateStatus('Ditolak')">
                                    <i class="fa fa-close me-1"></i>
                                    Tolak
                                </button>
                                @endif
                                @if($data->status == 'Pending')
                                <button type="button" class="btn btn-primary" onclick="updateStatus('Diterima')">
                                    <i class="fa fa-check me-1"></i>
                                    Terima Barang
                                </button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <x-field-read label="Supplier" value="{{ $data->supplier }}"/>
                                </div>
                                <div class="col-6">
                                    <x-field-read label="Tanggal" value="{{ $data->tgl }}"/>
                                </div>
                            </div>
                            <table id="table-detail" class="table table-bordered table-vcenter">
                                <thead>
                                    <tr>
                                        <th width="70px">No</th>
                                        <th width="250px">Nama Barang</th>
                                        <th width="100px">Jumlah</th>
                                        <th>Harga</th>
                                        <th width="150px">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->detail as $d)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $d->sparepart->nama }}</td>
                                        <td>{{ $d->jml }}</td>
                                        <td>Rp. {{ number_format($d->harga,0,',','.') }}</td>
                                        <td>Rp. {{ number_format($d->harga*$d->jml,0,',','.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row mt-3">
                                <div class="col-md-9">
                                    <h5 class="fs-5 text-end">Total</h5>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="fs-5" id="showTotal">Rp. {{ number_format($data->total,0,',','.') }}</h5>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    @endpush

    @push('scripts')
    <script src="/js/plugins/flatpickr/flatpickr.min.js"></script>
    <script src="/js/plugins/flatpickr/l10n/id.js"></script>
    <script src="/js/plugins/ckeditor5-classic/build/ckeditor.js"></script>
    <script>
        
        $("#field-tgl").flatpickr({
            altInput: true,
            defaultDate : 'today',
            altFormat: "d M Y",
            dateFormat: "Y-m-d",
            locale : "id",
        });
        function updateStatus(status){
            var content ='';
            if(status == 'Pending'){
                var content = 'Setuju Pengajuan Pembelian?';
            }else if(status == 'Ditolak'){
                var content = 'Tolak Pengajuan Pembelian?';
            }else{
                var content = 'Barang Sudah Diterima?';
            }

            $.confirm({
                title: 'Update Status!',
                content: content,
                buttons: {
                    cancel: {
                        text: 'Tidak',
                        btnClass: 'btn-red',
                    },
                    confirm: {
                        text: 'Ya',
                        btnClass: 'btn-primary',
                        action : function () {
                            $.ajax({
                                url: "{{ route('admin.pembelian.status', $data->id) }}",
                                type: "POST",
                                data : {
                                    status : status,
                                    _token : $("meta[name='csrf-token']").attr("content"),
                                },
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

