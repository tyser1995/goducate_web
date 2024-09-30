<header>
    <div class="container head_container">
      <div class="logo"><img src="{{asset('images')}}/logo.webp" alt="Logo"></div>
      <div class="nav">
        <a href="{{url('/home')}}">Home</a>
        <a href="{{url('/_aboutus')}}">About Us</a>
        <a href="{{url('/_activities')}}">Activities</a>
        <a href="{{url('/_booking')}}" class="book_now">Book Now</a>
        <a href="{{url('/_volunteer')}}">Volunteer</a>
        <a href="{{url('/login')}}" hidden>Login</a>
        <div class="hambuger" id="hamburger-menu">
          <div class="bar"></div>
          <div class="bar"></div>
          <div class="bar"></div>
        </div>
      </div>
    </div>
</header>
  