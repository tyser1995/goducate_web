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

    .home {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 50px 0;
      min-height: 80vh;
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

    .home .image {
      display: none;
    }

    .image_item {
      display: flex;
      flex-direction: column;
      gap: 10px;
      overflow-y: auto;
      padding: 10px;
      border-radius: 10px;
    }

    .image_item img {
      width: 100px;
      cursor: pointer;
      opacity: 0.6;
      transition: opacity 0.3s;
      border-radius: 5px;
    }

    .image_item img.active {
      opacity: 1;
      border: 2px solid #ff9900;
    }

    .Promo-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      margin: 20px 0;
      background-color: rgba(248, 249, 250, 0.9);
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

    .Promo-section .center {
      text-align: center;
    }

    .Promo-section .right .activities {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .Promo-section .right .activities div {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .Promo-section .right .activities div img {
      width: 100px;
      height: auto;
      border-radius: 5px;
      transition: transform 0.3s ease-in-out;
    }

    .Promo-section .right .activities div img:hover {
      transform: scale(1.5);
    }
</style>

<div class="background-overlay" id="background-overlay"></div>
  <div class="overlay"></div>
  <!-- Header -->
  @include('pages.header')
  <!-- Home -->
  <section class="home" id="home">
    <div class="container content">
      <div class="text">
        <h1>Welcome to Camp Goducate Iloilo</h1>
        <p>Relax and enjoy your stay at Camp Goducate.</p>
        <a href="booking.php"><button>Book Now</button></a>
      </div>
      <div class="image_item">
        <img src="{{asset('images')}}/bckgrnd.png" alt="Image 1" class="slide active" onclick="setBackground('{{asset('images')}}/bckgrnd.png')">
        <img src="{{asset('images')}}/A11.jpg" alt="Image 2" class="slide" onclick="setBackground('{{asset('images')}}/A11.jpg')">
        <img src="{{asset('images')}}/A12.jpg" alt="Image 3" class="slide" onclick="setBackground('{{asset('images')}}/A12.jpg')">
        <img src="{{asset('images')}}/A13.jpg" alt="Image 4" class="slide" onclick="setBackground('{{asset('images')}}/A13.jpg')">
        <img src="{{asset('images')}}/A14.jpg" alt="Image 5" class="slide" onclick="setBackground('{{asset('images')}}/A14.jpg')">
      </div>
    </div>
  </section>

  <!-- Promo and announcement  -->
  <section class="Promo-section">
    <div class="left">
      <img src="{{asset('images')}}/about.jpg" alt="Left Image">
    </div>
    <div class="center">
      <p>Description of the Promo.</p>
    </div>
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
        <p>No Activites.</p>
      @endif

      
    </div>
  </section>

  <script>
     const itemsPerPage = 3;
      let currentPage = 1;

      const items = document.querySelectorAll('.activity-item');
      const totalPages = Math.ceil(items.length / itemsPerPage);

      function showPage(page) {
          const start = (page - 1) * itemsPerPage;
          const end = start + itemsPerPage;

          items.forEach((item, index) => {
              item.style.display = (index >= start && index < end) ? 'flex' : 'none';
          });
      }

      document.getElementById('nextPage').addEventListener('click', () => {
          if (currentPage < totalPages) {
              currentPage++;
              showPage(currentPage);
          }
      });

      document.getElementById('prevPage').addEventListener('click', () => {
          if (currentPage > 1) {
              currentPage--;
              showPage(currentPage);
          }
      });

      // Show the first page initially
      showPage(currentPage);

    function setBackground(imageUrl) {
        var backgroundOverlay = document.getElementById('background-overlay');
        backgroundOverlay.style.backgroundImage = 'url(' + imageUrl + ')';
    
        var slides = document.querySelectorAll('.slide');
        slides.forEach(function(slide) {
            slide.classList.remove('active');
        });
    
        var activeSlide = document.querySelector('img[src="' + imageUrl + '"]');
        if (activeSlide) {
            activeSlide.classList.add('active');
        }
    }
    </script>
@endsection

