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
      background-image: url("{{asset('images/bckgrnd.png')}}");
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

    .home {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 50px 0;
      min-height: 100vh; /* Full screen height */
    }

    .home .content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 20px;
      flex-wrap: wrap;
      width: 100%;
    }

    .home .content .text {
      flex: 1;
      text-align: left;
    }

    .home .content .text h1 {
      margin: 0;
      font-size: 2.5em;
    }

    .home .content .text p {
      margin: 10px 0;
    }

    .home .content .text button {
      padding: 10px 20px;
      background-color: #ff9900;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .Promo-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      margin: 50px 0 20px 0; /* Adds a 50px margin-top */
      background-color: rgba(255, 255, 255, 0.9); /* Light background with some transparency */
      color: #333;
    }

    .Promo-section .left,
    .Promo-section .center,
    .Promo-section .right {
      flex: 1;
      padding: 20px;
    }

    .Promo-section .left img,
    .Promo-section .right img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
    }

    .Promo-section .right {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .Promo-section .right .activities {
      display: grid;
      grid-template-columns: repeat(2,1fr);
      gap: 20px;
    }

    .Promo-section .right .activity-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .Promo-section .right .activity-item img {
      width: 100px;
      height: 100px;
      border-radius: 5px;
      transition: transform 0.3s ease-in-out;
    }

    .Promo-section .right .activity-item img:hover {
      transform: scale(1.5);
    }

    /* Keyframes for sliding effect */
    @keyframes slide-left {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: -100% 0;
      }
    }

    .background-overlay {
      animation: slide-left 5s infinite ease-in-out;
    }

    .content {
      text-align: center;
    }
    .text h1 {
      font-size: 2rem;
      margin-bottom: 1rem;
    }
    .text p {
      margin-bottom: 1rem;
      font-size: 1rem;
      color: #555;
    }
    .text button {
      padding: 0.5rem 1rem;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .text button:hover {
      background-color: #0056b3;
    }
    .announcement {
      position: absolute;
      top: 40%;
      left: 80%;
      transform: translate(-50%, -50%);
      background-color: #f9f9f93a;
      padding: 1rem;
      overflow: hidden;
      box-shadow: -3px 0 5px rgba(0, 0, 0, 0.1);
    }

    .announcement .carousel-inner {
      width: 100%;
      height: 100%;
    }

    .announcement .carousel-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }

    .announcement h2 {
      margin-top: 0;
    }
</style>

<div class="background-overlay" id="background-overlay"></div>
<div class="overlay"></div>

<!-- Header -->
@include('pages.header')

<!-- Home Section -->
<section class="home" id="home">
  <div class="container content">
    <div class="text">
      <h1 style="color:#fff">Welcome to Camp Goducate Iloilo</h1>
      <p style="color:#fff">Relax and enjoy your stay at Camp Goducate.</p>
      <a href="{{ url('/_booking') }}"><button>Book Now</button></a>
    </div>
  </div>
</section>
<!-- Sliding Announcement Section -->
<div class="announcement">
  <div id="announcement-slider">
    @if (count($announcements) > 0)
    <h4 style="color:#fff">Announcements</h4>
    <div id="carouselExample" class="carousel slide carousel-dark">
      <div class="carousel-inner announcement-item-img">
        @foreach ($announcements as $key => $announcement)
          <div class="carousel-item @if($key === 0) active @endif">
            @if ($announcement->attachment === "default-announcement.png")
              <img
                src="{{ asset('images/default-announcement.png') }}"
                alt="Default Announcement"
                class="img-fluid"
                data-bs-toggle="modal"
                data-bs-target="#imageModal"
                data-image="{{ asset('images/default-announcement.png') }}"
                {{-- data-description="{{ html_entity_decode($announcement['description']) }}" --}}
                loading="lazy" />
                <div class="d-none desc">
                  <?php
                  echo html_entity_decode($announcement['description']);
              ?>
                </div>
            @else
            <img
              src="{{ asset('images/announcement/' . $announcement->attachment) }}"
              alt="{{ $announcement->title }}"
              class="img-fluid"
              data-bs-toggle="modal"
              data-bs-target="#imageModal"
              data-image="{{ asset('images/announcement/' . $announcement->attachment) }}"
              {{-- data-description="{{ html_entity_decode($announcement['description']) }}" --}}
              loading="lazy" />
              <div class="d-none desc">
                <?php
                  echo html_entity_decode($announcement['description']);
              ?>
              </div>
            @endif
          </div>
        @endforeach
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    @else
    <div class="announcement-item">
      <p>No Announcement.</p>
    </div>
    @endif
  </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Announcement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div class="row">
          <div class="col-12">
            <img id="modalImage" src="" alt="" class="img-fluid" height="500px" width="100%">
          </div>
          <div class="col-12">
            <div id="modalDescription"></div>
          </div>
        </div>
       
        
      </div>
    </div>
  </div>
</div>


<!-- Promo and Announcements Section -->
<section class="Promo-section">
  <div class="right">
    @if (count($lists) > 0)
      <h2>Activities</h2>
      <div class="activities" id="activities-container">
        @foreach ($lists as $list)
          <div class="activity-item">
            <img src="{{ asset('images/header_list/' . $list->image) }}" class="mb-2" style="width: 100px; height:100px" alt="{{ $list->title }}" />
            <p>{{$list->title}}</p>
          </div>
        @endforeach
      </div>

      <!-- Pagination controls -->
      <div id="pagination-controls">
        <button id="prevPage" class="btn btn-sm btn-info">
          <i class="fa fa-angle-left"></i>
        </button>
        <button id="nextPage" class="btn btn-sm btn-info">
          <i class="fa fa-angle-right"></i>
        </button>
      </div>
    @else
      <p>No Activities.</p>
    @endif
  </div>
</section>

<!-- JavaScript for background slideshow -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const backgroundOverlay = document.getElementById('background-overlay');
  const backgroundImages = [
    "{{asset('images/bckgrnd.png')}}",
    "{{asset('images/A11.jpg')}}",
    "{{asset('images/A12.jpg')}}",
    "{{asset('images/A13.jpg')}}",
    "{{asset('images/A14.jpg')}}"
  ];
  let currentIndex = 0;

  // Function to change the background image
  function changeBackground() {
    currentIndex = (currentIndex + 1) % backgroundImages.length;
    backgroundOverlay.style.backgroundImage = `url(${backgroundImages[currentIndex]})`;
    backgroundOverlay.style.animation = 'slide-left 3s ease-in-out'; // Apply the slide-left animation
  }

  // Change background every 5 seconds
  setInterval(changeBackground, 3000);

  // Set initial background image on page load
  window.onload = function() {
    backgroundOverlay.style.backgroundImage = `url(${backgroundImages[currentIndex]})`;
  };

  document.addEventListener("DOMContentLoaded", function () {
  const imageModal = document.getElementById("imageModal");
  const modalImage = document.getElementById("modalImage");
  const modalDescription = document.getElementById("modalDescription");

  imageModal.addEventListener("show.bs.modal", function (event) {
    const trigger = event.relatedTarget; // The clicked image that triggered the modal
    const imageSrc = trigger.getAttribute("data-image"); // Get image source
    const descriptionElement = trigger.closest(".carousel-item").querySelector(".desc"); // Find the related description

    // Update modal content
    modalImage.src = imageSrc;
    modalDescription.innerHTML = descriptionElement ? descriptionElement.innerHTML : "No description available.";
  });
});


</script>

@endsection
