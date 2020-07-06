<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
            section {
                max-width: auto;
                margin: 0 auto;
            }

            body{
                font-family: "Calibri", Helvetica, Arial, sans-serif;
            }

            table.footer{
                width: 100%;
                background-color: none;
            }
            table.footer tr{
                border:none;
            }
            table.footer td.spasi{
                width: 70%;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-family: "Calibri", Helvetica, Arial, sans-serif;
                background-color: none;
            }

            .table--striped tr:nth-of-type(odd) {
                background-color: #F9F9F9;
            }

            .table--bordered tr {
                border-bottom: 1px solid black;
            }

            th {
                border-top: 1px solid black;
                font-weight: bold;
                font-size: 11px;
                border-bottom: 1px solid black;
                text-align: center;
                color: black;
            }

            td {
                font-size: 10px;
                padding: 2px;
                text-align: center;
                text-overflow: ellipsis;
                color: black;
                line-height: 1.5em;
                border-top: 1px solid black;
            }

            tbody tr:first-child {
                border-top: 0;
            }

            @page {
                footer: page-footer;
            }

    </style>
</head>
<body>
    <center>
        <h2 style="text-align: center;">Rekap Data Pasien Covid-19 Kecamatan {{$nama_kecamatan}}</h2>
        <h3 style="margin-top: -1%; text-align: center;">{{date('Y')}}</h3>
    </center>

    <section style="margin-top: 2%;">
      <div class="table-responsive">
        <table class="table--hover" style="text-align: center; justify-content: center;">
          <thead>
          <tr>
            <th>No. </th>
            <th>No. Telp</th>
            <th>Nama</th>
            <th>Usia</th>
            <th>Jenis Kelamin</th>
            <th>Kasus</th>
            <th>Isolasi</th>
            <th>Status</th>
            <th>Alamat</th>
          </tr>
          <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
          </tr>
          </thead>
          <tbody>
            @php $x=1 @endphp
          @foreach($pasien as $ps)
              <tr>
                <td>{{$x++}}</td>
                <td>{{ $ps->nik }}</td>
                <td>{!! $ps->nama !!}</td>
                <td>{{ $ps->usia }} th</td>
                <td>{{ $ps->jenis_kelamin == 0 ? 'Laki-Laki' : 'Perempuan' }}</td>
                <td>{{ $ps->jenis_kasus->nama }}</td>
                <td>{{ $ps->jenis_isolasi == 0 ? 'Mandiri' : $ps->jenis_isolasi == 2 ? 'Delta Maya' : $ps->jenis_isolasi == 3 ? 'Lingkar Timur' : 'Rumah Sakit' }}</td>
                <td>{{ $ps->status }}</td>
                <td>{{ $ps->alamat_sekarang }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
        <br>
        

        <htmlpagefooter name="page-footer">
            <table class="footer">
                <tr>
                    <td style="text-align:left;">
                        Rekap Data Pasien Covid-19 Kecamatan {{$nama_kecamatan}} {{date('Y/m/d')}}
                    </td>
                    <td style="text-align: right;">
                        Halaman {PAGENO} / {nbpg}
                    </td>
                </tr>
            </table>
        </htmlpagefooter>
        </section>


</body>
</html>
