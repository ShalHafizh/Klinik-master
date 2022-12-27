@extends('layouts.app')
@section('content')
<style>
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
      /* display: none; <- Crashes Chrome on hover */
      -webkit-appearance: none;
      margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
  }

  input[type=number] {
      -moz-appearance:textfield; /* Firefox */
  }

  .required:after {
    content:" *";
    color: #e32;
  }

  textarea {
    resize: none;
  }

  table {
    width: 100%
  }

  td {
    white-space: nowrap;
  }

  .td-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    max-width: 0;
  }

  .needs-validation{
    border: 1px solid #e32;
  }
  .with-validation{
    border: 1px solid #0e2;
  }
</style>
<div class="row top_tiles">
  <div class="animated flipInY col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="tile-stats">
      <div class="icon"><i class="fa fa-list-alt"></i></div>
      <div class="count">{{count($rekamMedis)}}</div>
      <h3>Total Rekam Medis</h3>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <a class="btn btn-primary btn-flat" role="button" data-toggle="collapse" href="#collapse-tambah" aria-expanded="false" aria-controls="collapse-tambah" style="margin-bottom: 15px">
			Tambah Rekam Medis <i class="fa fa-plus"></i>
		</a>
    {{-- collapse tambah --}}
		<div class="collapse" id="collapse-tambah">
			<div class="well">
				<form method="post" id="frm-tambah">
          <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11" style="width: 100%">
            <div class="form-group">
              <label class="required">ID Pasien</label>
              <div class="input-group">
                <input type="text" name="pasien_id" class="form-control" id="pasien_id" oninput="this.value = this.value.toUpperCase()" required>
                <div class="input-group-addon" id="search_id"><i class="fa fa-search text-white"></i></div>
              </div>
              <span id="error_id_pasien"></span>
            </div>
          </div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label>Nama Pasien</label>
							<input type="text" name="nama" class="form-control" id="nama" disabled>
						</div>
					</div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="form-group">
							<label>Tanggal Lahir</label>
							<input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" disabled>
						</div>
					</div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label class="required" style="display: block">Dokter</label>
              <select class="form-control" name="dokter_id" id="dokter_id"  style="width:100%;" required>
                <option value="">Pilih Dokter...</option>
                @foreach($dokter as $d)
                  <option value="{{$d['id']}}">{{$d['id']}} - {{$d['nama']}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label class="required">Berat Badan</label>
              <div class="input-group">
                <input type="number" class="form-control" name="bb" id="bb" required>
                <div class="input-group-addon">Kg</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label class="required">Tensi Darah</label>
              <div class="input-group">
                <input type="number" class="form-control" name="tensi" id="tensi" required>
                <div class="input-group-addon">mmHg</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label class="required">Tinggi Badan</label>
              <div class="input-group">
                <input type="number" class="form-control" name="tb" id="tb" required>
                <div class="input-group-addon">Cm</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label class="required">Buta Warna</label>
              <div class="radio">
                <label >
                  <input type="radio" name="bw" value="ya" id="bw" required>
                  Ya
                </label>
                <label style="margin-left: 15px">
                  <input type="radio" name="bw" value="tidak" id="bw" required>
                  Tidak
                </label>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label class="required">Keluhan</label>
              <input type="text" name="keluhan" class="form-control required" id="keluhan" placeholder="beri tanda (-) jika tidak ada keluhan" required>
            </div>
            <div class="form-group">
              <label class="required">Anamnesis</label>
              <textarea class="form-control required" id="anamnesis" name="anamnesis" rows="3" required placeholder="beri tanda (-) jika tidak ada ananesis"></textarea>
            </div>
            <div class="form-group">
              <label class="required">Diagnosa</label>
              <input type="text" name="diagnosa required" class="form-control" id="diagnosa" required placeholder="beri tanda (-) jika tidak ada diagnosa">
            </div>
            <div class="form-group">
              <label class="required">Tindakan</label>
              <input type="text" name="tindakan required" class="form-control" id="tindakan" required placeholder="beri tanda (-) jika tidak ada tindakan">
            </div>
            <div class="form-group">
              <label class="required">Alergi Obat</label>
              <textarea class="form-control required" id="alergi_obat" name="alergi_obat" required rows="3" placeholder="beri tanda (-) jika tidak ada alergi"></textarea>
            </div>
            <div class="form-group">
              <label class="required">Keterangan</label>
              <textarea class="form-control required" id="keterangan" name="keterangan" placeholder="beri tanda (-) jika tidak ada keterangan" required rows="3"></textarea>
            </div>
          </div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<button type="submit" class="btn btn-flat btn-primary btn-block" id="tambah" disabled>Simpan <i class="fa fa-save"></i></button>
					</div>
				</div>
		</div>
				</div>
		</div>
    <div class="x_panel">
      <div class="x_title">
        <h2>Data Rekam Medis</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table id="datatable" class="table table-striped" style="display: block;overflow-x: auto;white-space: nowrap;">
          <thead>
            <tr>
              <th>No.</th>
              <th>ID</th>
              <th>Nama Pasien</th>
              <th>Tanggal Lahir</th>
              <th>Nama Dokter</th>
              <th>Buta Warna</th>
              <th>Diagnosa</th>
              <th>Keluhan</th>
              <th class="truncate">Anamnesis</th>
              <th>Alergi Obat</th>
              <th>Keterangan</th>
              <th>Tanggal Periksa</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $no = 1; ?>
          @foreach($rekamMedis as $data)
            <tr>
              <td>{{$no++}}</td>
              <td>{{$data['pasien_id']}}</td>
              <td>{{$data['nama']}}</td>
              <td>{{$data['tgl_lahir']}}</td>
              <td>{{ $data['nama_dokter']}}</td>
              <td>@if ($data['bw'] == 'ya')
                    <span class="label label-success">Ya</span>
                  @else
                    <span class="label label-danger">Tidak</span>
              @endif</td>
              <td class="td-truncate">{{$data['diagnosa']}}</td>
              <td class="td-truncate">{{$data['keluhan']}}</td>
              <td class="td-truncate">{{$data['anamnesis']}}</td>
              <td class="td-truncate">{{$data['alergi_obat']}}</td>
              <td class="td-truncate">{{$data['keterangan']}}</td>
              <td>{{date('d-m-Y', strtotime($data['created_at']))}}</td>
              <td>
                <a href="#modal-detail" class="btn btn-info btn-flat btn-detail" data-toggle="modal"
                data-dtl_id="{{$data['id']}}" data-dtl_bb="{{$data['bb']}}" data-dtl_tb="{{$data['tb']}}" data-dtl_tensi="{{$data['tensi']}}" data-dtl_bw="{{$data['bw']}}" data-dtl_keluhan="{{$data['keluhan']}}" data-dtl_anamnesis="{{$data['anamnesis']}}" data-dtl_diagnosa="{{$data['diagnosa']}}" data-dtl_tindakan="{{$data['tindakan']}}" data-dtl_keterangan="{{$data['keterangan']}}" data-dtl_alergi_obat="{{$data['alergi_obat']}}" data-dtl_nama="{{ $data['nama'] }}" data-dtl_tgl_lahir="{{ $data['tgl_lahir'] }}" data-dtl_pasien_id="{{ $data['pasien_id'] }}" data-dtl_dokter="{{ $data['nama_dokter'] }}"
                ><i class="fa fa-search"></i></a>
                <a href="#modal-edit" data-toggle="modal" class="btn btn-warning btn-flat btn-edit" data-id="{{$data['id']}}" data-bb="{{$data['bb']}}" data-tb="{{$data['tb']}}" data-tensi="{{$data['tensi']}}" data-bw="{{$data['bw']}}" data-keluhan="{{$data['keluhan']}}" data-anamnesis="{{$data['anamnesis']}}" data-diagnosa="{{$data['diagnosa']}}" data-tindakan="{{$data['tindakan']}}" data-keterangan="{{$data['keterangan']}}" data-alergi_obat="{{$data['alergi_obat']}}" data-nama="{{ $data['nama'] }}" data-tgl_lahir="{{ $data['tgl_lahir'] }}" data-pasien_id="{{ $data['pasien_id'] }}" data-dokter="{{ $data['dokter_id'] }}"
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
</div>
{{-- Modal Detail --}}
<div class="modal fade" id="modal-detail">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Detail Data</h4>
      </div>
      <div class="modal-body">
        <form id="frm-detail">
        <input type="hidden" name="id" id="id">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label>ID Pasien</label>
              <input type="text" name="dtl_pasien_id" class="form-control" id="dtl_pasien_id" disabled>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
              <label>Nama Pasien</label>
              <input type="text" name="dtl_nama" class="form-control" id="dtl_nama" disabled>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
              <label>Tanggal Lahir</label>
              <input type="date" name="dtl_tgl_lahir" class="form-control" id="dtl_tgl_lahir" disabled>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label>Nama Dokter</label>
              <input type="text" name="dtl_dokter" class="form-control" id="dtl_dokter" disabled>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label>Berat Badan</label>
              <div class="input-group">
                <input type="text" class="form-control" name="dtl_bb" id="dtl_bb" disabled>
                <div class="input-group-addon">Kg</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label>Tensi Darah</label>
              <div class="input-group">
                <input type="text" class="form-control" name="dtl_tensi" id="dtl_tensi" disabled>
                <div class="input-group-addon">mmHg</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label>Tinggi Badan</label>
              <div class="input-group">
                <input type="text" class="form-control" name="dtl_tb" id="dtl_tb" disabled>
                <div class="input-group-addon">Cm</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label>Buta Warna</label>
              <div class="radio">
                <label style="margin-left: 10px;">
                  <input type="radio" name="dtl_bw" value="ya" id="dtl_bw_ya" disabled>
                  Ya
                </label>
                <label>
                  <input type="radio" name="dtl_bw" value="tidak" id="dtl_bw_tidak" disabled>
                  Tidak
                </label>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label>Keluhan</label>
              <input type="text" name="dtl_keluhan" class="form-control" id="dtl_keluhan" disabled>
            </div>
            <div class="form-group">
              <label>Anamnesis</label>
              <textarea class="form-control" id="dtl_anamnesis" name="dtl_anamnesis" rows="3" disabled></textarea>
            </div>
            <div class="form-group">
              <label>Diagnosa</label>
              <input type="text" name="dtl_diagnosa" class="form-control" id="dtl_diagnosa" disabled>
            </div>
            <div class="form-group">
              <label>Tindakan</label>
              <input type="text" name="dtl_tindakan" class="form-control" id="dtl_tindakan" disabled>
            </div>
            <div class="form-group">
              <label>Alergi Obat</label>
              <textarea class="form-control" id="dtl_alergi_obat" name="dtl_alergi_obat" rows="3" disabled></textarea>
            </div>
          </div>
            <div class="form-group">
              <label>Keterangan</label>
              <textarea class="form-control" id="dtl_keterangan" name="dtl_keterangan" rows="3" disabled></textarea>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </form>
        </div>
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
        <h4 class="modal-title">Edit Data</h4>
      </div>
      <div class="modal-body">
        <form method="post" id="frm-edit">
          <input type="hidden" name="id" id="edit_id">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label class="required">ID Pasien</label>
              <div class="input-group">
                <input type="text" name="pasien_id" class="form-control" id="edit_pasien_id" oninput="this.value = this.value.toUpperCase()" required>
                <div class="input-group-addon" id="search_id"><i class="fa fa-search text-white"></i></div>
              </div>
              <span id="error_edit_id_pasien"></span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
              <label class="required">Nama Pasien</label>
              <input type="text" name="nama" class="form-control" id="edit_nama" disabled required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
              <label class="required">Tanggal Lahir</label>
              <input type="date" name="tgl_lahir" class="form-control" id="edit_tgl_lahir" disabled required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label class="required" style="display: block">Dokter</label>
              <select class="form-control" name="edit_dokter_id" id="edit_dokter_id"  style="width:100%;" required>
                <option value="">Pilih Dokter...</option>
                @foreach($dokter as $d)
                  <option value="{{$d['id']}}">{{$d['nama']}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label class="required">Berat Badan</label>
              <div class="input-group">
                <input type="text" class="form-control" name="bb" id="edit_bb" required>
                <div class="input-group-addon">Kg</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label class="required">Tensi Darah</label>
              <div class="input-group">
                <input type="text" class="form-control" name="tensi" id="edit_tensi" required>
                <div class="input-group-addon">mmHg</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label class="required">Tinggi Badan</label>
              <div class="input-group">
                <input type="text" class="form-control" name="tb" id="edit_tb" required>
                <div class="input-group-addon">Cm</div>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
              <label class="required">Buta Warna</label>
              <div class="radio">
                <label style="margin-left: 10px;">
                  <input type="radio" name="edit_bw" value="ya" id="ya" required>
                  Ya
                </label>
                <label>
                  <input type="radio" name="edit_bw" value="tidak" id="tidak" required>
                  Tidak
                </label>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label class="required">Keluhan</label>
              <input type="text" name="keluhan" class="form-control" id="edit_keluhan" required>
            </div>
            <div class="form-group">
              <label class="required">Anamnesis</label>
              <textarea class="form-control" id="edit_anamnesis" name="anamnesis" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label class="required">Diagnosa</label>
              <input type="text" name="diagnosa" class="form-control" id="edit_diagnosa" required>
            </div>
            <div class="form-group">
              <label class="required">Tindakan</label>
              <input type="text" name="tindakan" class="form-control" id="edit_tindakan" required>
            </div>
            <div class="form-group">
              <label class="required">Alergi Obat</label>
              <textarea class="form-control" id="edit_alergi_obat" name="edit_alergi_obat" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label class="required">Keterangan</label>
              <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3" required></textarea>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="edit">Simpan <i class="fa fa-save"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('customJs')
  <script type="text/javascript">
    $(document).ready(function() {
      $("select").select2();
      $('#pasien_id').on('keyup blur', function(event) {
        var data = {
          id: $(this).val()
        };
        $.post("{{route('getDetailPasien')}}", data, function(data) {
          if(data.status == "Failed"){
            $('#nama').val('Pasien Tidak Ditemukan');
            $('#tgl_lahir').val("");
            $('#error_id_pasien').html('<label class="text-danger"><i class="fa fa-close text-danger"></i>&nbsp;ID Pasien tidak terdaftar</label>');
            $('#pasien_id').removeClass('with-validation');
            $('#pasien_id').addClass('needs-validation');
            $('#tambah').attr('disabled', 'disabled');
            return;
          }         
          $('#nama').val(data.nama);
          $('#tgl_lahir').val(data.tgl_lahir);
          if ($('#nama').val() == "" || $('#tgl_lahir').val() == "") {
            $('#tambah').attr('disabled', 'disabled');
            $('#error_id_pasien').html('<label class="text-warning"><i class="fa fa-warning text-warning"></i>&nbsp;Data Pasien Tidak Lengkap, Silahkan Isi Data Pasien Terlebih Dahulu</label>');
            $('#pasien_id').removeClass('with-validation');
            $('#pasien_id').addClass('needs-validation');
          } else {
            $('#error_id_pasien').html('<label class="text-success"><i class="fa fa-check text-success"></i>&nbsp;ID Pasien terdaftar</label>');
            $('#pasien_id').removeClass('needs-validation');
            $('#pasien_id').addClass('with-validation');
            $('#tambah').removeAttr('disabled');
          }
        });
      });
      $('#edit_pasien_id').on('keyup blur' ,function(event) {
        var data = {
          id: $(this).val()
        };
        $.post("{{route('getDetailPasien')}}", data, function(data) {
          if(data.status == "Failed"){
            $('#edit_nama').val('Pasien Tidak Ditemukan');
            $('#edit_tgl_lahir').val("");
            $('#error_edit_id_pasien').html('<label class="text-danger"><i class="fa fa-close text-danger"></i>&nbsp;ID Pasien tidak terdaftar</label>');
            $('#edit_pasien_id').removeClass('with-validation');
            $('#edit_pasien_id').addClass('needs-validation');
            $('#edit').attr('disabled', 'disabled');
            return;
          }         
          $('#edit_nama').val(data.nama);
          $('#edit_tgl_lahir').val(data.tgl_lahir);
          if ($('#edit_nama').val() == "" || $('#edit_tgl_lahir').val() == "") {
            $('#edit').attr('disabled', 'disabled');
            $('#error_edit_id_pasien').html('<label class="text-warning"><i class="fa fa-warning text-warning"></i>&nbsp;Data Pasien Tidak Lengkap, Silahkan Isi Data Pasien Terlebih Dahulu</label>');
            $('#edit_pasien_id').removeClass('with-validation');
            $('#edit_pasien_id').addClass('needs-validation');
          } else {
            $('#error_edit_id_pasien').html('<label class="text-success"><i class="fa fa-check text-success"></i>&nbsp;ID Pasien terdaftar</label>');
            $('#edit_pasien_id').removeClass('needs-validation');
            $('#edit_pasien_id').addClass('with-validation');
            $('#edit').removeAttr('disabled');
          }
        });
      });
      $('#datatable').on('click', '.btn-edit', function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var pasien_id = $(this).data('pasien_id');
        var nama = $(this).data('nama');
        var tgl_lahir = $(this).data('tgl_lahir');
        var bb = $(this).data('bb');
        var tensi = $(this).data('tensi');
        var tb = $(this).data('tb');
        var bw = $(this).data('bw');
        var keluhan = $(this).data('keluhan');
        var anamnesis = $(this).data('anamnesis');
        var diagnosa = $(this).data('diagnosa');
        var tindakan = $(this).data('tindakan');
        var keterangan = $(this).data('keterangan');
        var alergi_obat = $(this).data('alergi_obat');
        var dokter = $(this).data('dokter');
        var form = $('#frm-edit');
        if (bw == 'ya') {
            form.find('#ya').val(bw).prop('checked', true);     
        }else{
            form.find('#tidak').val(bw).prop('checked', true);
        }
        form.find('#edit_id').val(id);
        form.find('#edit_pasien_id').val(pasien_id);
        form.find('#edit_nama').val(nama);
        form.find('#edit_tgl_lahir').val(tgl_lahir);
        form.find('#edit_bb').val(bb);
        form.find('#edit_tb').val(tb);
        form.find('#edit_tensi').val(tensi);
        form.find('#edit_keluhan').val(keluhan);
        form.find('#edit_anamnesis').val(anamnesis);
        form.find('#edit_diagnosa').val(diagnosa);
        form.find('#edit_tindakan').val(tindakan);
        form.find('#edit_keterangan').val(keterangan);
        form.find('#edit_alergi_obat').val(alergi_obat);
        form.find('#edit_dokter_id').val(dokter).prop('selected', true);
      });

        $('#datatable').on('click','.btn-detail',  function(event) {
        event.preventDefault();
        var dtl_pasien_id = $(this).data('dtl_pasien_id');
        var dtl_nama = $(this).data('dtl_nama');
        var dtl_tgl_lahir = $(this).data('dtl_tgl_lahir');
        var dtl_bb = $(this).data('dtl_bb');
        var dtl_tensi = $(this).data('dtl_tensi');
        var dtl_tb = $(this).data('dtl_tb');
        var dtl_bw = $(this).data('dtl_bw');
        var dtl_keluhan = $(this).data('dtl_keluhan');
        var dtl_anamnesis = $(this).data('dtl_anamnesis');
        var dtl_diagnosa = $(this).data('dtl_diagnosa');
        var dtl_tindakan = $(this).data('dtl_tindakan');
        var dtl_keterangan = $(this).data('dtl_keterangan');
        var dtl_alergi_obat = $(this).data('dtl_alergi_obat');
        var dtl_dokter = $(this).data('dtl_dokter');
        if (bw == 'ya') {
            $('#dtl_bw_ya').val(dtl_bw).prop('checked', true);     
        }else{
            $('#dtl_bw_tidak').val(dtl_bw).prop('checked', true);
        }

        $('#dtl_pasien_id').val(dtl_pasien_id);
        $('#dtl_nama').val(dtl_nama);
        $('#dtl_tgl_lahir').val(dtl_tgl_lahir);
        $('#dtl_bb').val(dtl_bb);
        $('#dtl_tb').val(dtl_tb);
        $('#dtl_tensi').val(dtl_tensi);
        $('#dtl_keluhan').val(dtl_keluhan);
        $('#dtl_anamnesis').val(dtl_anamnesis);
        $('#dtl_diagnosa').val(dtl_diagnosa);
        $('#dtl_tindakan').val(dtl_tindakan);
        $('#dtl_keterangan').val(dtl_keterangan);
        $('#dtl_alergi_obat').val(dtl_alergi_obat);
        $('#dtl_dokter').val(dtl_dokter);
      });

      $('#frm-edit').on('submit', function(e) {
        e.preventDefault();
        var data = [
          {
            "name": "id",
            "value": $('#edit_id').val()
          },
          {
            "name": "pasien_id",
            "value": $('#edit_pasien_id').val()
          },
          {
            "name": "dokter_id",
            "value": $('#edit_dokter_id').val()
          },
          {
            "name": "nama",
            "value": $('#edit_nama').val()
          },
          {
            "name": "tgl_lahir",
            "value": $('#edit_tgl_lahir').val()
          },
          {
            "name": "bb",
            "value": $('#edit_bb').val()
          },
          {
            "name": "tb",
            "value": $('#edit_tb').val()
          },
          {
            "name": "tensi",
            "value": $('#edit_tensi').val()
          },
          {
            "name": "keluhan",
            "value": $('#edit_keluhan').val()
          },
          {
            "name": "anamnesis",
            "value": $('#edit_anamnesis').val()
          },
          {
            "name": "diagnosa",
            "value": $('#edit_diagnosa').val()
          },
          {
            "name": "tindakan",
            "value": $('#edit_tindakan').val()
          },
          {
            "name": "keterangan",
            "value": $('#edit_keterangan').val()
          },
          {
            "name": "bw",
            "value": $('input[name=edit_bw]:checked').val()
          },
          {
            "name": "alergi_obat",
            "value": $('#edit_alergi_obat').val()
          }
        ]
        $.post("{{route('postUpdateRekamMedis')}}", data, function(data) {
          console.log(data);
          if (data.status == 'Success'){
            toastr.success('Success !', 'Data berhasil di simpan !');
            $('#modal-edit').modal('hide');
            location.reload();
          }else{
            toastr.error('Error !', 'Data gagal di simpan !');
          }
        });
      });

      $('#frm-tambah').on('submit', function(e) {
			e.preventDefault();
			var data = [
        {
          "name": "pasien_id",
          "value": $('#pasien_id').val()
        },
        {
          "name": "nama",
          "value": $('#nama').val()
        },
        {
          "name": "dokter_id",
          "value": $('#dokter_id').val()
        },
        {
          "name" : "tgl_lahir",
          "value" : $('#tgl_lahir').val()
        },
        {
          "name": "bb",
          "value": $('#bb').val()
        },
        {
          "name": "tensi",
          "value": $('#tensi').val()
        },
        {
          "name": "tb",
          "value": $('#tb').val()
        },
        {
          "name": "bw",
          "value": $('input[name=bw]:checked').val()
        },
        {
          "name": "keluhan",
          "value": $('#keluhan').val()
        },
        {
          "name": "anamnesis",
          "value": $('#anamnesis').val()
        },
        {
          "name": "diagnosa",
          "value": $('#diagnosa').val()
        },
        {
          "name": "tindakan",
          "value": $('#tindakan').val()
        },
        {
          "name" : "alergi_obat",
          "value" : $('#alergi_obat').val()
        },
        {
          "name": "keterangan",
          "value": $('#keterangan').val()
        }
      ]
      // console.log(data);
			$.post("{{route('postTambahRekamMedis')}}", data, function(data) {
        // console.log(data);
        if (data.status == 'Success'){
          toastr.success('Success !', 'Data berhasil di simpan !');
          $('#modal-tambah').modal('hide');
          location.reload();
        }else{
          toastr.error('Error !', 'Data gagal di simpan !');
        }
			});
		});

      $('#datatable').on('click','.btn-delete', function(event) {
        event.preventDefault();
        var id = $(this).data('id');
              $.confirm({
                  icon: 'fa fa-warning',
                  title: 'Alert !',
                  content: 'Apakah anda ingin menghapus data ini ?',
                  type: 'red',
                  typeAnimated: true,
                  buttons: {
                  confirm: function () {
                        $.get("{{ route('getDeleteRekamMedis') }}", {id:id}, function(data) {
                          if (data.status == 'Success'){
                            toastr.success('Success !', 'Data berhasil di hapus');
                            location.reload();
                          } else {
                            toastr.error('Error !', 'Data gagal di hapus');
                          }
                        });
                  
                  },
                  cancel: function () {
                  },
                  }
              });
      });
    });
  </script>
@endsection