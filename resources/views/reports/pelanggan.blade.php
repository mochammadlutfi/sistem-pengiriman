<html>

<head>
    <title>Data Pelanggan</title>

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
        <h2 class="h3 text-center" style="font-weight: bold; margin-top:0px">DATA PELANGGAN</h2>
        <br/>
        <br/>
        <br/>
        
        <table class="table table-bordered datatable w-100">
            <thead>
                <tr>
                    <th width="60px">No</th>
                    <th>Nama</th>
                    <th>Telp</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->telp }}</td>
                    <td>{{ $d->email }}</td>
                    <td>{{ $d->alamat }}</td>
                    <td>
                        {{ $d->nama_cp }}<br/>
                        {{ $d->hp_cp }}
                    </td>
                </tr>                                        
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>