@extends('layouts.app')

@section('content')

<style>

.page-title{
    font-size:28px;
    font-weight:700;
}

.page-subtitle{
    color:#888;
}

.filter-card{
       background:#fff;

    border:1px solid #ececec;

    border-radius:14px;

    padding:18px;

    margin-bottom:18px;
}
.filter-card .form-control,
.filter-card .form-select{

    height:42px;

    border-radius:10px;

    border:1px solid #e3e3e3;

    font-size:14px;

}

.filter-card .btn-search{

    height:42px;

    border-radius:10px;

    background:#d91f26;

    color:#fff;

    border:none;

    width:100%;

}

.measurement-card{

    background:#fff;
    border:1px solid #ececec;
    border-radius:16px;
    padding:20px 22px;
    margin-bottom:18px;
    transition:.2s;
    box-shadow:0 2px 8px rgba(0,0,0,.04);

}

.measurement-card:hover{

    box-shadow:0 8px 20px rgba(0,0,0,.08);

}

.info-label{

    font-size:14px;

    color:#777;

    min-width:52px;

    font-weight:500;

}

.info-value{

    font-size:14px;

    font-weight:600;

    color:#222;

}

.tracking-code{

    font-size:13px;

    font-weight:700;

    line-height:24px;

    word-break:break-all;

}
.action-btn{

    border-radius:10px;

}

.title-label{
    font-size:13px;
    color:#888;
    margin-bottom:4px;
}

.value-text{
    font-size:15px;
    font-weight:700;
}

.measurement-tabs{

    display:flex;
    align-items:center;
    gap:0;
    border-bottom:1px solid #ededed;
    margin-bottom:22px;
    overflow-x:auto;
    white-space:nowrap;

}

.measurement-tabs .nav-item{

    margin:0;

}

.measurement-tabs .nav-link{

    padding:15px 22px;
    color:#6b6b6b;
    font-size:14px;
    font-weight:600;
    border:none;
    border-bottom:3px solid transparent;
    background:transparent;
    border-radius:0;

}

.measurement-tabs .nav-link:hover{

    color:#111;

}

.measurement-tabs .nav-link.active{

    color:#111;
    border-bottom-color:#d91f26;
    background:transparent;

}
.measurement-row{

    background:#fff;
    border:1px solid #ececec;
    border-radius:14px;
    padding:18px 22px;
    margin-bottom:14px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    transition:.2s;

}

.measurement-row:hover{

    border-color:#ddd;
    box-shadow:0 8px 18px rgba(0,0,0,.05);

}

.measurement-info{

    display:grid;

    grid-template-columns:repeat(4,minmax(150px,1fr));

    gap:20px;

    flex:1;

    min-width:0;

}
.measurement-row{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    gap:20px;

}
.info-column{

    display:flex;

    flex-direction:column;

}

.item-title{

    font-size:12px;
    color:#999;
    margin-bottom:5px;

}

.item-value{

    font-weight:700;
    color:#222;

}

.measurement-actions{

    width:150px;

    min-width:150px;

    display:flex;

    flex-direction:column;

    gap:8px;

    justify-content:flex-start;

}
.measurement-actions .btn-view,
.measurement-actions .btn-light2{

    width:100%;
    height:40px;
    display:flex;
    align-items:center;
    justify-content:center;

}
.btn-view{

    background:#212529;
    color:#fff;
    border:none;
    border-radius:10px;
    padding:8px 18px;

}

.btn-light2{

    background:#fff;
    border:1px solid #ddd;
    border-radius:10px;
    padding:8px 14px;

}

.btn-delete{

    width:42px;
    height:42px;
    border:none;
    background:#dc3545;
    color:#fff;
    border-radius:10px;

}

/* ================= MODAL ================= */

.palaz-modal{
    border:0;
    border-radius:24px;
    overflow:hidden;
}

.palaz-modal .modal-header{
    padding:22px 30px;
}

.palaz-modal .modal-body{
    padding:30px;
}

.section-title{
    font-size:18px;
    font-weight:700;
    margin-bottom:18px;
}

.product-card{

    cursor:pointer;
    border:2px solid #eee;
    border-radius:18px;
    overflow:hidden;
    transition:.25s;
    background:#fff;

}

