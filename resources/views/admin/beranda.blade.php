<x-app-layout>
    <div class="app-content-header"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                </div>
            </div> 
        </div> 
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-primary shadow-sm">
                            <i class="fa fa-receipt"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Pengiriman</span>
                            <span class="info-box-number">
                                {{ $data['pengiriman'] }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-success shadow-sm">
                            <i class="fa fa-truck"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Kendaraan</span>
                            <span class="info-box-number">{{ $data['kendaraan']}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <!-- fix for small devices only -->
                <!-- <div class="clearfix hidden-md-up"></div> -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-warning shadow-sm">
                            <i class="fa fa-user"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Driver</span>
                            <span class="info-box-number">{{ $data['driver'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-danger shadow-sm">
                            <i class="fa fa-cart-shopping"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Pembelian</span>
                            <span class="info-box-number">{{ $data['pembelian'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            
            $(function () {
                $('.datatable').DataTable({
                    processing: true,
                    serverSide: false,
                    dom : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                });
            });
        </script>
    @endpush
</x-app-layout>