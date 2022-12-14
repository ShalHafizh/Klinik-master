@extends('layouts.app')

@section('content')
	<div class="row top_tiles">
              <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-user"></i></div>
                  <div class="count">{{ count($loket) }}</div>
                  <h3>Jumlah Loket</h3>
                </div>
              </div>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapse-tambah" aria-expanded="false" aria-controls="collapseExample">
		  <i class="fa fa-plus"></i> Tambah Data Loket
		</a>
		<div class="collapse" id="collapse-tambah">
		  <div class="well">
		    	<div class="x_panel">
		    		<div class="x_title">
		    			<h2>Tambah Data Loket</h2>
		    			<div class="clearfix"></div>
		    		</div>
		    		<div class="x_content">
		    			<form action="{{ route('postAdminLoket') }}" method="post" id="frm-loket" enctype="multipart/form-data">
								{{ csrf_field() }}
		    			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
		    				<div class="col-lg-12">
		    					<div class="form-group">
			    					<label>ID</label>
			    					<input type="text" name="id" class="form-control" value="{{ $id }}" readonly="">
			    					<input type="hidden" name="level"  value="loket">

			    				</div>
		    				</div>
		    				<div class="col-lg-6">
		    					<div class="form-group">
			    					<label>Username</label>
			    					<input type="text" name="username" class="form-control" required="">
			    				</div>
		    				</div>
		    				<div class="col-lg-6">
		    					<div class="form-group">
			    					<label>Password</label>
			    					<input type="password" name="password" class="form-control" required="">
			    				</div>
		    				</div>
		    				<div class="col-lg-6">
		    					<div class="form-group">
			    					<label>Nama</label>
			    					<input type="text" name="nama" class="form-control" required="">
			    				</div>
		    				</div>
		    				<div class="col-lg-6">
		    					<div class="form-group">
			    					<label>Tgl. Lahir</label>
			    					<input type="text" name="tgl_lahir"  class="form-control datepicker">
			    				</div>
		    				</div>
		    				<div class="col-lg-12">
		    					<div class="form-group">
		    						<label>Alamat</label>
		    						<textarea class="form-control" name="alamat" required=""></textarea>
		    					</div>
		    				</div>
		    				</div>

						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Upload Photo</h3>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<img src="{{ URL::to('images/user-apoteker.jpg') }}" class="img-thumbnail" width="200px" height="200px" id="showPhoto">
										<input type="file" name="photo" id="photo" class="form-control">
									</div>
								</div>
							</div>
						</div>

		    				<div class="col-lg-12">
		    					<button type="submit" class="btn btn-primary btn-block btn-flat">Simpan <i class="fa fa-save"></i></button>
		    				</div>
		    			</form>
		    		</div>
		    	</div>
		  </div>
		</div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2> Data Loket</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
              <div class="x_content">
		<table id="myTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>No.</th>
					<th>ID</th>
					<th>Username</th>
					<th>Nama</th>
					<th>Alamat</th>
					<th>Tgl. Lahir</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php $no = 1; ?>
				@foreach($loket as $data)
					<tr>
						<td>{{ $no++ }}</td>
						<td>{{ $data['id'] }}</td>
						<td>{{ $data['username'] }}</td>
						<td>{{ $data['nama'] }}</td>
						<td>{{ $data['alamat'] }}</td>
						<td>{{ date('d-F-Y', strtotime($data['tgl_lahir'])) }}</td>
						<td>
							<a href="#modal-edit" data-toggle="modal" class="btn btn-warning btn-flat btn-edit"
							data-id='{{ $data['id'] }}' data-username='{{ $data['username'] }}' data-nama="{{ $data['nama'] }}" data-alamat={{ $data['alamat'] }} data-tgl_lahir='{{ $data['tgl_lahir'] }}' data-password="{{$data['password']}}"
							><i class="fa fa-edit"></i></a>
							<a href="#!" class="btn btn-danger btn-flat btn-delete" data-id="{{$data['id']}}"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
              </div>
              </div>
              </div>

              {{-- modal edit --}}
              <div class="modal fade" id="modal-edit">
              	<div class="modal-dialog">
              		<div class="modal-content">
              			<div class="modal-header">
              				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              				<h4 class="modal-title">Edit Data</h4>
              			</div>
              			<div class="modal-body">
              				<form action="{{ route('updateAdminLoket') }}" method="post" id="frm-edit">
              				{{ csrf_field() }}
		    				<div class="col-lg-6">
		    					<div class="form-group">
			    					<label>ID</label>
			    					<input type="text" name="id" id="id" class="form-control" value="" readonly="">
			    				</div>
		    				</div>
		    				<div class="col-lg-6">
		    					<div class="form-group">
			    					<label>Upload Photo Terbaru</label>
			    					<input type="file" name="photo" id="photo" class="form-control">
			    				</div>
		    				</div>
		    				<div class="col-lg-6">
		    					<div class="form-group">
			    					<label>Username</label>
			    					<input type="text" name="username" id="username" class="form-control" required="">
			    				</div>
		    				</div>
		    				<div class="col-lg-6">
		    					<div class="form-group">
			    					<label>Password</label>
			    					<input type="password" id="password" name="password" class="form-control"  required="">
			    				</div>
		    				</div>
		    				<div class="col-lg-6">
		    					<div class="form-group">
			    					<label>Nama</label>
			    					<input type="text" name="nama" id="nama" class="form-control" required="">
			    				</div>
		    				</div>
		    				<div class="col-lg-6">
		    					<div class="form-group">
			    					<label>Tgl. Lahir</label>
			    					<input type="text" name="tgl_lahir" id="tgl_lahir" id="datepicker" class="form-control" required="">
			    				</div>
		    				</div>
		    				<div class="col-lg-12">
		    					<div class="form-group">
		    						<label>Alamat</label>
		    						<textarea class="form-control" id="alamat"  required=""name="alamat"></textarea>
		    					</div>
		    				</div>
              			</div>
              			<div class="modal-footer">
              				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              				<button type="submit" class="btn btn-primary">Simpan <i class="fa fa-save"></i></button>
		    			</form>
              			</div>
              		</div>
              	</div>
              </div>
