@extends('website.layouts.master')
@section('content')
    <main class="hero_section" id="canvas_container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 hero_text">
                    <h3 class="text-dark">Website Templates, Plugins, and Graphics Digital Marketplace</h3>
                    <h4 class="text-dark">Best place to buy and sell digital products.
                    </h4>
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Search like 'Wordpress'">
                        <button class="btn bg-light" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('website.pages.products')
    @include('website.pages.subscribe')
@endsection
