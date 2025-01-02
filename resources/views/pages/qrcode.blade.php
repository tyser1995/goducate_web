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
  <div class="container">
    <div class="card mt-2">
      <select name="title" class="form-control" id="activity_list">
        <option selected value="0">Select Activities</option>
        @foreach (App\Models\ActivityList::getActivityList() as $activity_list)
            <option value="{{ $activity_list->id }}">
                {{ $activity_list->title }}
              </option>
        @endforeach
    </select>
    </div>
    <div class="card mt-2 qr_container d-none">
      <div id="reader"></div>
      <div id="result"></div>
    </div>
  </div>
  
@include('pages.modal.index')
@endsection
@push('scripts')
<script>

  $('#activity_list').change(function (e) {
    $('.qr_container').addClass('d-none');
    if($(this).val() != 0){
      $('.qr_container').removeClass('d-none');
    }
  });
  let isScanning = true;

  function resetScanner() {
    isScanning = true;
    html5QrcodeScanner.clear(); // Clear the scanner
    html5QrcodeScanner.render(onScanSuccess, onScanFailure); // Reinitialize
  }

  function onScanSuccess(decodedText, decodedResult) {
      if (!isScanning) return;

      isScanning = false;

      // Handle the scanned data
      console.log(`Code scanned = ${decodedText}`, decodedResult);
      console.log(decodedText);
      $.ajax({
          url: '/verify-code',
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify({
            qr_data: decodedText,
            title: $('#activity_list').val(),
            description: $('#activity_list option:selected').text()
          }),
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          success: function(data) {
              $('#modalMessage').modal('show');
              if (data.success) {
                  $('.title_name')[0].innerHTML = "Successful";
                  $('#validationMessage')[0].innerHTML = "Successfully deducted";
                  $('.qr_container').addClass('d-none');
              } else {
                $('.qr_container').addClass('d-none');
                  $('.title_name')[0].innerHTML = "Error";
                  $('#validationMessage')[0].innerHTML = "Out of recreational balance. Please contact Goducate Administrator";
              }
              $('#activity_list').val(0);
              resetScanner();
              setTimeout(() => {
                  $('#modalMessage').modal('hide');
              }, 5000);
          },
          error: function(xhr, status, error) {
              document.getElementById('result').innerHTML = "Error verifying QR Code.";

              setTimeout(() => {
                  document.getElementById('result').innerHTML = "";
              }, 5000);
          },
          complete: function() {
              // Re-enable scanning after a 3-second delay
              setTimeout(() => {
                  isScanning = true;
                  resetScanner();
              }, 3000);
          }
      });
  }

  function onScanFailure(error) {
      // Optional: Handle scan failure
      // console.warn(`QR Code scan failed. Reason: ${error}`);
  }

  let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", { fps: 10, qrbox: 250 });
  html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

@endpush

