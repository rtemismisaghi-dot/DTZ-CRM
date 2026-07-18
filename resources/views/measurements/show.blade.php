@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-3">


    {{-- عنوان --}}
    <div class="card border-0 shadow-sm mb-3">

        <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
                <div>

                    <h5 class="fw-bold mb-1">
                        اطلاعات اندازه گیری
                    </h5>


                </div>


                <button class="btn btn-danger btn-sm">
                    تکمیل
                </button>


            </div>

        </div>

    </div>



    {{-- اطلاعات اندازه گیری --}}
    <div class="card border-0 shadow-sm mb-3">
<div class="d-flex justify-content-between align-items-center mb-3">

    <h6 class="fw-bold mb-0">
        اطلاعات کاربر
    </h6>

    <div class="d-flex gap-2">

        <button class="btn btn-dark btn-sm">
            پیام نصب
        </button>

        <button class="btn btn-dark btn-sm">
            پیام فروش
        </button>

    </div>

</div>

       <div class="row g-3">


{{-- ستون ۱ --}}
<div class="col-md-3">

    <p>
        <small class="text-muted">نام:</small>
        <strong>{{ $measurement->customer->name ?? '-' }}</strong>
    </p>

    <p>
        <small class="text-muted">کد ملی:</small>
        {{ $measurement->customer->national_code ?? 'نامشخص' }}
    </p>

    <p>
        <small class="text-muted">شماره پیگیری:</small>
        {{ $measurement->tracking_code }}
    </p>

    <p>
        <small class="text-muted">آدرس:</small>
        {{ $measurement->address ?? 'نامشخص' }}
    </p>

</div>



{{-- ستون ۲ --}}
<div class="col-md-3">

    <p>
        <small class="text-muted">شماره همراه:</small>
        {{ $measurement->customer->mobile ?? '-' }}
    </p>

    <p>
        <small class="text-muted">تاریخ ثبت:</small>
        {{ $measurement->created_at->format('Y/m/d H:i') }}
    </p>

    <p>
        <small class="text-muted">قوانین و مقررات:</small>
        تایید شده
    </p>

</div>



{{-- ستون ۳ --}}
<div class="col-md-3">



    <p>
        <small class="text-muted">نوع اندازه گیری:</small>
        {{ $measurement->measurement_type }}
    </p>

    <p>
        <small class="text-muted">نحوه پرداخت:</small>
        {{ $measurement->payment_status ?? '-' }}
    </p>

</div>



{{-- ستون ۴ --}}
<div class="col-md-3">

    <p>
        <small class="text-muted">مبلغ کل:</small>
        <strong>
            {{ number_format($measurement->total_price ?? 0) }}
            ریال
        </strong>
    </p>


    <p>
        <small class="text-muted">نحوه امضا:</small>
        آنلاین
    </p>


    <p>
        <small class="text-muted">کد پستی:</small>
        نامشخص
    </p>


    <p>
        <small class="text-muted">تکمیل آدرس:</small>
        -
    </p>

</div>
</div>
</div>
{{-- وضعیت پرداخت --}}
<div class="card border-0 shadow-sm mb-3">

    <div class="card-body">

<div class="row align-items-center">

    <div class="col-md-8">
        <label class="fw-bold mb-0">
            وضعیت پرداخت
        </label>
    </div>

    <div class="col-md-4 ms-auto text-start">
        <select class="form-select form-select-sm" name="payment_status">
            <option value="unpaid">پرداخت نشده</option>
            <option value="pending">در انتظار تایید</option>
            <option value="processing">در حال پردازش</option>
            <option value="paid">پرداخت شده</option>
            <option value="refunded">عودت وجه</option>
        </select>
    </div>

</div>

    </div>

</div>
    {{-- وضعیت اندازه گیری --}}
    <div class="card border-0 shadow-sm mb-1">


        <div class="card-body">


          <div class="row align-items-center">

    <div class="col-md-8">
        <label class="fw-bold mb-0">
            وضعیت اندازه گیری
        </label>
    </div>
        <div class="col-md-4 text-start">

        <select class="form-select form-select-sm">

            <option>
                ایجاد شده
            </option>

            <option>
                تعیین وقت
            </option>

            <option>
                آماده اندازه گیری
            </option>

            <option>
                در حال اندازه گیری
            </option>

            <option>
                تمام شده
            </option>

        </select>

    </div>

</div>
    </div> {{-- پایان card-body --}}
</div> {{-- پایان کارت وضعیت اندازه گیری --}}
   
<div class="accordion mb-3" id="smsAccordion">

    <div class="accordion-item shadow-sm">

        <h2 class="accordion-header">

            <button class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#smsCollapse">

                متن SMS های ارسالی

            </button>

        </h2>

        <div id="smsCollapse"
             class="accordion-collapse collapse">

            <div class="accordion-body">

                <!-- تمام محتوای کارت قبلی را اینجا قرار بده -->

            </div>

        </div>

    </div>

