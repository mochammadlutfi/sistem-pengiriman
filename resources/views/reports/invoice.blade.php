<html>

<head>
    <title>Invoice {{ $data->nomor }}</title>

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
        <br/>
        <br/>
        <table width="400px">
            <tr>
                <td width="150px">
                    Kepada Yth
                </td>
                <td style="text-align: left; font-weight:bold;">
                    : {{ $data->pelanggan->nama }}
                </td>
            </tr>
            <tr>
                <td width="150px">
                    Alamat
                </td>
                <td style="text-align: left; font-weight:bold;">
                    : {{ $data->pelanggan->alamat }}
                </td>
            </tr>
            <tr>
                <td>
                    No Invoice
                </td>
                <td style="text-align: left; font-weight:bold;">
                    : {{ $data->nomor }}
                </td>
            </tr>
            <tr>
                <td>
                    Tanggal
                </td>
                <td style="text-align: left; font-weight:bold;">
                   :  {{ \Carbon\Carbon::parse($data->tgl)->translatedFormat('d F Y')}}
                </td>
            </tr>
        </table>
        {{-- <hr/> --}}
        <br/>
        <br/>
        <table class="table v-align-center table-bordered datatable w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No DO</th>
                    <th>Barang</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Fee/Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->detail as $d)
                
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $d->do }}</td>
                    <td>{{ $d->barang }}</td>
                    <td>{{ $d->qty }}</td>
                    <td>{{ $d->satuan }}</td>
                    <td>Rp {{ number_format($d->fee,0,',','.') }}</td>
                    <td>Rp {{ number_format($d->subtotal,0,',','.') }}</td>
                </tr>                    
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right">Total</td>
                    <td>Rp. {{ number_format($data->total,0,',','.') }}</td>
                </tr>
            </tfoot>
        </table>
        <br/>
        <table style="float: left;width: 100%;border-spacing: 0px;">
        </table>
        <br/>
        <br/>
        <br/>
        <table style="float: left;width: 100%;">
            <tr>
                <td width="70%"></td>
                <td style="text-align:center;">
                    <p style="font-size: 11pt;,margin-bottom:2px;">Cirebon, {{ \Carbon\Carbon::today()->translatedFormat('d F Y') }}</p>
                    <br/>
                    PT Arwindo Ghani Utama
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <p style="border-bottom:1px solid black; padding-bottom:4px;">ERWIN KUSTARIN</p>
                    <p>Direktur</p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>