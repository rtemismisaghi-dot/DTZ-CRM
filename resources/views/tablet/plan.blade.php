```html
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DTZ Tablet - Carpet Plan</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.rtl.min.css"
        rel="stylesheet">

    <link
        href="{{ asset('tablet/css/dtz-tablet.css') }}"
        rel="stylesheet">

</head>


<body>


<div class="tablet-container">


    <div class="page-card">


        <!-- HEADER -->

        <div class="dtz-header text-center py-3">

            <img
                src="{{ asset('images/logo.png') }}"
                style="height:60px">

            <h4 class="fw-bold mt-3">

                {{ $title }}

            </h4>

            <div class="text-muted">

                پروژه DTZ

            </div>

        </div>

<!-- CARPET SELECTION -->

<div class="dtz-card mt-3">

    <h5 class="fw-bold mb-3">
        مشخصات موکت
    </h5>

    <!-- مدل موکت -->

    <div class="mb-3">

        <label
            for="carpetModelSelect"
            class="dtz-label">

            مدل موکت

        </label>

        <select
            id="carpetModelSelect"
            class="form-select dtz-input">

            <option value="">
                انتخاب مدل موکت
            </option>

            @foreach($carpetModels as $carpetModel)

                <option
                    value="{{ $carpetModel->id }}"
                    data-codes='@json($carpetModel->codes)'>

                    {{ $carpetModel->model_name }}

                </option>

            @endforeach

        </select>

    </div>


    <!-- کد موکت -->

    <div>

        <label
            for="carpetCodeSelect"
            class="dtz-label">

            کد موکت

        </label>

        <select
            id="carpetCodeSelect"
            class="form-select dtz-input"
            disabled>

            <option value="">
                ابتدا مدل موکت را انتخاب کنید
            </option>

        </select>

    </div>

</div>

        <!-- ADD SPACE -->

        <div class="dtz-card mt-3">

            <button
                type="button"
                class="dtz-btn w-100"
                data-bs-toggle="modal"
                data-bs-target="#spaceModal">

                + افزودن فضا

            </button>

        </div>



        <!-- SAVED SPACES -->

        <div class="dtz-card mt-4">

            <h5 class="fw-bold">

                فضاهای ثبت شده

            </h5>


            @if(count($spaces))


                @foreach($spaces as $space)


                    <div class="alert alert-light shadow-sm rounded-4 mt-3">


                        <!-- SPACE HEADER -->

                        <div class="d-flex justify-content-between align-items-center">


                            <div class="fw-bold">

                                {{ $space->name }}

                            </div>



                            <form
                                method="POST"
                                action="{{ route('tablet.space.destroy', $space->id) }}"
                                onsubmit="return confirm('حذف این فضا انجام شود؟')">

                                @csrf

                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm rounded-4">

                                    حذف

                                </button>

                            </form>


                        </div>



                        <!-- AREA -->

                        @if($space->area)

                            <div class="text-muted mt-3">

                                متراژ:

                                {{ $space->area }}

                                متر مربع

                            </div>

                        @endif



                        <!-- ROLL -->

                     @if($space->roll)

    @php
        $rolls = json_decode($space->roll, true);
    @endphp

    <div class="text-muted mt-2">

        طاقه:

        @if(is_array($rolls))

            {{ collect($rolls)->pluck('size')->implode(' + ') }}

        @else

            {{ $space->roll }}

        @endif

    </div>

    <div class="text-muted">

        تعداد:

        {{ $space->roll_count }}

    </div>

@endif



                        <!-- CARPET MODEL -->

                        @if($space->carpetModel)

                            <div class="text-muted mt-2">

                                مدل موکت:

                                {{ $space->carpetModel->model_name }}

                            </div>

                        @endif



                        <!-- CARPET CODE -->

                        @if($space->carpetCode)

                            <div class="text-muted">

                                کد موکت:

                                {{ $space->carpetCode->code }}

                            </div>

                        @endif


                    </div>


                @endforeach


            @else


                <div class="text-center text-muted py-4">

                    هنوز فضایی ثبت نشده

                </div>


            @endif


        </div>


    </div>


</div>





<!-- SPACE MODAL -->

<div
    class="modal fade"
    id="spaceModal"
    tabindex="-1"
    aria-hidden="true">


    <div
        class="modal-dialog modal-dialog-centered modal-dialog-scrollable">


        <div class="modal-content rounded-4">


            <!-- MODAL HEADER -->

            <div class="modal-header">


                <h5 class="modal-title fw-bold">

                    انتخاب فضا

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="بستن">

                </button>


            </div>



            <!-- MODAL BODY -->

            <div class="modal-body">


                <!-- SEARCH -->

                <input
                    type="text"
                    id="spaceSearch"
                    class="form-control mb-3"
                    placeholder="جستجوی فضا">



                @php

                    $spaceList = [

                        'پذیرایی',
                        'آشپزخانه',
                        'اتاق خواب',
                        'انباری',
                        'راهرو',
                        'سالن',
                        'اتاق مدیریت',
                        'اتاق کار',
                        'لابی',
                        'مستر',
                        'بالکن',
                        'سرویس',
                        'اتاق مهمان',
                        'اتاق کودک',
                        'اتاق بازی',
                        'دفتر کار'

                    ];

                @endphp



                <!-- SPACE LIST -->

                <div
                    class="space-list"
                    id="spaceList">


                    @foreach($spaceList as $spaceName)


                        <a
                            href="#"
                            onclick="openSpace('{{ $spaceName }}'); return false;"
                            class="btn btn-outline-dark w-100 mb-2 rounded-4 text-start p-3 space-item">

                            {{ $spaceName }}

                        </a>


                    @endforeach


                </div>


            </div>


        </div>


    </div>


</div>





<!-- BOOTSTRAP -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>



<script>


/*
|--------------------------------------------------------------------------
| OPEN SPACE
|--------------------------------------------------------------------------
*/

// ==========================================
// انتخاب مدل و کد موکت
// ==========================================

const carpetModelSelect =
    document.getElementById('carpetModelSelect');

const carpetCodeSelect =
    document.getElementById('carpetCodeSelect');


function loadCarpetCodes(modelId, selectedCode = null) {

    carpetCodeSelect.innerHTML =
        '<option value="">انتخاب کد موکت</option>';

    carpetCodeSelect.disabled = true;


    if (!modelId) {

        carpetCodeSelect.innerHTML =
            '<option value="">ابتدا مدل موکت را انتخاب کنید</option>';

        return;
    }


    const modelOption =
        carpetModelSelect.querySelector(
            'option[value="' + modelId + '"]'
        );


    if (!modelOption) {
        return;
    }


    let codes = [];

    try {

        codes =
            JSON.parse(
                modelOption.dataset.codes || '[]'
            );

    } catch (error) {

        console.error(
            'خطا در خواندن کدهای موکت:',
            error
        );

        return;
    }


    codes.forEach(function(code) {

        const option =
            document.createElement('option');

        option.value = code.id;

        option.textContent = code.code;

        carpetCodeSelect.appendChild(option);

    });


    carpetCodeSelect.disabled =
        codes.length === 0;


    if (selectedCode) {

        carpetCodeSelect.value =
            selectedCode;

    }

}


// ==========================================
// تغییر مدل
// ==========================================

carpetModelSelect.addEventListener(
    'change',
    function() {

        const modelId = this.value;


        if (!modelId) {

            sessionStorage.removeItem(
                'carpet_model_id'
            );

            sessionStorage.removeItem(
                'carpet_code_id'
            );

            loadCarpetCodes(null);

            return;
        }


        sessionStorage.setItem(
            'carpet_model_id',
            modelId
        );


        // با تغییر مدل، کد قبلی دیگر معتبر نیست

        sessionStorage.removeItem(
            'carpet_code_id'
        );


        loadCarpetCodes(modelId);

    }
);


// ==========================================
// تغییر کد
// ==========================================

carpetCodeSelect.addEventListener(
    'change',
    function() {

        const codeId = this.value;


        if (!codeId) {

            sessionStorage.removeItem(
                'carpet_code_id'
            );

            return;
        }


        sessionStorage.setItem(
            'carpet_code_id',
            codeId
        );

    }
);


// ==========================================
// بازیابی انتخاب قبلی
// ==========================================

const savedModel =
    sessionStorage.getItem(
        'carpet_model_id'
    );

const savedCode =
    sessionStorage.getItem(
        'carpet_code_id'
    );


if (savedModel) {

    carpetModelSelect.value =
        savedModel;

    loadCarpetCodes(
        savedModel,
        savedCode
    );

}
function openSpace(spaceName) {


    /*
    |--------------------------------------------------------------------------
    | دریافت مدل و کد موکت از Session Storage
    |--------------------------------------------------------------------------
    */

    let model =
        sessionStorage.getItem('carpet_model_id');


    let code =
        sessionStorage.getItem('carpet_code_id');



    /*
    |--------------------------------------------------------------------------
    | بررسی مدل
    |--------------------------------------------------------------------------
    */

    if (!model) {

        alert('ابتدا مدل موکت را انتخاب کنید.');

        return;

    }



    /*
    |--------------------------------------------------------------------------
    | بررسی کد
    |--------------------------------------------------------------------------
    */

    if (!code) {

        alert('ابتدا کد موکت را انتخاب کنید.');

        return;

    }



    /*
    |--------------------------------------------------------------------------
    | ساخت آدرس صفحه فضای جدید
    |--------------------------------------------------------------------------
    */

    let url =
        "{{ route('tablet.space.create') }}"
        + "?space="
        + encodeURIComponent(spaceName)
        + "&model="
        + encodeURIComponent(model)
        + "&code="
        + encodeURIComponent(code);



    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    */

    console.log("SPACE DATA:", {

        space: spaceName,

        model: model,

        code: code

    });



    /*
    |--------------------------------------------------------------------------
    | انتقال
    |--------------------------------------------------------------------------
    */

    window.location.href = url;

}





/*
|--------------------------------------------------------------------------
| SEARCH SPACE
|--------------------------------------------------------------------------
*/

document
    .getElementById('spaceSearch')
    .addEventListener('input', function () {


        let search =
            this.value.trim().toLowerCase();


        let items =
            document.querySelectorAll('.space-item');



        items.forEach(function (item) {


            let name =
                item.textContent.trim().toLowerCase();


            if (name.includes(search)) {

                item.style.display = '';

            } else {

                item.style.display = 'none';

            }

        });


    });


</script>


</body>

</html>
```
