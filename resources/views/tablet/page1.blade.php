<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DTZ Tablet</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

<link href="{{ asset('tablet/css/dtz-tablet.css') }}" rel="stylesheet">

</head>


<body>


<div class="tablet-container">


<div class="page-card">


<!-- Header -->

<div class="dtz-header text-center py-3">

<img
src="{{ asset('images/logo.png') }}"
alt="DTZ"
class="logo"
style="height:60px">


</div>





<!-- اطلاعات مشتری -->

<div class="dtz-card">


<div class="dtz-title">
اطلاعات مشتری
</div>



<div class="row g-4">



<div class="col-md-6">

<label class="dtz-label">
موبایل اصلی
</label>


<input
type="text"
class="form-control dtz-input"
placeholder="0912xxxxxxx">


</div>




<div class="col-md-6">

<label class="dtz-label">
نام و نام خانوادگی
</label>


<input
type="text"
class="form-control dtz-input">


</div>




<div class="col-md-6">

<label class="dtz-label">
کد ملی
</label>


<input
type="text"
class="form-control dtz-input">


</div>




<div class="col-md-6">

<label class="dtz-label">
موبایل دوم
</label>


<input
type="text"
class="form-control dtz-input">


</div>




<div class="col-12">

<label class="dtz-label">
آدرس
</label>


<textarea
rows="4"
class="form-control dtz-textarea"></textarea>


</div>



</div>


</div>







<!-- اطلاعات پروژه -->

<div class="dtz-card mt-4">


<div class="dtz-title">

اطلاعات پروژه

</div>



<div class="row g-4">



<div class="col-md-6">


<label class="dtz-label">

نوع محصول

</label>



<select
id="product_type"
class="form-select dtz-input">


<option value="">

انتخاب کنید

</option>


<option value="carpet">

موکت

</option>


<option value="laminate">

لمینت

</option>


<option value="wallpaper">

کاغذ دیواری

</option>


<option value="grass">

چمن مصنوعی

</option>


<option value="tile">

موکت تایل

</option>


<option value="other">

سایر

</option>



</select>


</div>







<div
class="col-md-6 d-none"
id="otherProductBox">


<label class="dtz-label">

عنوان محصول

</label>


<input
type="text"
class="form-control dtz-input"
placeholder="نام محصول">


</div>







<div class="col-12">


<div class="form-check form-switch fs-5">


<input
class="form-check-input"
type="checkbox"
id="need_measurement"
name="need_measurement">



<label
class="form-check-label me-2"
for="need_measurement">


نیاز به اندازه گیری


</label>



</div>


</div>



</div>


</div>







<!-- دکمه ادامه -->


<div class="mt-4">


<a href="javascript:void(0)"
onclick="goNext()"
class="dtz-btn w-100 text-center d-block">


ادامه


</a>


</div>






</div>


</div>






<script>


document
.getElementById('product_type')
.addEventListener('change', function () {


document
.getElementById('otherProductBox')
.classList
.toggle('d-none', this.value !== 'other');


});
function goNext(){


let product =
document.getElementById('product_type').value;


let needMeasurement =
document.getElementById('need_measurement').checked;



if(product === ""){


alert("لطفاً نوع محصول را انتخاب کنید");


return;


}




if(needMeasurement){


alert("بخش اندازه گیری هنوز فعال نشده است");


return;


}




window.location.href =

"{{ route('tablet.plan') }}?product=" + product;



}



</script>



</body>

</html>