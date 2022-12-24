<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Data Pemeriksaan | Pasien : {{ $pembayaran[0]['pasien']['nama'] }}</title>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{URL::to('images/favicon.ico')}}">
    {{-- Select2 --}}
    <link rel="stylesheet" type="text/css" href="{{URL::to('bower_components/select2/dist/css/select2.min.css')}}">
    <!-- Bootstrap -->
    <link href="{{ URL::to('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::to('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    </head>
    {{-- <style type="text/css" media="print">
          @page { size: landscape; }
    </style> --}}
    <body onload="window.print()">
    <div class="page-header">
      <h1>Data Pemeriksaan | <small>Pasien : {{ $pembayaran[0]['pasien']['nama'] }}</small></h1>
    </div>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
       
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; ?>
        @foreach($pembayaran as $data)
        <h4>Nama Lengkap Pasien : {{ $data['pasien']['nama'] }}</h4>
        <h4>Dokter : {{ $data['dokter']['nama'] }}</h4>
        <h4>Obat : {{ $data['obat']['nama'] }}</h4>
        <h4>Jumlah : {{ $data['jumlah'] }}</h4>
        <h4>Keterangan : {{ $data['keterangan'] }}</h4>
        <h4>Biaya Pemeriksaan : Rp.{{ $data['biaya_pemeriksaan'] }}</h4>
        @endforeach
    </tbody>
  </table>
  </body>
  </html>