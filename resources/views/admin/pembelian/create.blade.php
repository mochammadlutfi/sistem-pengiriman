<x-app-layout>
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Pembelian</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pembelian.index')}}">Pembelian</a></li>
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
                            <form method="POST" action="{{ route('admin.pembelian.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-input-field name="supplier" id="supplier" label="Supplier"/>
                                    </div>
                                    <div class="col-md-6">
                                        <x-input-field name="tgl" id="tgl" label="Tanggal"/>
                                    </div>
                                </div>
                                <table id="table-detail" class="table table-bordered table-vcenter">
                                    <thead>
                                        <tr>
                                            <th width="300px">Sparepart</th>
                                            <th width="70px">Stok</th>
                                            <th width="100px">Jumlah</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                            <th width="100px">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control produk-select" name="lines[0][sparepart_id]">
                                                    <option>Pilih</option>
                                                    @foreach ($sparepart as $s)
                                                        <option value="{{ $s->id}}">{{ $s->nama }}<option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <span class="showStok">0 </span>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control line-qty" name="lines[0][jumlah]" min="1" value="1"/>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control line-harga" name="lines[0][harga]"/>
                                            </td>
                                            <td>
                                                <span class="showSubtotal">Rp. 0 </span>
                                                <input type="hidden" class="line-subtotal" name="lines[0][subtotal]"/>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
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
                                        <h5 class="fs-5" id="showTotal">Rp. 0</h5>
                                        <input type="hidden" class="form-control" name="total" id="field-total"/>

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
        
        $("#field-tgl").flatpickr({
            altInput: true,
            defaultDate : 'today',
            altFormat: "d F Y",
            dateFormat: "Y-m-d",
            locale : "id",
        });
        let idx = 1;
        var table = $("#table-detail");

        $(document).on('change', '.produk-select', function() {
            var val = $(this).val();
            var tr = $(this).closest('tr');
            var qty = tr.find('.line-qty').val();
            $.ajax({ 
                type: 'GET', 
                url: `/sparepart/${val}/show`,
                dataType: 'json',
                success: function (data) {
                    tr.find('.showStok').html(data.stok);
                }
            });
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
                        <select class="form-control produk-select" name="lines[${idx}][sparepart_id]">
                            <option>Pilih</option>
                            @foreach ($sparepart as $s)
                                <option value="{{ $s->id}}">{{ $s->nama }}<option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <span class="showStok">0 </span>
                    </td>
                    <td>
                        <input type="number" class="form-control line-qty" name="lines[${idx}][jumlah]" min="1" value="1"/>
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
                </tr>
                </tr>`;
            idx++;
            table.find("tbody").append(row);

            console.log($('#table-detail tbody tr').length);
            calculateTotal()
        }
    </script>
    @endpush
</x-app-layout>