@endsection

@section('customJs')
	<script type="text/javascript">
		$(document).ready(function() {
			function showFile(fileInput, img, showName) {
			if (fileInput.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
				$(img).attr('src', e.target.result);
				}
				reader.readAsDataURL(fileInput.files[0]);
				}
				$('#showPhoto').text(fileInput.files[0].name)
			}
			$('#photo').on('change', function() {
				showFile(this, '#showPhoto');
				});

			$('#frm-loket').on('submit', function() {
					toastr.success('Success !', 'Data berhasil di simpan !');
			});

			$('#myTable').on('click','.btn-edit', function(e) {
				e.preventDefault();
				var id = $(this).data('id');
				var username = $(this).data('username');
				var nama = $(this).data('nama');
				var alamat = $(this).data('alamat');
				var tgl_lahir = $(this).data('tgl_lahir');
				var password = $(this).data('password');
				// console.log(password);
				$('#id').val(id);
				$('#username').val(username);
				$('#nama').val(nama);
				$('#alamat').val(alamat);
				$('#tgl_lahir').val(tgl_lahir);
				$('#password').val(password);
			});

			// $('#frm-edit').on('submit', function(e) {
			// 	e.preventDefault();
			// 	var data = $(this)	.serialize();
			// 	// console.log(data);
			// 	$.post("{{ route('updateAdminLoket') }}", data, function(data) {
			// 		$('#modal-edit').modal('hide');
			// 		toastr.success('Success !', 'Data berhasil di simpan !');
			// 		location.reload();
			// 	});
			// });

			$('#myTable').on('click','.btn-delete', function(e) {
				e.preventDefault();
				var id = $(this).data('id');
				$.confirm({
			                    title: 'Alert !',
			                    content: 'Apakah anda ingin menghapus data ini ?',
			                    buttons: {
			                        confirm: function () {
						$.get("{{route('deleteAdminLoket')}}", {id:id}, function(data) {
                                				toastr.success('Success !', 'Data berhasil di hapus');
                                				location.reload();
						});

			                        },
			                        cancel: function () {
			                            $.alert('Batal!');
			                        },
			                    }
			                });
			});
		});
	</script>
@endsection
