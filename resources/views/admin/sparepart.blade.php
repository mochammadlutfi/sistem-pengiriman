<x-app-layout>
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Sparepart</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Data Sparepart
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
                            <button type="button" class="btn btn-primary" onclick="create()">
                                <i class="fa fa-plus me-1"></i>
                                Tambah Sparepart
                            </button>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered datatable w-100">
                                <thead>
                                    <tr>
                                        <th width="60px">No</th>
                                        <th>Nama</th>
                                        <th>Stok</th>
                                        <th width="160px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $d->nama }}</td>
                                            <td>{{ $d->stok }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Aksi
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="d-flex dropdown-item justify-between justify-content-between" onclick="ubah({{ json_encode($d) }})">
                                                                Ubah
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="d-flex dropdown-item justify-between justify-content-between" href="#" onclick="hapus({{ $d->id }})">
                                                                Hapus
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal" id="modal-form" aria-labelledby="modal-form" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="myForm" method="POST" onsubmit="return false;" enctype="multipart/form-data">
                    <input type="hidden" id="field-id" value="" />

                    <div class="modal-header">
                        <h5 class="modal-title">Sparepart</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <x-input-field name="nama" id="nama" label="Nama" isAjax />
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
    @push('scripts')
        <script>

            function create(){
                const form = document.getElementById('modal-form');
                $("#modal-form").find('.modal-title').html("Tambah Sparepart");
                var modalForm = bootstrap.Modal.getOrCreateInstance(form);
                modalForm.show();
            }

            function ubah(data){
                $('#field-id').val(data.id);
                $('#field-nama').val(data.nama);
                var el = document.getElementById('modal-form');

                $("#modal-form").find('.modal-title').html("Ubah Sparepart");
                var myModal = bootstrap.Modal.getOrCreateInstance(el);
                myModal.show();
            }
            
        function hapus(id){
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
                                url: "/sparepart/"+ id +"/delete",
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

            
        $("#myForm").on("submit",function (e) {
            e.preventDefault();
            var fomr = $('form#myForm')[0];
            var formData = new FormData(fomr);
            let token   = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', token);

            var id = $("#field-id").val();
            var url = (id != "") ? "/sparepart/"+id+"/update" : "/sparepart/store";

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

