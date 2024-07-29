<x-landing-layout>
    <div class="bg-primary text-center">
        <div class="content text-center">
            <div class="py-3">
                <h1 class="fw-bold text-white mb-4">Pembayaran</h1>
                <h3 class="fs-base text-white">Segera Lakukan Pembayaran Sebelum Tanggal</h3>
            </div>
        </div>
    </div>
    <div class="content content-full">
        <div class="row">
            <div class="col-4">
                <div class="block block-bordered rounded">
                    <div class="block-content p-3">
                        <h3 class="fs-4 fw-semibold">Rekening Pembayaran</h3>
                        @foreach ($bank as $d)
                        <div class="block border border-3 rounded-3 mb-2">
                            <div class="block-content p-3 text-center">
                                <div class="g-2 row">
                                    <div class="col-5 d-flex">
                                        <img src="{{ $d['img'] }}" class="w-100">
                                    </div>
                                    <div class="col-7">
                                        <div class="fs-base fw-bold">{{ $d['rek'] }}</div>
                                        <div class="fs-sm">A.n {{ $d['an'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="block block-bordered rounded">
                    <div class="block-content p-3">
                        <h3 class="fs-4 fw-semibold">Konfirmasi Pembayaran</h3>
                        <form method="POST" action="{{ route('user.training.update', $data->id)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input-field type="text" id="nama" name="nama" label="Nama Pengirim" required/>
                                    <x-select-field id="bank" name="bank" label="Rekening Tujuan" :options="[
                                        ['value' => 'BCA', 'label' => 'Bank BCA'],
                                        ['value' => 'BNI', 'label' => 'Bank BNI'],
                                        ['value' => 'Mandiri', 'label' => 'Bank Mandiri'],
                                    ]" />
                                    <div class="mb-4">
                                        <label class="form-label" for="field-bukti">Bukti Bayar</label>
                                        <input class="form-control" type="file" name="bukti" id="field-bukti">
                                        <div class="invalid-feedback" id="error-bukti">Invalid feedback</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <x-input-field type="text" id="tgl" name="tgl" label="Tanggal Kirim" required/>
                                    <x-input-field type="number" id="jumlah" name="jumlah" max="{{ $data->training->harga }}" label="Jumlah Bayar" required/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Kirim
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js" integrity="sha512-lteuRD+aUENrZPTXWFRPTBcDDxIGWe5uu0apPEn+3ZKYDwDaEErIK9rvR0QzUGmUQ55KFE2RqGTVoZsKctGMVw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            
            $("#field-tgl").flatpickr({
                altInput: true,
                altFormat: "j F Y",
                dateFormat: "Y-m-d",
                locale : "id",
                defaultDate : new Date(),
                enableTime: false,
                time_24hr: true
            });

            $(document).ready(function() {
                $('#field-jumlah').on('input', function() {
                    var max = $(this).attr('max');
                    if (parseInt($(this).val()) > parseInt(max)) {
                        $(this).val(max);
                    }
                });
            });
        </script>
    @endpush
</x-landing-layout>