@extends('website.layouts.master')
@section('content')
<main class="hero_section" id="canvas_container">
      <div class="container">
            <div class="row">
                  <div class="col-md-12 hero_text">
                        <h3>Website Templates, Plugins, and Graphics Digital Marketplace</h3>
                        <h4>Best place to buy and sell digital products.
                        </h4>
                        <div class="input-group">
                              <input type="search" class="form-control" placeholder="Search like 'Wordpress'">
                              <button class="btn bg-light" type="button"><i
                                          class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                  </div>
            </div>
            <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
            @for($i=0;$i<5;$i++)      
                  <div class="col">
                        <div class="hero_service_box">
                              
                              <a href="#">
                                    <img src="{{ asset('assets/images/service/logo.png') }}" alt="">
                                    <p>Laravel</p>
                              </a>
                              
                        </div>
                  </div>
            @endfor
            </div>
      </div>
</main>
@include('website.pages.products')
@endsection