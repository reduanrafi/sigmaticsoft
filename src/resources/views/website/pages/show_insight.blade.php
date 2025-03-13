@extends('website.layouts.master')
@section('title', $insight->meta_title ?? $insight->title)
@section('meta_description', $insight->meta_description)
@section('meta_keywords', $insight->meta_keywords)
@section('content')
    <div class="container">
        <div class="row mt-lg-4 mt-2 mb-3">
            {{-- Top section --}}

            {{-- left Section --}}
            <div class="col-md-8">
                <div class="mt-5">
                    {{-- course cover pic --}}
                    <article >
                        <h1>{{ $insight->title }}</h1>
                        <img class="img-thumbnail" src="{{ asset($insight->featured_image) }}"   alt="{{ $insight->title }}">
                        <div style="text-align: justify">
                            <p  {!! $insight->content !!}
                        </div>

                    </article>
                </div>
            </div>
            {{-- right section --}}
            <div class="col-md-4">
                {{-- first card --}}
                <div class="card mt-5">

                    <div class="card-body py-5 px-3">
                        <div class="d-flex flex-column align-items-start justify-content-center">
                            @foreach($categories as $category)
                                <p class="fs-5 text-capitalize"><i class="fa-solid fa-book pe-3 text-success"></i>
                                    <a class="text-decoration-none text-black" href="{{ route('insights.index') }}">{{$category->name}}</a>

                                </p>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
