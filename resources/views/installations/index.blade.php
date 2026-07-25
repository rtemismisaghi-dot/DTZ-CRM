@extends('layouts.app')

@section('content')

<style>

.page-title{
    font-size:28px;
    font-weight:800;
}

.page-subtitle{
    color:#888;
}

.installation-header{

    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;

}

.header-right h2{

    font-size:30px;
    font-weight:800;
    margin:0;

}

.header-right small{

    color:#888;

}


.header-left{

    display:flex;
    align-items:center;
    gap:12px;

}


.new-btn{

    height:46px;
    padding:0 24px;
    background:#d91f26;
    color:white;
    border:none;
    border-radius:14px;
    font-weight:700;

}


.notify-btn{

    width:46px;
    height:46px;
    background:white;
    border:none;
    border-radius:14px;
    box-shadow:0 3px 12px rgba(0,0,0,.08);
    position:relative;

}


.notify-dot{

    position:absolute;
    width:9px;
    height:9px;
    background:#d91f26;
    border-radius:50%;
    top:10px;
    right:10px;

}


/* Tabs */

.installation-tabs{

    display:flex;
    gap:0;
    border-bottom:1px solid #eee;
    margin-bottom:20px;
    overflow-x:auto;
    white-space:nowrap;

}


.installation-tabs .nav-link{

    border:none;
    background:none;
    padding:15px 22px;
    color:#777;
    font-weight:600;
    border-bottom:3px solid transparent;

}


.installation-tabs .nav-link.active{

    color:#222;
    border-bottom-color:#d91f26;

}


/* Filter */


.filter-card{

    background:#fff;
    border:1px solid #eee;
    border-radius:16px;
    padding:18px;
    margin-bottom:20px;

}


.form-control,
.form-select{

    height:44px;
    border-radius:12px;
    border:1px solid #e5e5e5;

}


.form-control:focus,
.form-select:focus{

    border-color:#d91f26;
    box-shadow:none;

}


/* Installation Row */


.installation-row{

    background:white;
    border:1px solid #eee;
    border-radius:16px;
    padding:18px 22px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:15px;

}


.installation-info{

    display:grid;
    grid-template-columns:repeat(4,minmax(150px,1fr));
    gap:25px;
    flex:1;

}


.info-column{

    display:flex;
    flex-direction:column;

}


.info-item{

    display:flex;
    gap:6px;

}


.info-label{

    color:#888;
    font-size:13px;

}


.info-value{

    font-weight:700;
    font-size:14px;

}


.tracking-code{

    font-weight:700;
    font-size:13px;

}


/* Actions */


.installation-actions{

    display:flex;
    gap:8px;
    margin-right:20px;

}


.btn-view{

    background:#202020;
    color:white;
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;

}


.btn-light2{

    border:1px solid #ddd;
    background:white;
    padding:10px 14px;
    border-radius:10px;

}


