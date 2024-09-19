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
</style>

<div class="background-overlay" id="background-overlay"></div>
  <div class="overlay"></div>
  <!-- Header -->
  @include('pages.header')
  <div class="container">
    <div class="card mt-3">
      <div class="card-header">
        <h3>Survey</h3>
      </div>
      <div class="card-body">
          @include('notification.index')
          <form class="form" method="POST" action="{{ route('survey.register') }}" autocomplete="off">
              @csrf
              <div class="form-group">
                <label for="children">Group Type:</label>
                <select name="group_type" id="group_type" class="group_type form-control" required>
                  <option selected value="">Select option</option>
                  @foreach (App\Models\SurveyModel::GROUP_TYPE as $key => $type)
                    <option value="{{$key}}">{{$type}}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="children">Person Type:</label>
                <select name="person_type" id="person_type" class="person_type form-control" required>
                  <option selected value="">Select option</option>
                  @foreach (App\Models\SurveyModel::PERSON_TYPE as $key => $type)
                    <option value="{{$key}}">{{$type}}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                  <label for="municipality">Select Municipality:</label>
                  <select name="address" id="municipality" class="form-control" required>
                      <option selected value="">Select Municipality</option>
                  </select>
              </div>
          
              <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block">Submit Survey</button>
              </div>
          </form>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script>
    $.getJSON('{{ asset('data/iloilo_municipalities.json') }}', function(data) {
        $.each(data.municipal, function(index, municipality) {
            $('#municipality').append(
                '<option value="' + municipality.name + '">' + municipality.name + '</option>'
            );
        });
    });

  </script>
@endpush