.product-card:hover{

    border-color:#bf0811;
    transform:translateY(-4px);

}

.product-card.active{

    border-color:#bf0811;
    box-shadow:0 10px 30px rgba(191,8,17,.18);

}

.product-card img{

    width:100%;
    height:180px;
    object-fit:cover;

}

.product-title{

    padding:16px;
    text-align:center;
    font-weight:700;

}

.radio-row{
    display:flex;
    align-items:center;
    margin-bottom:18px;
}

.radio-title{
      width:240px;
    min-width:240px;
    font-weight:700;
    color:#444;
}

.radio-options{
    display:flex;
    align-items:center;
    gap:50px;
}

.radio-item{
    display:flex;
    align-items:center;
    gap:6px;
    margin:0;
}

.radio-item input{
    width:18px;
    height:18px;
}
.form-control,
.form-select{

    border-radius:12px;
    height:46px;
    border:1px solid #e7e7e7;
    box-shadow:none;

}

.form-control:focus,
.form-select:focus{

    border-color:#bf0811;
    box-shadow:none;

}

.form-label{

    font-size:13px;
    margin-bottom:8px;
    color:#555;

}
.measurement-header{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:28px;

}

.header-left{

   
    display:flex;
    align-items:center;
    gap:12px;

}

.header-right{


    text-align:right;

}

.header-right h2{

font-size:30px;

font-weight:800;

margin:0;

}

.header-right small{

color:#8d8d8d;

}

.notify-btn{

    width:46px;
    height:46px;
    border:none;
    background:#fff;
    border-radius:14px;
    box-shadow:0 3px 12px rgba(0,0,0,.08);
    position:relative;
    display:flex;
    justify-content:center;
    align-items:center;
    color:#555;

}

.notify-btn span{
    width:8px;
    height:8px;
    background:#e71c2b;
    border-radius:50%;
    position:absolute;
    top:10px;
    left:10px;
}

.notify-btn i{
    font-size:18px;
}

.notify-dot{
    position:absolute;
    top:10px;
    right:10px;
    width:9px;
    height:9px;
    background:#e41e2b;
    border:2px solid #fff;
    border-radius:50%;
}

.new-btn{

    height:46px;
    padding:0 22px;
    border:none;
    background:#d71e28;
    color:#fff;
    font-weight:700;
    border-radius:14px;
    display:flex;
    align-items:center;
    gap:8px;

}
.measurement-row{

    display:flex;
    justify-content:space-between;
    align-items:center;

    background:#fff;

    border:1px solid #ececec;

    border-radius:14px;

    padding:18px 22px;

    margin-bottom:14px;

}

.measurement-info{

    display:grid;

    grid-template-columns:repeat(4,minmax(150px,1fr));

    gap:20px;

    flex:1;

}

.info-item{

     display:flex;

    align-items:center;

    gap:6px;

}

.item-title{

    font-size:12px;

    color:#9a9a9a;

    margin-bottom:4px;

}

.item-value{

    font-weight:700;

    color:#222;

}

.measurement-actions{

    width:auto;
    min-width:auto;

    display:flex;

    flex-direction:row;

    align-items:center;

    gap:8px;

    margin-right:20px;

}
.measurement-actions .btn,
.measurement-actions a{

    width:100%;

}
.btn-view{

    background:#202020;

    color:#fff;

    padding:8px 18px;

    border-radius:10px;

    text-decoration:none;

}

.btn-light2{

    white-space:nowrap;

    height:40px;

    display:flex;

    align-items:center;

    justify-content:center;

}

.btn-delete{

    width:100% !important;

    height:40px;

}
</style>

<div class="container-fluid py-4">
<div class="measurement-header">

    <div class="header-right">

        <h2 class="mb-1">اندازه گیری</h2>

        <div class="page-subtitle">
            
        </div>

    </div>

    <div class="header-left">

        <button
            class="new-btn"
            data-bs-toggle="modal"
            data-bs-target="#productModal">

            <i class="bi bi-plus-lg me-2"></i>

            ایجاد اندازه گیری جدید

        </button>

        <button class="notify-btn">

            <i class="bi bi-bell-fill"></i>

            <span class="notify-dot"></span>

        </button>

    </div>

