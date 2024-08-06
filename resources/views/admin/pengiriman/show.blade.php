<x-app-layout>
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Pengiriman 

                    </h3>
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
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title fs-3">
                    @if($data->status == 'Pending')
                        <span class="badge bg-warning">Menunggu Pickup</span>
                    @elseif($data->status == 'Dikirim')
                        <span class="badge bg-success">Diproses</span>
                    @elseif($data->status == 'Diterima')
                        <span class="badge bg-warning">Diproses</span>
                    @elseif($data->status == 'selesai')
                        <span class="badge bg-primary">Diproses</span>
                    @endif
                    </h3>
                    <div class="card-tools">
                        @if (auth()->user()->level == 'Driver')
                            @if(empty($data->bukti))
                            <button type="button" class="btn btn-primary" onclick="uploadBukti()">
                                <i class="fa fa-plus me-1"></i>
                                Upload Bukti Surat Jalan
                            </button>
                            @endif
                            @if($data->status == 'Pending')

                            <button type="button" class="btn btn-primary" onclick="updateStatus('Dikirim')">
                                <i class="fa fa-plus me-1"></i>
                                Mengirim
                            </button>
                            @elseif($data->status == 'Dikirim')
                            <button type="button" class="btn btn-primary" onclick="updateStatus('Diterima')">
                                <i class="fa fa-plus me-1"></i>
                                Diterima
                            </button>
                            @elseif($data->status == 'Diterima')

                            <button type="button" class="btn btn-primary" onclick="updateStatus('selesai')">
                                <i class="fa fa-plus me-1"></i>
                                Selesai
                            </button>
                            @endif
                        @else
                        <a href="{{ route('admin.pengiriman.pdf', $data->id)}}" class="btn btn-primary">
                            Invoice
                        </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <x-field-read label="No Pengiriman" value="{{ $data->nomor }}"/>
                            <x-field-read label="Pelanggan" value="{{ $data->pelanggan->nama }}"/>
                            <x-field-read label="Tujuan" value="{{ $data->tujuan }}"/>
                            <x-field-read label="Nama Penerima" value="{{ $data->nama_penerima }}"/>
                            <x-field-read label="No HP Penerima" value="{{ $data->hp_penerima }}"/>
                        </div>
                        <div class="col-6">
                            <x-field-read label="No Surat Jalan" value="{{ $data->surat_jalan }}"/>
                            <x-field-read label="Tanggal" value="{{ $data->tgl }}"/>
                            <x-field-read label="Unit Kendaraan" value="{{ $data->kendaraan->merk }} - {{ $data->kendaraan->model }} | {{ $data->kendaraan->no_polisi }}"/>
                            <x-field-read label="Driver" value="{{ $data->driver->nama }}"/>
                            @if ($data->bukti)
                                
                            <x-field-read label="Bukti Surat Jalan" >
                                @slot('value')
                                <a target="_blank" href="{{ $data->bukti }}" class="btn btn-sm btn-primary">
                                    Lihat Bukti Surat Jalan
                                </a>
                                @endslot
                            </x-field-read>
                            @endif
                        </div>
                    </div>
                    <table id="table-detail" class="table table-bordered table-vcenter">
                        <thead>
                            <tr>
                                <th width="200px">No DO</th>
                                <th width="250px">Nama Barang</th>
                                <th width="100px">Jumlah</th>
                                <th width="120px">Satuan</th>
                                <th>Fee Satuan</th>
                                <th width="150px">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->detail as $d)
                            <tr>
                                <td>{{ $d->do }}</td>
                                <td>{{ $d->barang }}</td>
                                <td>{{ $d->qty }}</td>
                                <td>{{ $d->satuan }}</td>
                                <td>Rp. {{ number_format($d->fee,0,',','.') }}</td>
                                <td>Rp. {{ number_format($d->subtotal,0,',','.') }}</td>
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
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Aktivitas</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" onclick="create()">
                            <i class="fa fa-plus me-1"></i>
                            Tambah Aktivitas
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered w-100" id="aktivitasTable">
                        <thead>
                            <tr>
                                <th width="60px">No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th width="160px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalBukti" aria-labelledby="modalBukti" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="buktiForm" method="POST" onsubmit="return false;" enctype="multipart/form-data">
                    <input type="hidden" id="field-id" value="" />

                    <div class="modal-header">
                        <h5 class="modal-title">Bukti Surat Jalan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <x-input-field type="file" name="bukti" id="bukti" label="Bukti pengiriman" isAjax />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="btn-simpan">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="modalAktivitas" aria-labelledby="modalAktivitas" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="aktivitasForm" method="POST" onsubmit="return false;" enctype="multipart/form-data">
                    <input type="hidden" id="field-id" value="" />
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Aktivitas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <x-input-field type="text" name="tgl" id="tgl" label="Tanggal" isAjax />
                        <x-input-field type="text" name="keterangan" id="keterangan" label="Keterangan" isAjax />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="btn-simpan">
                            Simpan
                        </button>
                    </div>
                </form>
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
        
        $(function () {
            $('#aktivitasTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.aktivitas.index', $data->id) }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'tgl',
                        name: 'tgl'
                    }, {
                        data: 'keterangan',
                        name: 'keterangan'
                    },{
                        data : 'action',
                        name : 'action',
                    }
                ]
            });
        });
        $("#field-tgl").flatpickr({
            altInput: true,
            defaultDate : new Date(),
            altFormat: "d F Y H:i",
            dateFormat: "Y-m-d H:i",
            locale : "id",
            enableTime : true,
            timeFormat : 24,
        });
        

        function uploadBukti(){
            const form = document.getElementById('modalBukti');
            $("#modalBukti").find('.modal-title').html("Upload Bukti Surat Jalan");
            var modalForm = bootstrap.Modal.getOrCreateInstance(form);
            modalForm.show();
        }

        function create(){
            const form = document.getElementById('modalAktivitas');
            $("#modalAktivitas").find('.modal-title').html("Tambah Aktivitas");
            var modalForm = bootstrap.Modal.getOrCreateInstance(form);
            modalForm.show();
        }
        function updateStatus(status){
            var content ='';
            if(status == 'Dikirim'){
                var content = 'Siap Kirim?';
            }else if(status == 'Diterima'){
                var content = 'Sudah sampai tujuan?';
            }else{
                var content = 'Sudah Kembali?';
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
                                url: "{{ route('admin.pengiriman.status', $data->id) }}",
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
        function hapus(order,id){
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
                                url: `/aktivitas/${order}/${id}/delete`,
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
            
            $("#aktivitasForm").on("submit",function (e) {
            e.preventDefault();
            var fomr = $('form#aktivitasForm')[0];
            var formData = new FormData(fomr);
            let token   = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', token);

            var pengiriman = "{{ $data->id }}";
            var id = $("#field-id").val();
            var url = (id != "") ? `/aktivitas/${pengiriman}/${id}/update` :`/aktivitas/${pengiriman}/store`;

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.fail == false) {
                        location.reload();
                    } else {
                        for (control in response.errors) {
                            $('#field-' + control).addClass('is-invalid');
                            $('#error-' + control).html(response.errors[control]);
                        }
                    }
                },
                error: function (error) {
                }

            });

        });

        $("#buktiForm").on("submit",function (e) {
            e.preventDefault();
            var fomr = $('form#buktiForm')[0];
            var formData = new FormData(fomr);
            let token   = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', token);

            var id = $("#field-id").val();
            var url = " {{ route('admin.aktivitas.index', $data->id) }}";

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.fail == false) {
                        location.reload();
                    } else {
                        for (control in response.errors) {
                            $('#field-' + control).addClass('is-invalid');
                            $('#error-' + control).html(response.errors[control]);
                        }
                    }
                },
                error: function (error) {
                }

            });

        });
        
    </script>
    @endpush
</x-app-layout>

