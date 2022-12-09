@extends('layouts.app')
@section('content')
<div class="row">
  <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="tile-stats">
      <div class="icon"><i class="fa fa-clipboard"></i></div>
      <div class="count">{{ count($obat) }}</div>
      <h3>Jumlah Obat</h3>
    </div>
  </div>
  <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="tile-stats">
      <div class="icon"><i class="fa fa-clipboard"></i></div>
      <div class="count">{{ count($kategori) }}</div>
      <h3>Jumlah Kategori</h3>
    </div>
  </div>
</div>
@endsection