</div>

</div>
<ul class="nav measurement-tabs">

<li class="nav-item">
<a class="nav-link active">
ایجاد شده
</a>
</li>

<li class="nav-item">
<a class="nav-link">
تعیین وقت
</a>
</li>

<li class="nav-item">
<a class="nav-link">
آماده اندازه گیری
</a>
</li>

<li class="nav-item">
<a class="nav-link">
در حال اندازه گیری
</a>
</li>

<li class="nav-item">
<a class="nav-link">
تمام شده
</a>
</li>

<li class="nav-item">
<a class="nav-link">
آماده برای فاکتور
</a>
</li>

<li class="nav-item">
<a class="nav-link">
بایگانی
</a>
</li>

</ul>

<div class="filter-card">

    <div class="row g-3">

        <div class="col-lg-4">

            <input
                class="form-control"
                placeholder="جستجوی نام و شماره مشتری">

        </div>


        <div class="col-lg-3">

            <select class="form-select">

                <option>
                    نام نصاب
                </option>

            </select>

        </div>


        <div class="col-lg-3">

            <input
                type="date"
                class="form-control"
                placeholder="تاریخ اندازه گیری">

        </div>


        <div class="col-lg-2">

            <select class="form-select">

                <option>
                    نوع اندازه گیری
                </option>

            </select>

        </div>

    </div>

</div>
@forelse($measurements as $measurement)


<div class="measurement-row">

    <div class="measurement-info">

    {{-- ستون اول --}}
    <div class="info-column">

        <div class="info-item">
            <span class="info-label">نام :</span>
            <span class="info-value">{{ $measurement->customer->name ?? '-' }}</span>
        </div>

        <div class="info-item mt-3">
            <span class="info-label">نوع :</span>
            <span class="info-value">{{ $measurement->measurement_type }}</span>
        </div>

    </div>

    {{-- ستون دوم --}}
    <div class="info-column">

        <div class="info-item">
            <span class="info-label">همراه :</span>
            <span class="info-value">{{ $measurement->customer->mobile ?? '-' }}</span>
        </div>

        <div class="info-item mt-3">
            <span class="info-label">تاریخ :</span>
            <span class="info-value">

                @if(function_exists('verta'))
                    {{ verta($measurement->created_at)->format('Y/m/d') }}
                @else
                    {{ $measurement->created_at?->format('Y/m/d') }}
                @endif

            </span>
        </div>

    </div>

    {{-- ستون سوم --}}
    <div class="info-column">

        <div class="info-item">
            <span class="info-label">مبلغ :</span>
            <span class="info-value">
                {{ number_format($measurement->amount ?? 0) }}
            </span>
        </div>

        <div class="info-item mt-3">
            <span class="info-label">وضعیت :</span>

            <span class="badge bg-success rounded-pill">
                {{ $measurement->payment_status ?? 'در انتظار' }}
            </span>

        </div>

    </div>

    {{-- ستون چهارم --}}
    <div class="info-column">

        <div class="info-label mb-2">

            پیگیری :

        </div>

        <div class="tracking-code">

            {{ $measurement->tracking_code }}

        </div>

    </div>

</div>
<div class="measurement-actions">

    <a href="{{ route('measurements.show',$measurement) }}"
       class="btn-view text-center">
        مشاهده
    </a>

    <button class="btn-light2">
        پیام فروش
    </button>

    <button class="btn-light2">
        پیام نصب
    </button>

    <button class="btn-delete">
        <i class="bi bi-trash"></i>
    </button>

</div>

</div> {{-- پایان measurement-row --}}
@empty

<div class="text-center py-5">

    <h5 class="text-muted">

        هنوز اندازه گیری ثبت نشده است.

    </h5>

</div>

@endforelse

</div>

</div>
{{-- ================= PRODUCT MODAL ================= --}}