.btn-delete{

    width:42px;
    height:42px;
    border:none;
    background:#dc3545;
    color:white;
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

</style>


<div class="container-fluid py-4 w-100">

<div class="installation-header">


<div class="header-right">

<h2>
نصب‌ها
</h2>

<small>
مدیریت فرآیند نصب مشتریان
</small>


</div>



<div class="header-left">


<button class="new-btn"
data-bs-toggle="modal"
data-bs-target="#productModal">

<i class="bi bi-plus-lg"></i>

ایجاد نصب جدید

</button>


<button class="notify-btn">

<i class="bi bi-bell-fill"></i>

<span class="notify-dot"></span>

</button>


</div>


</div>

{{-- ================= STATUS TABS ================= --}}

<ul class="nav installation-tabs">


<li class="nav-item">
<a class="nav-link active">
ایجاد شده
<span class="badge bg-light text-dark">
{{ $installations->where('status','created')->count() }}
</span>
</a>
</li>


<li class="nav-item">
<a class="nav-link">
تعیین وقت
<span class="badge bg-light text-dark">
{{ $installations->where('status','scheduled')->count() }}
</span>
</a>
</li>


<li class="nav-item">
<a class="nav-link">
آماده نصب
<span class="badge bg-light text-dark">
{{ $installations->where('status','ready_install')->count() }}
</span>
</a>
</li>


<li class="nav-item">
<a class="nav-link">
در حال نصب
<span class="badge bg-light text-dark">
{{ $installations->where('status','installing')->count() }}
</span>
</a>
</li>


<li class="nav-item">
<a class="nav-link">
نیاز به بررسی
<span class="badge bg-light text-dark">
{{ $installations->where('status','review')->count() }}
</span>
</a>
</li>


<li class="nav-item">
<a class="nav-link">
آماده تسویه شدن
<span class="badge bg-light text-dark">
{{ $installations->where('status','ready_payment')->count() }}
</span>
</a>
</li>


<li class="nav-item">
<a class="nav-link">
مانده نصب
<span class="badge bg-light text-dark">
{{ $installations->where('status','remaining')->count() }}
</span>
</a>
</li>


<li class="nav-item">
<a class="nav-link">
تمام شده
<span class="badge bg-light text-dark">
{{ $installations->where('status','completed')->count() }}
</span>
</a>
</li>


</ul>




{{-- ================= FILTER ================= --}}

<div class="filter-card">


<div class="row g-3">


<div class="col-lg-4">

<input type="text"
class="form-control"
placeholder="جستجوی نام یا شماره مشتری">


</div>



<div class="col-lg-3">

<select class="form-select">

<option>
نام نصاب
</option>

</select>


</div>




<div class="col-lg-3">

<input type="date"
class="form-control">

</div>




<div class="col-lg-2">

<select class="form-select">

<option>
نوع نصب
</option>


<option>
موکت
</option>

<option>
چمن مصنوعی
</option>

<option>
لمینت
</option>

<option>
کاغذ دیواری
</option>


</select>

</div>


</div>


</div>





{{-- ================= INSTALLATION LIST ================= --}}


@forelse($installations as $installation)


<div class="installation-row">



<div class="installation-info">



{{-- مشتری --}}

<div class="info-column">


<div class="info-item">

<span class="info-label">
نام :
</span>


<span class="info-value">

{{ $installation->customer->name ?? '-' }}

</span>


</div>



<div class="info-item mt-3">

<span class="info-label">
نوع :
</span>


<span class="info-value">

{{ $installation->installation_type }}

</span>


</div>


</div>





{{-- تماس --}}


<div class="info-column">


<div class="info-item">


<span class="info-label">
همراه :
</span>


<span class="info-value">

{{ $installation->customer->mobile ?? '-' }}

</span>


</div>



<div class="info-item mt-3">


<span class="info-label">
تاریخ :
</span>



<span class="info-value">


@if(function_exists('verta'))

{{ verta($installation->created_at)->format('Y/m/d') }}

@else

{{ $installation->created_at?->format('Y/m/d') }}

@endif


</span>


</div>



</div>





{{-- مبلغ --}}


<div class="info-column">


<div class="info-item">


<span class="info-label">
مبلغ :
</span>


<span class="info-value">

{{ number_format($installation->amount ?? 0) }}

تومان

</span>


</div>




<div class="info-item mt-3">


<span class="info-label">
وضعیت :
</span>


<span class="badge bg-success">

{{ $installation->status ?? 'ایجاد شده' }}

</span>


</div>


</div>






{{-- پیگیری --}}


<div class="info-column">


<div class="info-label">

کد پیگیری

</div>


<div class="tracking-code">

{{ $installation->tracking_code }}

</div>


</div>



</div>





{{-- ACTIONS --}}


<div class="installation-actions">

<a href="{{ route('installations.prepare',$installation->id) }}"
class="btn-view">
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



</div>


@empty

<div class="text-center py-5">
<h5 class="text-muted">
هنوز نصبی ثبت نشده است.
</h5>
</div>

@endforelse


</div> {{-- پایان container-fluid --}}
{{-- ================= PRODUCT MODAL ================= --}}

<div class="modal fade" id="productModal" tabindex="-1">

<div class="modal-dialog modal-xl modal-dialog-centered">

<div class="modal-content palaz-modal">


<div class="modal-header">

<h4 class="mb-0">
انتخاب نوع نصب
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

لمینت

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





{{-- ================= INSTALLATION MODAL ================= --}}


<div class="modal fade" id="installationModal" tabindex="-1">


<div class="modal-dialog modal-xl modal-dialog-centered">


<div class="modal-content palaz-modal">



<form action="{{ route('installations.store') }}"
method="POST">


@csrf



<input type="hidden"
name="installation_type"
id="installation_type">





<div class="modal-header">


<h5 class="mb-0">

ثبت اطلاعات نصب

</h5>



<button type="button"
class="btn-close"
data-bs-dismiss="modal">

</button>


</div>





<div class="modal-body">



{{-- اطلاعات مشتری --}}


<div class="row g-3 mb-4">


<div class="col-md-4">

<input class="form-control"
name="name"
placeholder="نام مشتری">

</div>


<div class="col-md-4">

<input class="form-control"
name="phone"
placeholder="شماره تماس">

</div>


<div class="col-md-4">

<input class="form-control"
name="national_code"
placeholder="کد ملی">

</div>


</div>





{{-- تنظیمات نصب --}}


<div class="row">


<div class="col-lg-8">



<div class="mb-4">


<label class="fw-bold mb-3">

نحوه تعیین آدرس

</label>


<div class="d-flex gap-5">


<label>

<input type="radio"
name="location_type"
value="customer">

توسط مشتری

</label>



<label>

<input type="radio"
name="location_type"
value="staff">

توسط پرسنل

</label>


</div>


</div>





<div class="mb-4">


<label class="fw-bold mb-3">

نحوه امضای قوانین

</label>



<div class="d-flex gap-5">


<label>

<input type="radio"
name="sign_type"
value="online">

آنلاین

</label>



<label>

<input type="radio"
name="sign_type"
value="offline">

آفلاین

</label>



</div>


</div>





<div class="mb-4">


<label class="fw-bold mb-3">

نحوه پرداخت

</label>


<div class="d-flex gap-5">


<label>

<input type="radio"
name="payment_type"
value="online">

آنلاین

</label>



<label>

<input type="radio"
name="payment_type"
value="offline">

آفلاین

</label>



</div>


</div>



</div>



</div>



</div>




<div class="modal-footer">


<button class="btn btn-dark rounded-pill px-5">

تکمیل فرآیند

</button>


</div>




</form>


</div>


</div>


</div>






<script>


document.querySelectorAll('.product-card')
.forEach(function(card){


card.addEventListener('click',function(){



document.getElementById('installation_type').value =
this.dataset.type;




let productModal =
bootstrap.Modal.getInstance(
document.getElementById('productModal')
);



productModal.hide();





document.getElementById('productModal')
.addEventListener('hidden.bs.modal',function handler(){



this.removeEventListener(
'hidden.bs.modal',
handler
);



let installationModal =
new bootstrap.Modal(
document.getElementById('installationModal')
);



installationModal.show();



});



});



});



</script>



@endsection
