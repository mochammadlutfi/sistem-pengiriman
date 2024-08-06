<html>

<head>
    <title>Pengiriman {{ request()->get('tgl') }}</title>

    <link rel="stylesheet" href="/css/bootstrap.css">
</head>

<body>
    <div class="container">
        <table width="100%">
            <tr>
                <td width="20%" class="text-center">
                    <img src="/images/logo.png" width="140pt">
                </td>
                <td width="80%">
                    <h1 style="margin-bottom: 5px;font-size:28pt;font-weight: bold;">PT ARWINDO GHANI UTAMA</h1>
                    <h1 style="text-align:left;margin-bottom: 5px;font-size:16pt;font-weight: bold;">TRANSPORTATION</h1>
                    <p style="margin-bottom:0;">Jl Werkudoro No 9 Bima Indah Estate - Cirebon 45123 Phone : (0231)487544<br/>Email : arwindoghaniutama@gmail.com</p>
                </td>
            </tr>
        </table>
        <hr/>
        <h2 class="h3 text-center" style="font-weight: bold; margin-top:0px">LAPORAN PENGIRIMAN</h2>
        <h2 class="h4 text-center" style="font-weight: bold; margin-top:0px">
            Periode : {{ \Carbon\Carbon::parse($tgl[0])->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($tgl[1])->translatedFormat('d F Y') }}
        </h2>
        <br/>
        <br/>
        <br/>
        
        <table class="table table-bordered datatable w-100">
            <thead>
                <tr>
                    <th width="60px">#</th>
                    <th>Nomor</th>
                    <th>Pelanggan</th>
                    <th>Tujuan</th>
                    <th>Surat Jalan</th>
                    <th>Kendaraan</th>
                    <th>Driver</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $d->nomor }}</td>
                    <td>{{ $d->pelanggan->nama }}</td>
                    <td>{{ $d->tujuan }}</td>
                    <td>{{ $d->surat_jalan }}</td>
                    <td>{{ $d->kendaraan->no_polisi }}</td>
                    <td>{{ $d->driver->nama }}</td>
                    <td>{{ $d->status }}</td>
                </tr>                                        
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>