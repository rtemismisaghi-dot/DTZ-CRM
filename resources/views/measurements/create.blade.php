@extends('layouts.app')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <h1>انتخاب نوع اندازه‌گیری</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">

                @foreach($types as $key => $title)

                <div class="col-md-4 mb-4">

                    <a href="{{ route('measurements.create',['type'=>$key]) }}"
                       class="text-decoration-none text-dark">

                        <div class="card card-primary card-outline shadow-sm">

                            <img src="{{ asset('images/measurements/'.$key.'.jpg') }}"
                                 class="card-img-top"
                                 style="height:220px;object-fit:cover;"
                                 alt="{{ $title }}">

                            <div class="card-body text-center">

                                <h4 class="mb-0">{{ $title }}</h4>

                            </div>

                        </div>

                    </a>

                </div>

                @endforeach

            </div>

        </div>
    </section>

</div>
@endsectionُ