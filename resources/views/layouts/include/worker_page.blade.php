@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">Dashboard - Users</div>

        <div class="card-body">
          <button type="button" class="btn btn-default btn-big" name="button">Skeniraj QR kodo</button>
          <video id="preview"></video>

        </div>
      </div>
    </div>


  </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js">
</script>
<script src="https://github.com/schmich/instascan/releases/download/1.0.0/instascan.min.js"></script>

@yield('script')


<script type="text/javascript">
$(function() {
  function openQRCamera(node) {
  var reader = new FileReader();
  reader.onload = function() {
    node.value = "";
    qrcode.callback = function(res) {
      if(res instanceof Error) {
        alert("No QR code found. Please make sure the QR code is within the camera's frame and try again.");
      } else {
        node.parentNode.previousElementSibling.value = res;
      }
    };
    qrcode.decode(reader.result);
  };
  reader.readAsDataURL(node.files[0]);
}

function showQRIntro() {
  return confirm("Use your camera to take a picture of a QR code.");
}
});
  let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
  scanner.addListener('scan', function (content) {
    console.log(content);
  });
  Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
      scanner.start(cameras[0]);
    } else {
      console.error('No cameras found.');
    }
  }).catch(function (e) {
    console.error(e);
  });
</script>

@endsection
