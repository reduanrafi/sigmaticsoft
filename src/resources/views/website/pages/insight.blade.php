@extends('website.layouts.master')
@section('content')
    <div class="container">
        <div class="row mt-lg-4 mt-2 mb-3">
            {{-- Top section --}}

            {{-- left Section --}}
            <div class="col-md-8">
                <div class="mt-5">
                    {{-- course cover pic --}}
                    <h1>Latest Insights</h1>
                    @foreach ($insights as $insight)
                        <article>
                            <h2><a class="text-decoration-none" href="{{ route('insights.show', $insight->slug) }}">
                                    {{ substr($insight->title,0,100)  }} More..
                                </a></h2>
                            <p>{{ $insight->excerpt }}</p>
                        </article>
                    @endforeach
                    {{ $insights->links() }}
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
