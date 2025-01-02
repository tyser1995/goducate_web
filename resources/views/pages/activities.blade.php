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
</style>

<div class="background-overlay" id="background-overlay"></div>
  <div class="overlay"></div>
  <!-- Header -->
  @include('pages.header')
  <section class="about" id="about">
    <div class="container">
      @foreach ($headers as $header)
        <?php
            echo html_entity_decode($header['description']);
        ?>
      @endforeach
      <div class="row">
        @foreach ($lists as $list)
            <div class="col-3">
                <div class="card shadow">
                    <div class="card-body">
                        <a href="{{ route('_activities_page', ['id' => Hashids::encode($list->id)]) }}" class="btn btn-info btn-sm" title="Edit">
                          <img src="{{ asset('images/header_list/' . $list->image) }}" class="mb-2" style="width: 100%; height:200px" alt="{{ $list->title }}" />
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>
  </section>
@endsection

