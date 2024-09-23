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
    <div class="card mt-3">
      <div class="card-header">
        <h3>Feedback Survey</h3>
      </div>
      <div class="card-body">
          @include('notification.index')
          <form class="form" method="POST" action="{{ route('survey.feedback') }}" autocomplete="off">
              @csrf
              <div class="form-group">
                <label for="name">Services</label>
                <select name="services" id="description" class="form-control" required>
                    <option selected value="">Select option</option>
                    @foreach (App\Models\SurveyModel::SERVICE_TYPE as $key => $type)
                        <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>

              <div class="form-group text-center" style="cursor: pointer">
                <i class="fas fa-angry mood_icon" data-value="angry" style="color: red;"></i>
                <i class="fas fa-sad-tear mood_icon" data-value="sad" style="color: orange;"></i>
                <i class="fas fa-meh mood_icon" data-value="neutral"  style="color: gray;"></i>
                <i class="fas fa-smile mood_icon" data-value="smile"  style="color: green;"></i>
                <i class="fas fa-grin-stars mood_icon" data-value="happy"  style="color: gold;"></i>
              </div>
              <input type="hidden" id="ratings" name="ratings"/>
          
              <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block">Submit Feedback</button>
              </div>
          </form>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script>
    $('.mood_icon').click(function() {
        var selectedMood = $(this).attr('data-value');
        
        $('#ratings').val(selectedMood);
        
        $('.mood_icon').css('opacity', '0.2');
        $(this).css('opacity', '1');
    });
  </script>
@endpush

