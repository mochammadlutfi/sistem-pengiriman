<x-app-layout>
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Pelanggan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pelanggan.index')}}">Pelanggan</a></li>
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
                            <form method="POST" action="{{ route('admin.pelanggan.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-input-field name="nama" id="nama" label="Nama"/>
                                        <x-input-field name="telp" id="telp" label="telp"/>
                                        <x-input-field name="email" id="email" label="Email"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-input-field name="nama_cp" id="nama_cp" label="Nama Kontak"/>
                                        <x-input-field name="hp_cp" id="hp_cp" label="No HP/Wa Kontak"/>
                                        <div class="mb-4">
                                            <label for="field-alamat">Alamat</label>
                                            <textarea class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}" rows="2" name="alamat" id="field-alamat"></textarea>
                                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                                        </div>
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

