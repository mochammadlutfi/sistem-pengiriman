<x-app-layout>
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Ubah Pengiriman</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pengiriman.index')}}">Pengiriman</a></li>
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
                            <form method="POST" action="{{ route('admin.pengiriman.update', $data->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-select-field name="pelanggan_id" label="Pelanggan" id="pelanggan_id" value="{{ $data->pelanggan_id }}" :options="$pelanggan" />
                                        <div class="mb-4">
                                            <label for="field-tujuan">Alamat Tujuan</label>
                                            <textarea class="form-control {{ $errors->has('tujuan') ? 'is-invalid' : '' }}" rows="2" name="tujuan" id="field-tujuan">{{ old('tujuan', $data->tujuan) }}</textarea>
                                            <x-input-error :messages="$errors->get('tujuan')" class="mt-2" />
                                        </div>
                                        <x-input-field name="nama_penerima" id="nama_penerima" label="Nama Penerima" value="{{ $data->nama_penerima }}"/>
                                        <x-input-field name="hp_penerima" id="hp_penerima" label="No HP Penerima" value="{{ $data->hp_penerima }}"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-input-field name="surat_jalan" id="surat_jalan" label="Surat Jalan" value="{{ $data->surat_jalan }}"/>
                                        <x-input-field type="date" name="tgl" id="tgl" label="Tanggal Kirim" value="{{ $data->tgl }}"/>
                                        <x-select-field name="kendaraan_id" label="Kendaraan" id="kendaraan_id" :options="$kendaraan"  value="{{ $data->kendaraan_id }}"/>
                                        <x-select-field name="driver_id" label="Driver" id="driver_id" :options="$driver"  value="{{ $data->user_id }}"/>
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
                                            <th width="70px">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->detail as $d)
                                        <tr class="row-{{ $loop->index }}">
                                            <td>
                                                <input type="text" class="form-control" name="lines[{{ $loop->index }}][do]" value="{{ $d->do }}"/>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="lines[{{ $loop->index }}][barang]" value="{{ $d->barang }}"/>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control line-qty" name="lines[{{ $loop->index }}][jumlah]" min="1" value="{{ $d->qty }}"/>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="lines[{{ $loop->index }}][satuan]" value="{{ $d->satuan }}"/>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control line-harga" name="lines[{{ $loop->index }}][harga]" value="{{ $d->fee }}"/>
                                            </td>
                                            <td>
                                                <span class="showSubtotal">Rp. {{ number_format($d->subtotal,0,',','.') }}</span>
                                                <input type="hidden" class="line-id" name="lines[{{ $loop->index }}][id]" value="{{ $d->id }}"/>
                                                <input type="hidden" class="line-subtotal" name="lines[{{ $loop->index }}][subtotal]" value="{{ $d->subtotal }}"/>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                                            </td>
                                        </tr>                                            
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7">
                                                <button type="button" class="btn btn-primary w-100" onclick="addRow()">
                                                    Tambah
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row">
                                    <div class="col-md-9">
                                        <h5 class="fs-5">Total</h5>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="fs-5" id="showTotal">Rp. {{ number_format($data->total,0,',','.') }}</h5>
                                        <input type="hidden" class="form-control" name="total" id="field-total" value="{{ $data->total }}"/>

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
        
        let idx = "{{ count($data->detail) }}";
        var table = $("#table-detail");
        $("#field-tgl").flatpickr({
            altInput: true,
            defaultDate : 'today',
            altFormat: "d M Y",
            dateFormat: "Y-m-d",
            locale : "id",
        });
        
        $(document).on('click', '.btn-delete', function() {
            $(this).closest('tr').remove();
            idx--;
            calculateTotal();

        });
        
        $(document).on('change', '.line-harga', function() {
            var tr = $(this).closest('tr');
            var harga = $(this).val();
            var qty = tr.find('.line-qty').val();
            if(qty < 1){
                $(this).val(1);
            }
            tr.find('.line-subtotal').val(harga * qty);
            tr.find('.showSubtotal').html(currency(harga * qty));
            calculateTotal();

        });

        $(document).on('change', '.line-qty', function() {
            var qty = $(this).val();
            var tr = $(this).closest('tr');
            var harga = tr.find('.line-harga').val();
            if(qty < 1){
                $(this).val(1);
            }
            tr.find('.line-subtotal').val(harga * qty);
            tr.find('.showSubtotal').html(currency(harga * qty));
            calculateTotal();

        });

        function calculateTotal() {
            let total = 0;
            $('#table-detail tbody .line-subtotal').each(function() {
                let harga = parseFloat($(this).val());
                if (!isNaN(harga)) {
                    total += harga;
                }
            });

            var lama = $("#field-lama").val();
            $('#showTotal').html(currency(total));
            $('#field-total').val(total);
        }

        function addRow(){

            var row = `
                <tr class="row-${idx}">
                    <td>
                        <input type="text" class="form-control" name="lines[${idx}][do]"/>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="lines[${idx}][barang]"/>
                    </td>
                    <td>
                        <input type="number" class="form-control line-qty" name="lines[${idx}][jumlah]" min="1" value="1"/>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="lines[${idx}][satuan]"/>
                    </td>
                    <td>
                        <input type="number" class="form-control line-harga" name="lines[${idx}][harga]"/>
                    </td>
                    <td>
                        <span class="showSubtotal">Rp. 0 </span>
                        <input type="hidden" class="line-subtotal" name="lines[${idx}][subtotal]"/>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                    </td>
                </tr>`;
            idx++;
            table.find("tbody").append(row);

            console.log($('#table-detail tbody tr').length);
            calculateTotal()
        }
    </script>
    @endpush
</x-app-layout>

