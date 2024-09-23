@extends('layouts.app', [
'class' => '',
'elementActive' => 'home'
])
@section('content')
<style>
    .background-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      z-index: -1;
      opacity: 10;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(70, 95, 90, 0.7); 
      z-index: -1;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    header {
      background-color: #222;
      padding: 5px 0;
    }

    .head_container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .nav a {
      color: #fff;
      text-decoration: none;
      padding: 5px 10px;
    }

    .nav a:hover {
      background-color: #555;
      border-radius: 5px;
    }

    .hambuger {
      display: none;
    }

    i{
      font-size: 150px;
      padding: 5px;
    }
</style>

<div class="background-overlay" id="background-overlay"></div>
  <div class="overlay"></div>
  <!-- Header -->
  @include('pages.header')
  {{-- <div class="container">
    <div class="card mt-3">
      <h1>User QR Code</h1>

      <div>
          {!! $qrCode !!}
      </div>
    </div>
  </div> --}}
  <div class="container">
    <div class="card mt-2">
      <div id="reader"></div>
      <div id="result"></div>
    </div>
  </div>
@endsection
@push('scripts')
  <script>
      function onScanSuccess(decodedText, decodedResult) {
          // Handle the scanned data
          console.log(`Code scanned = ${decodedText}`, decodedResult);

          // Send the scanned data to the server for decryption and verification
          $.ajax({
              url: '/verify-code',
              type: 'POST',
              contentType: 'application/json',
              data: JSON.stringify({ qr_data: decodedText }),
              headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              success: function(data) {
                  if (data.success) {
                      document.getElementById('result').innerHTML = "QR Code Verified!";
                  } else {
                      document.getElementById('result').innerHTML = "Invalid QR Code!";
                  }
              },
              error: function(xhr, status, error) {
                  console.error('Error:', error);
                  document.getElementById('result').innerHTML = "Error verifying QR Code.";
              }
          });
      }

      setTimeout(() => {
        document.getElementById('result').innerHTML = "";
      }, 5000);


        function onScanFailure(error) {
            console.warn(`QR Code scan failed. Reason: ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
  </script>
@endpush