<div class="modal fade" id="productModal" tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content palaz-modal">

            <div class="modal-header">

                <h4 class="mb-0">
                    انتخاب نوع اندازه‌گیری
                </h4>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="row g-4">

                    <div class="col-md-4">

                        <div class="product-card"
                             data-type="carpet">

                            <img src="{{ asset('images/carpet.jpg') }}"
                                 class="img-fluid">

                            <div class="product-title">
                                موکت
                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="product-card"
                             data-type="grass">

                            <img src="{{ asset('images/grass.jpg') }}"
                                 class="img-fluid">

                            <div class="product-title">
                                چمن مصنوعی
                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="product-card"
                             data-type="tile">

                            <img src="{{ asset('images/tile.jpg') }}"
                                 class="img-fluid">

                            <div class="product-title">
                                موکت تایل
                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="product-card"
                             data-type="laminate">

                            <img src="{{ asset('images/laminate.jpg') }}"
                                 class="img-fluid">

                            <div class="product-title">
                                لمینیت
                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="product-card"
                             data-type="wallpaper">

                            <img src="{{ asset('images/wallpaper.jpg') }}"
                                 class="img-fluid">

                            <div class="product-title">
                                کاغذ دیواری
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
{{-- ================= MEASUREMENT MODAL ================= --}}
<div class="modal fade" id="measurementModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content palaz-modal">

            <form action="{{ route('measurements.store') }}" method="POST">
                @csrf

                <input type="hidden" id="measurement_type" name="measurement_type">

                <div class="modal-header">
                    <h5 class="mb-0">ثبت اطلاعات اندازه‌گیری</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- مشتری --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <input class="form-control" name="name" placeholder="نام و نام خانوادگی">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" name="phone" placeholder="شماره تماس">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" name="national_code" placeholder="کد ملی">
                        </div>
                    </div>

                    <div class="row">

                        {{-- چپ --}}
                        <div class="col-lg-8">

    {{-- نوع اندازه گیری --}}
    <div class="radio-row">

        <div class="radio-title">
             وارد کردن لوکیشن
        </div>

        <div class="radio-options">

            <label class="radio-item">
                <input type="radio" name="measurement_by" value="customer">
                توسط مشتری
            </label>

            <label class="radio-item">
                <input type="radio" name="measurement_by" value="staff">
                توسط پرسنل
            </label>

        </div>

    </div>

    {{-- امضا --}}
    <div class="radio-row">

        <div class="radio-title">
            نحوه امضای قوانین
        </div>

        <div class="radio-options">

            <label class="radio-item">
                <input type="radio" name="sign_type" value="online">
                آنلاین
            </label>

            <label class="radio-item">
                <input type="radio" name="sign_type" value="offline">
                آفلاین
            </label>

        </div>

    </div>

    {{-- پرداخت --}}
    <div class="radio-row">

        <div class="radio-title">
            نحوه پرداخت
        </div>

        <div class="radio-options">

            <label class="radio-item">
                <input type="radio" name="payment_type" value="online">
                آنلاین
            </label>

            <label class="radio-item">
                <input type="radio" name="payment_type" value="offline">
                آفلاین
            </label>

        </div>

    </div>

    {{-- اندازه گیری رایگان --}}
    <div class="form-check mt-4">

        <input class="form-check-input"
               type="checkbox"
               id="free_visit"
               name="free_visit">

        <label class="form-check-label" for="free_visit">
            اندازه گیری رایگان
        </label>

    </div>

</div>
                        {{-- راست (خالی طبق UI فعلی) --}}
                        <div class="col-lg-4"></div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-dark rounded-pill px-4">
                        تکمیل فرآیند
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<script>
document.querySelectorAll('.product-card').forEach(function(card){

    card.addEventListener('click', function(){

        document.getElementById('measurement_type').value = this.dataset.type;

        let productModalEl = document.getElementById('productModal');
        let productModal = bootstrap.Modal.getInstance(productModalEl);

        productModal.hide();

        productModalEl.addEventListener('hidden.bs.modal', function handler(){

            productModalEl.removeEventListener('hidden.bs.modal', handler);

            let measurementModal = new bootstrap.Modal(
                document.getElementById('measurementModal')
            );

            measurementModal.show();

        });

    });

});
document.getElementById('measurementModal').addEventListener('hidden.bs.modal', function () {

    document.body.classList.remove('modal-open');

    document.body.style.removeProperty('padding-right');

    document.querySelectorAll('.modal-backdrop').forEach(function(el){
        el.remove();
    });

});
</script>
@endsection