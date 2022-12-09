@extends('layouts.app')
@section('content')
<div class="row top_tiles">
	<div class="animated flipInY col-lg-12 col-md-12 col-sm-6 col-xs-12">
		<div class="tile-stats">
			<div class="icon"><i class="fa fa-heartbeat"></i></div>
			<div class="count">{{count($poli)}}</div>
			<h3>Jumlah Poli</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<a class="btn btn-primary btn-flat" role="button" data-toggle="collapse" href="#collapse-tambah" aria-expanded="false" aria-controls="collapse-tambah">
			Tambah Poli <i class="fa fa-plus"></i>
		</a>
		{{-- collapse tambah --}}
		<div class="collapse" id="collapse-tambah">
			<div class="well">
				<form method="post" id="frm-tambah">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label>Nama Poli</label>
							<input type="text" name="NAMA_POLI" class="form-control">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
							<label>Keterangan</label>
							<input type="text" name="KETERANGAN_POLI" class="form-control">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
							<label>Status</label>
							<input type="text" name="STATUS_POLI" class="form-control">
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<button type="submit" class="btn btn-flat btn-primary btn-block">Simpan <i class="fa fa-save"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>
	</div>

	<div class="x_panel">
		<div class="x_title">
			<h2>Data Poli</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<table id="datatable" class="table table-striped table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Poli</th>
						<th>Keterangan</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; ?>
					@foreach ($poli as $data)
					<tr>
						<td>{{$no++}}</td>
						<td>{{$data['NAMA_POLI']}}</td>
						<td>{{$data['KETERANGAN_POLI']}}</td>
						<td>{{$data['STATUS_POLI']}}</td>
						<td>
							<a href="#modal-edit" class="btn btn-flat btn-warning btn-edit" data-toggle="modal" data-id="{{$data['ID_POLI']}}"
								data-nama="{{$data['NAMA_POLI']}}" data-keterangan="{{$data['KETERANGAN_POLI']}}" data-status="{{$data['STATUS_POLI']}}"
							><i class="fa fa-edit"></i></a>
							<a href="#!" class="btn btn-flat btn-danger btn-hapus" data-id="{{$data['ID_POLI']}}"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
{{-- modal edit --}}
<div class="modal fade" id="modal-edit">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Edit Poli</h4>
		</div>
		<div class="modal-body">
			<form method="post" id="frm-edit">
				<div class="form-group">
					<label>Nama Poli</label>
					<input type="text" name="NAMA_POLI" id="NAMA_POLI" class="form-control">
					<input type="hidden" name="id" id="id">
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<input type="text" name="KETERANGAN_POLI" id="KETERANGAN_POLI" class="form-control">
				</div>
				<div class="form-group">
					<label>Status</label>
					<input type="number" name="STATUS_POLI" id="STATUS_POLI" class="form-control">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary btn-simpan" >Simpan <i class="fa fa-save"></i></button>
			</form>
		</div>
	</div>
</div>
</div>
</div>


@endsection
@section('customJs')
<script type="text/javascript">
	$(document).ready(function() {
		
		$('#datatable').on('click','.btn-edit', function(e) {
			e.preventDefault();
			var id = $(this).data('ID_POLI');
			var nama = $(this).data('NAMA_POLI');
			var keterangan = $(this).data('KETERANGAN_POLI');
			var status = $(this).data('STATUS_POLI');
			var form = $('#modal-edit');
			form.find('#ID_POLI').val(id);
			form.find('#NAMA_POLI').val(nama);
			form.find('#KETERANGAN_POLI').val(keterangan);
			form.find('#STATUS_POLI').val(status);
		});

		$('#frm-edit').on('submit', function(e) {
			e.preventDefault();
			var data = $(this).serialize();
			
			$.post("{{route('updatePoli')}}", data, function() {
				console.log(data);
				// console.log(data);
				toastr.success('Success !', 'Data berhasil di update !');
				location.reload();
			});
		});

		$('#datatable').on('click', '.btn-hapus',function(e) {
			var id = $(this).data('id');
			$.confirm({
			icon: 'fa fa-warning',
			title: 'Alert !',
			content: 'Apakah anda ingin menghapus data ini ?',
			type: 'red',
			typeAnimated: true,
			buttons: {
			confirm: function () {
			$.get("{{ route('hapusPoli') }}", {id: id}, function (data) {
			toastr.success('Success !', 'Data berhasil di hapus');
			location.reload();
			});
			},
			cancel: function () {
			
			},
			}
			});
			});
			
		$('#frm-tambah').on('submit', function(e) {
			e.preventDefault();
			var data = $(this).serialize();
			$.post("{{route('postPoli')}}", data, function(data) {
				toastr.success('Success !', 'Data berhasil di simpan !');
				location.reload();
			});
		});
		});
	</script>
	@endsection