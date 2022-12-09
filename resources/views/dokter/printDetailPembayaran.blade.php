<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cetak Pembayaran</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  {{-- <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet"> --}}
  <style type="text/css">
    body {
            background: #fff;
            background-image: none;
            padding: 0;
            margin: 0;
        }
        table {
	    border-collapse: collapse;
	    width: 100%;
	    border: 1px solid;
	}
	th {
	    background-color: #7C7C7C;
	    color: white;
	}

	th, td {
	    text-align: left;
	    padding: 8px;
	}

	tr:nth-child(even){background-color: #f2f2f2}
        ul li {
        	list-style: none;
        }
        #catatan{
        	border: 1 solid;
        	padding: 2px;
        	text-align: center;
        	border-radius: 10px;
        }
        #footer {
        	text-align: center;
        	margin-top: 5px;
        	/*font-family: 'Pacifico', cursive;*/
        }
  </style>
<body>
        <div style="text-align: center;">
          <h1>
            <u>dr. {{ $pembayaran[0]['dokter']['nama'] }}</u>
            </h1>
       </div>
       <div>
       	<span style="text-align: left;">Nama Pasien: <strong>{{$pembayaran[0]['pasien']['nama']}}</strong></span><br>
       	<span style="text-align: left;">Alamat: <strong>{{$pembayaran[0]['pasien']['alamat']}}</strong></span>
       </div>
       <h4 align="center">Isi Pembayaran</h4>
    	<table border="1">
    		<thead>
    			<tr>
    				<th>No.</th>
	    			<th>Nama Obat</th>
	    			<th>Signa</th>
	    			<th>Jumlah</th>
					<th>Biaya</th>
    			</tr>
    		</thead>
    		<tbody>
    		<?php $no = 1; ?>
    			@foreach ($pembayaran as $data)
    				<tr>
    					<td width="10%" style="text-align: center;">{{$no++}}.</td>
    					<td width="40%">{{$data['obat']['nama']}}</td>
    					<td width="12%" style="text-align: center;">{{$data['keterangan']}}</td>
    					<td width="12%" style="text-align: center;">{{$data['jumlah']}}</td>
						<td width="12%" style="text-align: center;">{{$data['biaya_pemeriksaan']}}</td>
    				</tr>
    			@endforeach
    		</tbody>
    	</table>
    	<br>
    	<div id="catatan">
    		<p><strong>Obat tersebut tidak boleh diganti tanpa persetujuan dokter</strong></p>
    	</div>
    	<div id="footer">
    		Semoga Lekas Sembuh
    	</div>
</body>
</html>
