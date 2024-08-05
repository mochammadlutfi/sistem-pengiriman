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
                            {{-- <a href="{{ route('admin.pengiriman.pdf', $data->id)}}" class="btn btn-primary">
                                Invoice
                            </a> --}}
                            <div class="card-tools">
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
    </script>
    @endpush
</x-app-layout>

