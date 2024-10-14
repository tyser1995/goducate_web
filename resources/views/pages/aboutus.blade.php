@extends('layouts.app', [
'class' => '',
'elementActive' => 'home'
])
@section('content')
<style>
    body {
      font-family: Arial, sans-serif;
      color: #fff;
      margin: 0;
      padding: 0;
      position: relative;
    }

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

    .logo img {
      max-width: 150px;
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
    .about {
      background-color: #444;
      color: #fff;
      padding: 50px 20px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }
    .about h1 {
      font-size: 2.5em;
      margin-bottom: 20px;
    }
    .about p {
      font-size: 1.2em;
      line-height: 1.6;
    }
    footer {
    background-color: #2c3e50; /* Dark background color */
    color: white; /* Text color */
    padding: 20px 40px; /* Padding around the footer */
    text-align: center; /* Center text */
    font-family: Arial, sans-serif; /* Font family */
    border-radius: 15px;
    }

    footer h3 {
        font-size: 24px; /* Font size for the heading */
        margin-bottom: 15px; /* Margin below the heading */
    }

    footer p {
        margin: 10px 0; /* Margin for paragraphs */
        font-size: 16px; /* Font size for paragraphs */
    }

    footer a {
        color: #1abc9c; /* Color for links */
        text-decoration: none; /* Remove underline */
        transition: color 0.3s; /* Smooth transition for hover effect */
    }

    footer a:hover {
        color: #16a085; /* Change color on hover */
    }

    footer i {
        margin-right: 8px; /* Spacing between icon and text */
    }

@media (max-width: 600px) {
    footer {
        padding: 15px; /* Adjust padding for smaller screens */
    }

    footer h3 {
        font-size: 20px; /* Adjust heading size */
    }

    footer p {
        font-size: 14px; /* Adjust paragraph size */
    }
}

</style>

<div class="background-overlay" id="background-overlay"></div>
  <div class="overlay"></div>
  <!-- Header -->
  @include('pages.header')
  <section class="about" id="about">
    <div class="container">
      @foreach ($aboutus as $about)
        <?php
            echo html_entity_decode($about['description']);
        ?>
      @endforeach
    </div>  
    <footer>
    <div>
        <h3>Camp Goducate</h3>
        <p><i class="fas fa-map-marker-alt"></i> Location: Brgy. Sto. Angel, San Miguel, Iloilo</p>
        <p><i class="fas fa-phone"></i> Contact: 0917 588 9136</p>
        <p><i class="fas fa-envelope"></i> Email: goducate.mktg@gmail.com</p>
        <p>Explore more at <a href="https://www.facebook.com/gtc.iloilo" target="_blank">Camp Goducate Facebook Page</a></p>
        <p>Or at <a href="https://www.goducate.org/" target="_blank">Goducate.org </a>Website</p>
    </div>
</footer>

  </section>

@endsection

