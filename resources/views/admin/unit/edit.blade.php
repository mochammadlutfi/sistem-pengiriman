<x-app-layout>
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Ubah Kendaraan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.unit.index')}}">Unit Kendaraan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Ubah
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
                            <form method="POST" action="{{ route('admin.unit.update', $data->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-input-field name="no_polisi" id="no_polisi" label="No Polisi" value="{{ $data->no_polisi }}" />
                                        <x-input-field name="model" id="model" label="Model" value="{{ $data->model }}" />
                                        <x-select-field name="kapasitas" id="kapasitas" label="Kapasitas"  value="{{ $data->kapasitas }}" :options="[
                                            ['label' => 'Besar', 'value' => 'Besar'],
                                            ['label' => 'Sedang', 'value' => 'Sedang'],
                                            ['label' => 'Kecil', 'value' => 'Kecil'],
                                        ]"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-input-field name="merk" id="merk" label="Merk" value="{{ $data->merk }}" />
                                        <x-input-field name="tahun" id="tahun" label="Tahun" value="{{ $data->tahun }}" />
                                        <x-select-field name="status" id="status" label="Status" value="{{ $data->status }}"  :options="[
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

