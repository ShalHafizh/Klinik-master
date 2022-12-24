@extends('layouts.app') @section('content')


<hr>

<body>
  <div class="x_panel">
		<div class="x_title">
			<h2>Scan Data Pasien</h2>
			<div class="clearfix"></div>
		</div>
  <div id="reader" width="400px"></div>
  <input type="hidden" name="result" id="result">
  </div>
</body>

<!-- /top tiles -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            // $('#result').val('test');
            function onScanSuccess(decodedText, decodedResult) {
                alert(decodedText);
                $('#result').val(decodedText);
                let id = decodedText;                
                html5QrcodeScanner.clear().then(_ => {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        
                        url: "{{ route('validasi') }}",
                        type: 'POST',            
                        data: {
                            _methode : "POST",
                            _token: CSRF_TOKEN, 
                            qr_code : id
                        },            
                        success: function (response) { 
                            console.log(response);
                            if(response.status == 200){
                                alert('berhasil');
                            }else{
                                alert('gagal');
                            }
                            
                        }
                    });   
                }).catch(error => {
                    alert('something wrong');
                });
                
            }
 
            function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
                // console.warn(`Code scan error = ${error}`);
            }
 
            let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            /* verbose= */ false);
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endsection