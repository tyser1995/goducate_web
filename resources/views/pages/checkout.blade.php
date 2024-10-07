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
      margin: 0 auto;
      padding: 0 100px;
    }

    .logo img {
      max-width: 150px;
    }
    .about {
      background-color: #444;
      color: #fff;
      padding: 50px 20px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    label{
        color: #fff !important;
    }

    .alert-success{
        color: #000000 !important;
    }
</style>

<div class="background-overlay" id="background-overlay"></div>
  <div class="overlay"></div>
  <section class="about" id="about">
    <div class="container">
        @include('notification.index')
        <form action="{{ route('checkout.process') }}" method="post" id="payment-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="customer_id" id="customer_id">
            <div class="row">
                <div class="form-group col-6">
                  <label for="name">Upload Payment Screenshot:</label>
                  <input type="file" class="form-control" id="name" name="attachment" required>
                </div>
            </div>
           
            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
    </div>
  </section>
@endsection
@push('scripts')
<script>
    var url = new URL(window.location.href);
    var urlObj = new URL(url);
    var path = urlObj.pathname;
    var segments = path.split('/');
    var id_value = '';

    $.each(segments, function(index, segment) {
        if (segment.startsWith('id=')) {
            id_value = segment.split('=')[1];
        }
    });

   $('#customer_id').val(id_value);
</script>
@endpush
