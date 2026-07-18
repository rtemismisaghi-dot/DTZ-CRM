@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">
    <h1 style="color:red">TEST CREATE FORM</h1>

    <!-- HEADER -->
    <div class="bg-white shadow-sm rounded-4 p-4 mb-4 d-flex justify-content-between align-items-center">

        <div>
            <h4 class="fw-bold mb-1">📏 ثبت اندازه‌گیری</h4>
            <small class="text-muted">نوع: {{ $type }}</small>
        </div>

        <a href="{{ route('measurements.index') }}" class="btn btn-outline-dark rounded-3">
            بازگشت
        </a>

    </div>

    <form action="{{ route('measurements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <input type="hidden" name="measurement_type" value="{{ $type }}">

        <div class="row g-4">

            <!-- LEFT SIDE -->
            <div class="col-lg-8">

                <!-- CUSTOMER -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-3">👤 اطلاعات مشتری</h5>

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">شماره تماس</label>
                                <input type="text" class="form-control" name="phone">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">نام</label>
                                <input type="text" class="form-control" name="name">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">کد ملی</label>
                                <input type="text" class="form-control" name="national_code">
                            </div>

                        </div>

                    </div>
                </div>

                <!-- DETAILS -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-3">📝 جزئیات اندازه‌گیری</h5>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">عنوان</label>
                                <input type="text" class="form-control" name="title">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">تاریخ</label>
                                <input type="date" class="form-control" name="measurement_date">
                            </div>

                            <div class="col-12">
                                <label class="form-label">توضیحات</label>
                                <textarea class="form-control" rows="4" name="description"></textarea>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- LOCATION -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-3">📍 موقعیت</h5>

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <button type="button" class="btn btn-outline-primary" onclick="getLocation()">
                            دریافت موقعیت
                        </button>

                        <div class="small text-muted mt-2" id="locationText">
                            هنوز ثبت نشده
                        </div>

                    </div>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-4">

                <!-- TYPE -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">

                        <h6 class="fw-bold mb-3">⚙️ تنظیمات</h6>

                        <div class="mb-3">
                            <label class="form-label">انجام‌دهنده</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="measurement_by" value="staff" checked>
                                <label class="form-check-label">پرسنل</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="measurement_by" value="customer">
                                <label class="form-check-label">مشتری</label>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label">قوانین</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="terms_type" value="online" checked>
                                <label class="form-check-label">آنلاین</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="terms_type" value="offline">
                                <label class="form-check-label">آفلاین</label>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label">پرداخت</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_status" value="paid">
                                <label class="form-check-label">پرداخت شده</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_status" value="pending" checked>
                                <label class="form-check-label">در انتظار</label>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- IMAGE -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">

                        <h6 class="fw-bold mb-3">🖼 تصویر</h6>

                        <input type="file" class="form-control" name="image">

                    </div>
                </div>

                <!-- SUBMIT -->
                <button class="btn btn-success w-100 btn-lg rounded-3">
                    ثبت اندازه‌گیری
                </button>

            </div>

        </div>

    </form>

</div>

<script>
function getLocation() {

    if (!navigator.geolocation) {
        alert("GPS پشتیبانی نمی‌شود");
        return;
    }

    navigator.geolocation.getCurrentPosition(function(pos){

        document.getElementById('latitude').value = pos.coords.latitude;
        document.getElementById('longitude').value = pos.coords.longitude;

        document.getElementById('locationText').innerText =
            "موقعیت ثبت شد ✔";

    });

}
</script>

@endsection