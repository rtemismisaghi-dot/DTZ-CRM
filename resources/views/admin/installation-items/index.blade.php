@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                آیتم‌های نصب
            </h5>

            <a href="#" class="btn btn-primary">
                + افزودن آیتم
            </a>

        </div>


        <div class="card-body">


            <table class="table table-bordered text-center">

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            عنوان
                        </th>

                        <th>
                            کلید
                        </th>

                        <th>
                            قیمت
                        </th>

                        <th>
                            وضعیت
                        </th>

                        <th>
                            عملیات
                        </th>

                    </tr>

                </thead>


                <tbody>


                @foreach($items as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>


                        <td>
                            {{ $item->title }}
                        </td>


                        <td>
                            {{ $item->key }}
                        </td>


                        <td>
                            {{ number_format($item->price) }}
                            ریال
                        </td>


                        <td>

                            @if($item->status)

                                <span class="badge bg-success">
                                    فعال
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    غیرفعال
                                </span>

                            @endif

                        </td>


                        <td>

                            <button class="btn btn-sm btn-warning">
                                ویرایش
                            </button>


                            <button class="btn btn-sm btn-danger">
                                حذف
                            </button>

                        </td>


                    </tr>

                @endforeach


                </tbody>


            </table>


        </div>

    </div>

</div>


@endsection