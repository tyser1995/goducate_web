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

    /* Ensure header stays at the top */
    header {
      background-color: #222;
      padding: 5px 0;
      width: 100%;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
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

    .hamburger {
      display: none;
    }

    /* Flexbox container for centering card */
    .content-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: calc(100vh - 60px); /* Adjust for header height */
    }

    .card {
      width: 50%;
    }

    .card-body {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .volunteer {
      background-color: #444;
      color: #fff;
      padding: 50px 20px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }
    .volunteer h1 {
      font-size: 2.5em;
      margin-bottom: 20px;
    }
    .volunteer p {
      font-size: 1.2em;
      line-height: 1.6;
    }
    .volunteer .image-container {
      text-align: center;
      margin: 20px 0;
    }
    .volunteer .image-container img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
    }
    .volunteer .description {
      display: flex;
      align-items: center;
      margin: 20px 0;
    }
    .volunteer .description img {
      max-width: 50%;
      height: auto;
      border-radius: 10px;
    }
    .volunteer .description .text {
      flex: 1;
      padding: 20px;
    }
    .volunteer .description .text p {
      margin: 0;
    }
    .volunteer .description button {
      padding: 10px 20px;
      background-color: #ff9900;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .volunteer .description button:hover {
      background-color: #e68a00;
    }

</style>

<div class="background-overlay" id="background-overlay"></div>
<div class="overlay"></div>

<!-- Header -->
@include('pages.header')
<div class="volunteer">


<div class="container">
      <h1>Become a Volunteer</h1>
      <p>Volunteering at Camp Goducate is a rewarding experience. You can make a difference in the lives of others while developing your own skills and building lifelong friendships. Here are some reasons why you should volunteer:</p>
      <div class="image-container">
        <img src="images/bckgrnd.png" alt="Volunteer Image">
      </div>
      <div class="description">
        <img src="images/A14.jpg" alt="Volunteers">
        <div class="text">
          <p>Our volunteers participate in a variety of activities including community service projects, team-building exercises, and outdoor adventures. You'll be part of a supportive community dedicated to making a positive impact.</p>
          <a href="javascript:void(0)"><button data-toggle="modal" data-target="#modal_volunteer">Sign Up Now!</button></a>
        </div>
      </div>
    </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="modal_volunteer">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Booking</h5>
          </div>
          <div class="modal-body">
          <form class="form" method="POST" action="{{ route('volunteer.register') }}" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" required autofocus placeholder="{{ __('Enter Name') }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required autofocus placeholder="{{ __('Enter Email') }}">
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address" required autofocus placeholder="{{ __('Enter Address') }}">
                </div>

                <div class="form-group">
                    <label for="birthday">Birthday</label>
                    <input type="date" class="form-control" name="birthday" id="birthday" required autofocus placeholder="{{ __('Enter Name') }}">
                </div>

                <div class="form-group">
                    <label for="church_name">Church Name</label>
                    <input type="text" class="form-control" name="church_name" id="church_name" required autofocus placeholder="{{ __('Enter Church Name') }}">
                </div>

                <div class="form-group">
                    <label for="pastor_name">Pastor Name</label>
                    <input type="text" class="form-control" name="pastor_name" id="pastor_name" required autofocus placeholder="{{ __('Enter Name') }}">
                </div>

                <div class="form-group">
                    <label for="pastor_recommendation">Pastor Recommendation</label>
                    <input type="text" class="form-control" name="pastor_recommendation" id="pastor_recommendation" required autofocus placeholder="{{ __('Enter recommendation') }}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection
