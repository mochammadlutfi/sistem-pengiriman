<x-app-layout>
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Pengiriman</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pengiriman.index')}}">Pengiriman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tambah
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
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.pengiriman.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-select-field name="pelanggan_id" label="Pelanggan" id="pelanggan_id" :options="$pelanggan" />
                                        <div class="mb-4">
                                            <label for="field-tujuan">Alamat Tujuan</label>
                                            <textarea class="form-control {{ $errors->has('tujuan') ? 'is-invalid' : '' }}" rows="2" name="tujuan" id="field-tujuan"></textarea>
                                            <x-input-error :messages="$errors->get('tujuan')" class="mt-2" />
                                        </div>
                                        <x-input-field name="nama_penerima" id="nama_penerima" label="Nama Penerima"/>
                                        <x-input-field name="hp_penerima" id="hp_penerima" label="No HP Penerima"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-input-field name="surat_jalan" id="surat_jalan" label="Surat Jalan"/>
                                        <x-select-field name="kendaraan_id" label="Kendaraan" id="kendaraan_id" :options="$kendaraan" />
                                        <x-select-field name="driver_id" label="Driver" id="driver_id" :options="$driver" />
                                        <x-input-field name="barang" id="barang" label="Barang"/>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            </form>
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
        
        $("#field-tgl_lahir").flatpickr({
            altInput: true,
            altFormat: "d M Y",
            dateFormat: "Y-m-d",
            locale : "id",
        });
    </script>
    @endpush
</x-app-layout>