</div>
{{-- لاگ ها --}}
<div class="accordion mb-3" id="logAccordion">

    <div class="accordion-item shadow-sm">

        <h2 class="accordion-header">

            <button class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#logCollapse">

                لاگ ها

            </button>

        </h2>

        <div id="logCollapse"
             class="accordion-collapse collapse">

            <div class="accordion-body">

                <!-- جدول لاگ -->

            </div>

        </div>

    </div>

</div>
<div class="accordion mb-3">

<div class="accordion-item shadow-sm">

<h2 class="accordion-header">

<button class="accordion-button collapsed"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#archiveInvoices">

فاکتورهای بایگانی شده

</button>

</h2>


<div id="archiveInvoices"
     class="accordion-collapse collapse">

<div class="accordion-body">

هنوز فاکتور بایگانی شده‌ای وجود ندارد.

</div>

</div>

</div>

</div>
{{-- اصلاحیه‌ها --}}

<div class="accordion mb-3">

    <div class="accordion-item shadow-sm">


        <h2 class="accordion-header">


            <button class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#revisions">


                اصلاحیه‌ها


            </button>


        </h2>



        <div id="revisions"
             class="accordion-collapse collapse">


            <div class="accordion-body">


                <div class="text-center text-muted py-4">


                    اصلاحیه‌ای ثبت نشده است.


                </div>


            </div>


        </div>


    </div>

</div>  
<div class="card shadow-sm border-0 mb-3">

    <div class="card-header bg-white">
        <strong>موارد خاص</strong>
    </div>

    <div class="card-body">

        <textarea class="form-control mb-4"
                  rows="5"
                  placeholder="در صورت وجود موارد خاص، اینجا ثبت کنید..."></textarea>

        <div style="width:300px;">

            <label class="fw-bold mb-2">
                مبلغ پیشنهادی
            </label>

            <div class="input-group mb-3">

                <input type="number"
                       class="form-control text-center"
                       value="0">

                <span class="input-group-text">
                    ریال
                </span>

            </div>

            <button class="btn btn-dark px-5">
                ثبت قیمت
            </button>

        </div>

    </div>

</div>
<div class="card shadow-sm border-0 mb-3">

    <div class="list-group list-group-flush">

        <div class="list-group-item d-flex justify-content-between">

            <span>جمع کل</span>

            <strong>-</strong>

        </div>

        <div class="list-group-item d-flex justify-content-between">

            <span>کارمزد شرکت</span>

            <strong>-</strong>

        </div>

        <div class="list-group-item d-flex justify-content-between">

            <span>اجرت نصاب</span>

            <strong>-</strong>

        </div>

    </div>

</div>
<div class="accordion mb-3">

    <div class="accordion-item shadow-sm">

        <h2 class="accordion-header">

            <button class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#payments">

                پرداخت‌ها

            </button>

        </h2>

        <div id="payments" class="accordion-collapse collapse">

            <div class="accordion-body text-center text-muted py-4">

                هنوز پرداختی انجام نشده است.

            </div>

        </div>

    </div>

</div>
{{-- هشدارها و عملیات --}}
<div class="card shadow-sm border-0 mb-3">

    <div class="card-body">

<div class="d-flex align-items-center gap-4 mb-4" style="justify-content:left;">
    <div class="text-danger fw-bold">
        ✖ قوانین تایید نشده است
    </div>

    <div class="text-danger fw-bold">
        ✖ آدرس ثبت نشده است
    </div>

</div>

        <div class="d-flex justify-content-end gap-2">

           <button class="btn btn-dark px-4">
    تایید قوانین
</button>

<button class="btn btn-dark px-4">
    ثبت آدرس
</button>

<button class="btn btn-dark px-4">
    بایگانی
</button>

        </div>

    </div>

</div>
<style>

.accordion-item{
    border:0!important;
    border-radius:10px!important;
    overflow:hidden;
}

.accordion-button{
    background:#fff!important;
    box-shadow:none!important;
    font-weight:700;
    padding:16px 20px;
}

.accordion-button:not(.collapsed){
    background:#fff!important;
    color:#000;
    box-shadow:none!important;
}

.accordion-button:focus{
    box-shadow:none!important;
}

.accordion-button::after{
    margin-right:auto;
    margin-left:0;
}

.accordion-body{
    background:#fff;
    border-top:1px solid #eee;
}
/* فلش آکاردئون شبیه پالاز */

.card-header[data-bs-toggle="collapse"]{
    display:flex;
    justify-content:space-between;
    align-items:center;
    cursor:pointer;
}


.card-header[data-bs-toggle="collapse"]::after{

    content:"\f104";

    font-family:"Font Awesome 5 Free";

    font-weight:900;

    font-size:14px;

    color:#999;

    transition:.3s;

}



/* وقتی باز شد */

.card-header[data-bs-toggle="collapse"][aria-expanded="true"]::after{

    transform:rotate(-90deg);

    color:#555;

}
.arrow{

    font-size:18px;
    color:#999;
    transition:.3s;

    margin-right:auto; /* می‌فرستد سمت چپ */

}


.card-header[aria-expanded="true"] .arrow{

    transform:rotate(90deg);
    color:#555;

}
.btn-success,
.btn-primary,
.btn-secondary{
    min-width:140px;
    border-radius:8px;
    font-weight:600;
}
</style>
@endsection