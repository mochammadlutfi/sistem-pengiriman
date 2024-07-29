<x-app-layout>
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Unit</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.unit.index')}}">Unit Kendaraan</a></li>
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
                            <form method="POST" action="{{ route('admin.unit.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-input-field name="no_polisi" id="no_polisi" label="No Polisi"/>
                                        <x-input-field name="model" id="model" label="Model"/>
                                        <x-select-field name="kapasitas" id="kapasitas" label="Kapasitas" :options="[
                                            ['label' => 'Besar', 'value' => 'Besar'],
                                            ['label' => 'Sedang', 'value' => 'Sedang'],
                                            ['label' => 'Kecil', 'value' => 'Kecil'],
                                        ]"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-input-field name="merk" id="merk" label="Merk"/>
                                        <x-input-field name="tahun" id="tahun" label="Tahun"/>
                                        <x-select-field name="status" id="status" label="Status" :options="[
                                            ['label' => 'Normal', 'value' => 'Normal'],
                                            ['label' => 'Rusak', 'value' => 'Rusak'],
                                        ]"/>
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

