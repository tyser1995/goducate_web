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

    i {
      font-size: 150px;
      padding: 5px;
      cursor: pointer;
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
                <!-- Food/Resto -->
                <div class="form-group">
                    <label for="food_resto">Food/Resto</label>
                    <input type="hidden" id="food_resto" name="food_resto"/>
                </div>

                <div class="form-group text-center">
                    <i class="fas fa-angry mood_icon" data-value="angry" data-target="food_resto" style="color: red;"></i>
                    <i class="fas fa-sad-tear mood_icon" data-value="sad" data-target="food_resto" style="color: orange;"></i>
                    <i class="fas fa-meh mood_icon" data-value="neutral" data-target="food_resto" style="color: gray;"></i>
                    <i class="fas fa-smile mood_icon" data-value="smile" data-target="food_resto" style="color: green;"></i>
                    <i class="fas fa-grin-stars mood_icon" data-value="happy" data-target="food_resto" style="color: gold;"></i>
                </div>

                <!-- Accommodations -->
                <div class="form-group">
                    <label for="accommodation">Accommodations</label>
                    <input type="hidden" id="accommodation" name="accommodation"/>
                </div>

                <div class="form-group text-center">
                    <i class="fas fa-angry mood_icon" data-value="angry" data-target="accommodation" style="color: red;"></i>
                    <i class="fas fa-sad-tear mood_icon" data-value="sad" data-target="accommodation" style="color: orange;"></i>
                    <i class="fas fa-meh mood_icon" data-value="neutral" data-target="accommodation" style="color: gray;"></i>
                    <i class="fas fa-smile mood_icon" data-value="smile" data-target="accommodation" style="color: green;"></i>
                    <i class="fas fa-grin-stars mood_icon" data-value="happy" data-target="accommodation" style="color: gold;"></i>
                </div>

                <!-- Recreation Activities -->
                <div class="form-group">
                    <label for="recreation">Recreation Activities</label>
                    <input type="hidden" id="recreation" name="recreation"/>
                </div>

                <div class="form-group text-center">
                    <i class="fas fa-angry mood_icon" data-value="angry" data-target="recreation" style="color: red;"></i>
                    <i class="fas fa-sad-tear mood_icon" data-value="sad" data-target="recreation" style="color: orange;"></i>
                    <i class="fas fa-meh mood_icon" data-value="neutral" data-target="recreation" style="color: gray;"></i>
                    <i class="fas fa-smile mood_icon" data-value="smile" data-target="recreation" style="color: green;"></i>
                    <i class="fas fa-grin-stars mood_icon" data-value="happy" data-target="recreation" style="color: gold;"></i>
                </div>

                <!-- Place -->
                <div class="form-group">
                    <label for="place">Place</label>
                    <input type="hidden" id="place" name="place"/>
                </div>

                <div class="form-group text-center">
                    <i class="fas fa-angry mood_icon" data-value="angry" data-target="place" style="color: red;"></i>
                    <i class="fas fa-sad-tear mood_icon" data-value="sad" data-target="place" style="color: orange;"></i>
                    <i class="fas fa-meh mood_icon" data-value="neutral" data-target="place" style="color: gray;"></i>
                    <i class="fas fa-smile mood_icon" data-value="smile" data-target="place" style="color: green;"></i>
                    <i class="fas fa-grin-stars mood_icon" data-value="happy" data-target="place" style="color: gold;"></i>
                </div>

                <!-- Services -->
                <div class="form-group">
                    <label for="services">Services</label>
                    <input type="hidden" id="services" name="services"/>
                </div>

                <div class="form-group text-center">
                    <i class="fas fa-angry mood_icon" data-value="angry" data-target="services" style="color: red;"></i>
                    <i class="fas fa-sad-tear mood_icon" data-value="sad" data-target="services" style="color: orange;"></i>
                    <i class="fas fa-meh mood_icon" data-value="neutral" data-target="services" style="color: gray;"></i>
                    <i class="fas fa-smile mood_icon" data-value="smile" data-target="services" style="color: green;"></i>
                    <i class="fas fa-grin-stars mood_icon" data-value="happy" data-target="services" style="color: gold;"></i>
                </div>

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
        var targetField = $(this).attr('data-target');
        
        $('#' + targetField).val(selectedMood);
        
        // Reset the opacity for all mood icons in the current section
        $(this).parent().find('.mood_icon').css('opacity', '0.2');
        $(this).css('opacity', '1');
    });
</script>
@endpush
