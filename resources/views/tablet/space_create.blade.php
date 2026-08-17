<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
DTZ Tablet - Space
</title>


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


<div class="dtz-header text-center py-3">


<img

src="{{ asset('images/logo.png') }}"

style="height:60px"

alt="DTZ">


<h4 class="fw-bold mt-3">

رسم فضای جدید

</h4>


</div>



<!-- مدل و کد موکت -->

<div class="dtz-card mt-3">

    <h5 class="fw-bold mb-3">
        اطلاعات موکت
    </h5>

    <div class="mb-3">

        <label class="dtz-label">
            مدل موکت
        </label>

        <input
            type="text"
            class="form-control"
            value="{{ $carpetModel->model_name ?? '' }}"
            readonly>

    </div>


    <div>

        <label class="dtz-label">
            کد موکت
        </label>

        <input
            type="text"
            class="form-control"
            value="{{ $carpetCode->code ?? '' }}"
            readonly>

    </div>

</div>
<!-- نام فضا -->

<div class="dtz-card">


<label class="dtz-label">

نام فضا

</label>


<input

id="spaceNameText"

class="form-control"

value="{{ $space ?? '' }}"

readonly>


</div>





<!-- ابعاد -->

<div class="dtz-card mt-3">


<h5 class="fw-bold">

ابعاد فضا

</h5>



<div class="row g-3 mt-2">


<div class="col-6">


<label>

طول (متر)

</label>


<input

type="number"

step="0.1"

id="length"

class="form-control">

</div>




<div class="col-6">


<label>

عرض (متر)

</label>


<input

type="number"

step="0.1"

id="width"

class="form-control">

</div>


</div>



<div class="alert alert-info mt-3">


متراژ:

<strong>

<span id="area">

0

</span>

</strong>

متر مربع


</div>



</div>






<!-- پیشنهاد طاقه -->

<div class="dtz-card mt-3">


<h5 class="fw-bold">

پیشنهاد طاقه

</h5>


<div class="alert alert-warning">


سیستم:

<span id="suggestRoll">

-

</span>


</div>



<div class="alert alert-info">


برش:

<span id="cutInfo">

-

</span>


</div>




<div id="rollContainer"></div>




<button

type="button"

class="btn btn-outline-primary w-100 mt-3"

id="addRollBtn">


+ افزودن طاقه


</button>



<div class="alert alert-success mt-3">


پوشش طاقه:

<span id="rollArea">

0

</span>

متر مربع


</div>



</div>






<!-- Canvas -->

<div class="dtz-card mt-4">


<h5 class="fw-bold">

رسم پلان

</h5>



<canvas

id="planCanvas"

style="

width:100%;

height:450px;

border:2px solid #ddd;

border-radius:20px;

touch-action:none;

">


</canvas>

<button
    type="button"
    class="btn btn-success w-100 mt-3"
    id="finishIrregularBtn"
    style="display:none;">

    ✅ اتمام رسم فضا

</button>

<button

type="button"

class="btn btn-danger w-100 mt-3"

id="clearBtn">


🗑 پاک کردن نقشه


</button>

<!-- آپلود تصویر نقشه مشتری -->

<input
    type="file"
    id="planImageInput"
    accept="image/*"
    capture="environment"
    hidden
>

<button
    type="button"
    class="btn btn-primary w-100 mt-3"
    id="uploadPlanBtn">

    📷 آپلود تصویر نقشه مشتری

</button>



</div>






<!-- فرم ذخیره -->


<form

method="POST"

action="{{ route('tablet.space.store') }}">


@csrf



<input

type="hidden"

name="name"

id="hiddenName">
<input
type="hidden"
name="carpet_model_id"
value="{{ $model ?? '' }}">


<input
type="hidden"
name="carpet_code_id"
value="{{ $code ?? '' }}">



<input

type="hidden"

name="drawing"

id="hiddenDrawing">



<input

type="hidden"

name="roll"

id="hiddenRoll">



<input

type="hidden"

name="roll_count"

id="hiddenRollCount">



<input

type="hidden"

name="area"

id="hiddenArea">



<button

type="submit"

class="dtz-btn w-100 mt-4"

id="saveBtn">


ذخیره فضا


</button>



</form>



</div>

</div>
<script>


// ===============================
// DTZ CANVAS ENGINE
// ===============================


const canvas = document.getElementById("planCanvas");

const ctx = canvas.getContext("2d");


let drawing = false;

let startPoint = null;


let lines = [];
let dimensions = [];

let shapeConfirmed = false;
let irregularMode = false;
let polygonClosed = false;
let planImage = null;



// تنظیم اندازه Canvas

function resizeCanvas(){


    let box = canvas.getBoundingClientRect();


    canvas.width = box.width * window.devicePixelRatio;


    canvas.height = box.height * window.devicePixelRatio;


    ctx.scale(
        window.devicePixelRatio,
        window.devicePixelRatio
    );


    redrawCanvas();


}



window.addEventListener(
"resize",
resizeCanvas
);

// ==========================================
// رسم پلان DTZ
// ==========================================
// ==========================================
// شروع رسم پلان
// ==========================================


// شروع خط
canvas.addEventListener(
    "pointerdown",
    function(e){

        e.preventDefault();


        canvas.setPointerCapture(
            e.pointerId
        );


        let rect =
            canvas.getBoundingClientRect();


if(irregularMode && lines.length >= 2){

    // خط جدید همیشه از انتهای آخرین ضلع شروع می‌شود

    startPoint = {

        x: lines[lines.length - 1].x2,

        y: lines[lines.length - 1].y2

    };

}
else{

    startPoint = {

        x:
            e.clientX -
            rect.left,

        y:
            e.clientY -
            rect.top

    };

}

drawing = true;

    }
);



// حرکت قلم
canvas.addEventListener(
    "pointermove",
    function(e){

        if(!drawing)
            return;


        let rect =
            canvas.getBoundingClientRect();


        let currentPoint = {

            x:
                e.clientX -
                rect.left,

            y:
                e.clientY -
                rect.top

        };


        // نمایش خطوط قبلی
        redrawCanvas();


        // نمایش خط در حال رسم
        ctx.beginPath();


        ctx.moveTo(
            startPoint.x,
            startPoint.y
        );


        ctx.lineTo(
            currentPoint.x,
            currentPoint.y
        );


        ctx.strokeStyle =
            "black";


        ctx.lineWidth =
            4;


        ctx.lineCap =
            "round";


        ctx.stroke();

    }
);



// ==========================================
// پایان خط
// ==========================================

canvas.addEventListener(
    "pointerup",
    function(e){

        if(!drawing)
            return;


        let rect =
            canvas.getBoundingClientRect();


        let endPoint = {

            x:
                e.clientX -
                rect.left,

            y:
                e.clientY -
                rect.top

        };


        // ------------------------------
        // طول تصویری خط
        // ------------------------------

        let dx =
            endPoint.x -
            startPoint.x;


        let dy =
            endPoint.y -
            startPoint.y;


        let pixelLength =
            Math.sqrt(
                dx * dx +
                dy * dy
            );


        if(pixelLength < 10){

            drawing = false;

            redrawCanvas();

            return;

        }

// ==========================================
// تشخیص برگشت به نقطه شروع
// ==========================================

let isClosingPoint = false;

let firstPoint = null;

if(
    irregularMode &&
    lines.length >= 2
){

    firstPoint = {

        x: lines[0].x1,

        y: lines[0].y1

    };


    let closeDistance =
        distance(
            endPoint,
            firstPoint
        );


    // فاصله مجاز برای بستن شکل

    if(closeDistance <= 25){

        isClosingPoint = true;

        endPoint = {

            x: firstPoint.x,

            y: firstPoint.y

        };

    }

}
        // ------------------------------
        // ساخت خط
        // ------------------------------

        let line = {

            x1:
                startPoint.x,

            y1:
                startPoint.y,

            x2:
                endPoint.x,

            y2:
                endPoint.y,

            meter:
                null

        };


        lines.push(line);


        drawing = false;


        redrawCanvas();



        // ------------------------------
        // دریافت متراژ
        // ------------------------------

        let value =
            prompt(
                "متراژ این خط را وارد کنید (متر):"
            );


        // لغو
        if(value === null){

            lines.pop();

            redrawCanvas();

            return;

        }


        value =
            parseFloat(value);


        // عدد نامعتبر
        if(
            isNaN(value) ||
            value <= 0
        ){

            lines.pop();

            redrawCanvas();

            return;

        }


        line.meter =
            value;


        redrawCanvas();
        // ==========================================
// بستن فضای نامنظم بعد از ثبت متراژ ضلع
// ==========================================

if(
    irregularMode &&
    isClosingPoint
){

    polygonClosed = true;

    irregularMode = false;


    calculateIrregularArea();


    document.getElementById(
        "cutInfo"
    ).innerText =
        "پلان نامنظم بسته شد";


    document.getElementById(
        "suggestRoll"
    ).innerText =
        "مساحت محاسبه شد";


    redrawCanvas();

}


        // ==================================
        // بعد از ضلع دوم
        // ==================================
if(
    lines.length === 2 &&
    !shapeConfirmed &&
    !irregularMode
){

    let answer =
        confirm(
            "آیا این فضا مربع یا مستطیل است؟"
        );


    if(answer){

        // --------------------------------
        // حالت مربع / مستطیل
        // --------------------------------

        shapeConfirmed = true;

        createRectangleFromTwoLines();

    }
else{

    irregularMode = true;

    polygonClosed = false;

    document.getElementById("suggestRoll").innerText =
        "فضای نامنظم";

    document.getElementById("cutInfo").innerText =
        "ضلع بعدی را رسم کنید";

    document.getElementById("finishIrregularBtn").style.display =
        "block";

}
document
.getElementById("finishIrregularBtn")
.addEventListener(
    "click",
    function(){

        if(!irregularMode)
            return;

        if(lines.length < 3){

            alert("برای فضای نامنظم حداقل ۳ ضلع رسم کنید.");

            return;
        }

        // --------------------------------
        // آخرین نقطه فعلی
        // --------------------------------

        let lastLine =
            lines[lines.length - 1];

        let firstPoint = {

            x: lines[0].x1,
            y: lines[0].y1

        };

        let lastPoint = {

            x: lastLine.x2,
            y: lastLine.y2

        };

        // --------------------------------
        // اگر هنوز به نقطه اول نرسیده
        // خط بسته‌شدن را ایجاد کن
        // --------------------------------

        if(
            distance(
                lastPoint,
                firstPoint
            ) > 1
        ){

            let closingLine = {

                x1: lastPoint.x,
                y1: lastPoint.y,

                x2: firstPoint.x,
                y2: firstPoint.y,

                meter: null

            };

            lines.push(closingLine);

            redrawCanvas();

            // --------------------------------
            // دریافت طول ضلع پایانی
            // --------------------------------

            let value = prompt(
                "متراژ ضلع پایانی را وارد کنید (متر):"
            );

            if(value === null){

                lines.pop();

                redrawCanvas();

                return;
            }

            value = parseFloat(value);

            if(
                isNaN(value) ||
                value <= 0
            ){

                lines.pop();

                redrawCanvas();

                alert(
                    "متراژ وارد شده صحیح نیست."
                );

                return;
            }

            closingLine.meter = value;

        }

        // --------------------------------
        // فضا بسته شد
        // --------------------------------

        polygonClosed = true;

        irregularMode = false;

        document.getElementById(
            "finishIrregularBtn"
        ).style.display = "none";

        // --------------------------------
        // محاسبه مساحت
        // --------------------------------

        calculateIrregularArea();

        // --------------------------------
        // وضعیت
        // --------------------------------

        document.getElementById(
            "suggestRoll"
        ).innerText =
            "فضای نامنظم تکمیل شد";

        document.getElementById(
            "cutInfo"
        ).innerText =
            "پلان بسته و متراژ محاسبه شد";

        redrawCanvas();

    }
);
}

    }
);



// ==========================================
// فاصله دو نقطه
// ==========================================

function distance(a, b){

    let dx =
        a.x -
        b.x;


    let dy =
        a.y -
        b.y;


    return Math.sqrt(
        dx * dx +
        dy * dy
    );

}



// ==========================================
// ساخت مستطیل از دو ضلع
// ==========================================

function createRectangleFromTwoLines(){

    if(lines.length < 2)
        return;


    let line1 =
        lines[0];


    let line2 =
        lines[1];


    if(
        !line1.meter ||
        !line2.meter
    ){

        return;

    }


    // =====================================
    // ضلع اول
    // A ---------------- B
    // =====================================

    let A = {

        x:
            line1.x1,

        y:
            line1.y1

    };


    let B = {

        x:
            line1.x2,

        y:
            line1.y2

    };


    // =====================================
    // دو سر ضلع دوم
    // =====================================

    let P = {

        x:
            line2.x1,

        y:
            line2.y1

    };


    let Q = {

        x:
            line2.x2,

        y:
            line2.y2

    };


    // =====================================
    // نزدیک‌ترین سر ضلع دوم
    // به یکی از دو سر ضلع اول
    // =====================================

    let AP =
        distance(A, P);


    let AQ =
        distance(A, Q);


    let BP =
        distance(B, P);


    let BQ =
        distance(B, Q);


    let connectedPoint;
    let farPoint;


    if(
        AP <= AQ &&
        AP <= BP &&
        AP <= BQ
    ){

        connectedPoint = A;

        farPoint = Q;

    }

    else if(
        AQ <= AP &&
        AQ <= BP &&
        AQ <= BQ
    ){

        connectedPoint = A;

        farPoint = P;

    }

    else if(
        BP <= AP &&
        BP <= AQ &&
        BP <= BQ
    ){

        connectedPoint = B;

        farPoint = Q;

    }

    else{

        connectedPoint = B;

        farPoint = P;

    }


    // =====================================
    // بردار ضلع اول
    // =====================================

    let dx =
        B.x -
        A.x;


    let dy =
        B.y -
        A.y;


    let firstLength =
        Math.sqrt(
            dx * dx +
            dy * dy
        );


    if(firstLength <= 0)
        return;


    // =====================================
    // بردار واحد ضلع اول
    // =====================================

    let ux =
        dx /
        firstLength;


    let uy =
        dy /
        firstLength;


    // =====================================
    // بردار عمود
    // =====================================

    let perpX =
        -uy;


    let perpY =
        ux;


    // =====================================
    // بردار خط دوم
    // =====================================

    let sx =
        farPoint.x -
        connectedPoint.x;


    let sy =
        farPoint.y -
        connectedPoint.y;


    let secondLength =
        Math.sqrt(
            sx * sx +
            sy * sy
        );


    if(secondLength <= 0)
        return;


    // =====================================
    // تعیین سمت مستطیل
    // =====================================

    let side =
        sx * perpX +
        sy * perpY;


    if(side < 0){

        perpX *= -1;

        perpY *= -1;

    }


    // =====================================
    // بردار عرض
    // =====================================

    let offsetX =
        perpX *
        secondLength;


    let offsetY =
        perpY *
        secondLength;


    // =====================================
    // ساخت چهار گوشه
    // =====================================

    let C;
    let D;


    if(
        connectedPoint === A
    ){

        /*
            A ---------------- B
            |                  |
            |                  |
            D ---------------- C
        */


        D = {

            x:
                A.x +
                offsetX,

            y:
                A.y +
                offsetY

        };


        C = {

            x:
                B.x +
                offsetX,

            y:
                B.y +
                offsetY

        };

    }

    else{

        /*
            A ---------------- B
            |                  |
            |                  |
            D ---------------- C
        */


        C = {

            x:
                B.x +
                offsetX,

            y:
                B.y +
                offsetY

        };


        D = {

            x:
                A.x +
                offsetX,

            y:
                A.y +
                offsetY

        };

    }


    // =====================================
    // چهار ضلع نهایی
    // =====================================

    lines = [

        // -------------------------------
        // ضلع اول
        // -------------------------------

        {

            x1:
                A.x,

            y1:
                A.y,

            x2:
                B.x,

            y2:
                B.y,

            meter:
                line1.meter

        },


        // -------------------------------
        // ضلع دوم
        // -------------------------------

        {

            x1:
                connectedPoint.x,

            y1:
                connectedPoint.y,

            x2:
                connectedPoint.x +
                offsetX,

            y2:
                connectedPoint.y +
                offsetY,

            meter:
                line2.meter

        },


        // -------------------------------
        // ضلع سوم
        // روبه‌روی ضلع اول
        // -------------------------------

        {

            x1:
                C.x,

            y1:
                C.y,

            x2:
                D.x,

            y2:
                D.y,

            meter:
                line1.meter

        },


        // -------------------------------
        // ضلع چهارم
        // روبه‌روی ضلع دوم
        // -------------------------------

        {

            x1:
                D.x,

            y1:
                D.y,

            x2:
                A.x,

            y2:
                A.y,

            meter:
                line2.meter

        }

    ];


    // =====================================
    // رسم شکل کامل
    // =====================================

    redrawCanvas();


    // =====================================
    // انتقال ابعاد به محاسبه
    // =====================================

// =====================================
// انتقال ابعاد به باکس‌های طول و عرض
// =====================================

let lengthInput =
    document.getElementById("length");

let widthInput =
    document.getElementById("width");


if(lengthInput){

    lengthInput.value =
        line1.meter;

}


if(widthInput){

    widthInput.value =
        line2.meter;

}


// محاسبه مساحت
if(
    typeof calculateArea ===
    "function"
){

    calculateArea();

}

}

function redrawCanvas(){



    ctx.clearRect(

        0,

        0,

        canvas.width,

        canvas.height

    );

// نمایش تصویر نقشه
if(planImage){

    ctx.drawImage(
        planImage,
        0,
        0,
        canvas.getBoundingClientRect().width,
        canvas.getBoundingClientRect().height
    );

}

    ctx.lineWidth=4;

    ctx.lineCap="round";


    ctx.strokeStyle="black";




    lines.forEach(function(line){



        ctx.beginPath();



        ctx.moveTo(

            line.x1,

            line.y1

        );



        ctx.lineTo(

            line.x2,

            line.y2

        );



        ctx.stroke();

if(line.meter){

    let centerX =
        (line.x1 + line.x2) / 2;

    let centerY =
        (line.y1 + line.y2) / 2;


    ctx.font = "bold 18px Arial";

    ctx.fillStyle = "red";

    ctx.textAlign = "center";

    ctx.textBaseline = "middle";


    ctx.fillText(
        line.meter + " متر",
        centerX,
        centerY - 12
    );

}

    });



}

// ==========================================
// محاسبه مساحت واقعی فضای نامنظم
// بر اساس متر واقعی اضلاع
// ==========================================
function calculateIrregularArea(){

    if(!polygonClosed || lines.length < 3){
        return;
    }

    // ==========================================
    // فضای چهارضلعی
    // ==========================================

    if(lines.length === 4){

        let a = parseFloat(lines[0].meter) || 0;
        let b = parseFloat(lines[1].meter) || 0;
        let c = parseFloat(lines[2].meter) || 0;
        let d = parseFloat(lines[3].meter) || 0;

        // اگر اضلاع روبه‌رو تقریباً برابر باشند
        // شکل را مستطیل در نظر می‌گیریم

        if(
            Math.abs(a - c) < 0.2 &&
            Math.abs(b - d) < 0.2
        ){

            let area = a * b;

            document.getElementById("area").innerText =
                area.toFixed(2);

            document.getElementById("hiddenArea").value =
                area.toFixed(2);

            console.log("RECTANGLE AREA:", area);

            return;
        }
    }


    // ==========================================
    // چندضلعی نامنظم واقعی
    // ==========================================

    let points = [];

    let currentX = 0;
    let currentY = 0;

    points.push({
        x: currentX,
        y: currentY
    });


    lines.forEach(function(line){

        let dx =
            line.x2 - line.x1;

        let dy =
            line.y2 - line.y1;

        let pixelLength =
            Math.sqrt(
                dx * dx +
                dy * dy
            );

        if(
            pixelLength <= 0 ||
            !line.meter ||
            line.meter <= 0
        ){
            return;
        }

        let ux =
            dx / pixelLength;

        let uy =
            dy / pixelLength;

        currentX +=
            ux * line.meter;

        currentY +=
            uy * line.meter;

        points.push({
            x: currentX,
            y: currentY
        });

    });


    if(points.length < 4){
        return;
    }


    // ==========================================
    // Shoelace
    // ==========================================

    let area = 0;

    for(
        let i = 0;
        i < points.length - 1;
        i++
    ){

        area +=
            (
                points[i].x *
                points[i + 1].y
            )
            -
            (
                points[i + 1].x *
                points[i].y
            );

    }


    let last =
        points[points.length - 1];

    let first =
        points[0];

    area +=
        (
            last.x *
            first.y
        )
        -
        (
            first.x *
            last.y
        );


    area =
        Math.abs(area) / 2;


    document.getElementById("area").innerText =
        area.toFixed(2);

    document.getElementById("hiddenArea").value =
        area.toFixed(2);


    console.log(
        "========== IRREGULAR AREA =========="
    );

    console.log("POINTS:", points);

    console.log("AREA:", area);

}


// پاک کردن نقشه


document
.querySelector("form")
.addEventListener(
"submit",
function(){

    saveSpaceData();

});




resizeCanvas();



console.log(
"DTZ Canvas Ready"
);

</script>
<script>


// ===============================
// محاسبه متراژ
// ===============================


function calculateArea(){


    let length =
    parseFloat(
        document.getElementById("length").value
    ) || 0;



    let width =
    parseFloat(
        document.getElementById("width").value
    ) || 0;



    let area =
    length * width;



    document.getElementById("area").innerText =
    area.toFixed(2);



    document.getElementById("hiddenArea").value =
    area.toFixed(2);



    suggestRollSize();



}




document
.getElementById("length")
.addEventListener(
"input",
calculateArea
);



document
.getElementById("width")
.addEventListener(
"input",
calculateArea
);





// ===============================
// موتور پیشنهاد طاقه
// ===============================


function suggestRollSize(){



    let length =
    parseFloat(
        document.getElementById("length").value
    ) || 0;



    let width =
    parseFloat(
        document.getElementById("width").value
    ) || 0;



    if(length<=0 || width<=0){


        document.getElementById("suggestRoll").innerText="-";


        document.getElementById("cutInfo").innerText="-";


        return;

    }




    let area =
    length * width;



    let rolls=[];



    // -------------------------
    // یک طاقه
    // -------------------------


    for(let i=1;i<=15;i++){


        if(
            (3*i)>=area
        ){


            rolls.push({

                length:i,

                count:1

            });



            showRollResult(
                rolls,
                "یک طاقه با کمترین پرت"
            );


            return;

        }


    }






    // -------------------------
    // دو طاقه
    // -------------------------


    let best=null;



    for(
        let a=1;
        a<=15;
        a++
    ){


        for(
            let b=1;
            b<=15;
            b++
        ){


            let cover =
            (3*a)+(3*b);



            let waste =
            cover-area;



            if(
                waste>=0 &&
                (!best || waste<best.waste)
            ){


                best={

                    a:a,

                    b:b,

                    waste:waste

                };


            }



        }


    }






    if(best){


        rolls.push({

            length:best.a,

            count:1

        });



        rolls.push({

            length:best.b,

            count:1

        });



        showRollResult(
            rolls,
            "دو طاقه با کمترین پرت"
        );


    }




}







// نمایش نتیجه پیشنهاد


function showRollResult(
    rolls,
    text
){



    document.getElementById(
        "suggestRoll"
    ).innerText =



    rolls.map(function(r){


        return "3×"+r.length+
        " تعداد "+r.count;


    }).join(" + ");




    document.getElementById(
        "cutInfo"
    ).innerText=text;



    setSuggestedRolls(rolls);



}







// ساخت لیست طاقه‌ها


function setSuggestedRolls(rolls){



    let box =
    document.getElementById(
        "rollContainer"
    );



    box.innerHTML="";



    rolls.forEach(function(item){



        let row =
        document.createElement("div");



        row.className =
        "row g-3 mt-2";



        row.innerHTML=`


<div class="col-8">


<select class="form-select roll-select">


${Array.from(
{length:15},
(_,i)=>{


let n=i+1;


return `

<option value="${n}"
${n==item.length?"selected":""}>

3×${n}

</option>

`;

}).join("")}



</select>


</div>



<div class="col-4">


<input

type="number"

class="form-control roll-count"

value="${item.count}"

min="1">


</div>


`;



        box.appendChild(row);



    });



    updateRollArea();


}







// افزودن دستی طاقه


document
.getElementById("addRollBtn")
.addEventListener(
"click",
function(){



let box =
document.getElementById(
"rollContainer"
);



let row =
document.createElement("div");



row.className =
"row g-3 mt-2";



row.innerHTML=`


<div class="col-8">


<select class="form-select roll-select">

${Array.from(
{length:15},
(_,i)=>`

<option value="${i+1}">
3×${i+1}
</option>

`).join("")}


</select>


</div>



<div class="col-4">


<input

type="number"

class="form-control roll-count"

value="1"

min="1">


</div>


`;



box.appendChild(row);


updateRollArea();


});






// محاسبه پوشش طاقه


function updateRollArea(){


let total=0;



document
.querySelectorAll(
"#rollContainer .row"
)
.forEach(function(row){



let length =
parseFloat(
row.querySelector(".roll-select").value
);



let count =
parseFloat(
row.querySelector(".roll-count").value
);



total +=
(3*length)*count;



});



document.getElementById(
"rollArea"
).innerText =
total.toFixed(2);



}






document.addEventListener(
"input",
function(e){



if(
e.target.classList.contains(
"roll-count"
)
||
e.target.classList.contains(
"roll-select"
)
){


updateRollArea();


}



});



</script>
<script>


// ===============================
// ذخیره نهایی DTZ SPACE
// ===============================


function saveSpaceData(){



    // نام فضا

    document.getElementById("hiddenName").value =

    document.getElementById("spaceNameText").value;





    // متراژ

    document.getElementById("hiddenArea").value =

    document.getElementById("area").innerText;







    // تصویر پلان Canvas


    document.getElementById("hiddenDrawing").value =

    canvas.toDataURL(
        "image/png"
    );







    // ذخیره طاقه‌ها


    let rolls=[];



    document
    .querySelectorAll(
        "#rollContainer .row"
    )
    .forEach(function(row){



        let select =
        row.querySelector(".roll-select");



        let count =
        row.querySelector(".roll-count");



        if(select && count){



            rolls.push({


                size:
                "3x"+select.value,


                length:
                select.value,


                count:
                count.value



            });



        }



    });







    document.getElementById("hiddenRoll").value =

    JSON.stringify(rolls);






    document.getElementById("hiddenRollCount").value =

    rolls.length;



}







// قبل از ارسال فرم


document
.getElementById("saveBtn")
.addEventListener(
"click",
function(){


    saveSpaceData();


});






console.log(
"DTZ Space Save Ready"
);
// ==========================================
// آپلود و ارسال تصویر نقشه به Backend
// ==========================================

document
.getElementById("uploadPlanBtn")
.addEventListener(
    "click",
    function(){

        document
        .getElementById("planImageInput")
        .click();

    }
);


document
.getElementById("planImageInput")
.addEventListener(
    "change",
    function(e){

        let file = e.target.files[0];
        console.log("IMAGE SELECTED:", file);
alert("عکس انتخاب شد");

        if(!file)
            return;


        // ------------------------------
        // نمایش فوری تصویر روی Canvas
        // ------------------------------

        let reader = new FileReader();


        reader.onload = function(event){

            let img = new Image();


            img.onload = function(){

                planImage = img;

                redrawCanvas();

            };


            img.src = event.target.result;

        };


        reader.readAsDataURL(file);


        // ------------------------------
        // ارسال تصویر به Laravel
        // ------------------------------

        let formData = new FormData();

        formData.append(
            "plan_image",
            file
        );


        // CSRF
        formData.append(
            "_token",
            document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content") || ""
        );


        // ------------------------------
        // نمایش وضعیت
        // ------------------------------

        document.getElementById(
            "suggestRoll"
        ).innerText = "در حال تحلیل تصویر...";


        document.getElementById(
            "cutInfo"
        ).innerText = "-";


        // ------------------------------
        // ارسال به Backend
        // ------------------------------
console.log("SENDING IMAGE TO LARAVEL");
alert("در حال ارسال عکس به Laravel...");

        fetch(
            "{{ route('tablet.space.analyze-image') }}",
            {
                method: "POST",
                body: formData,
                headers: {
                    "Accept": "application/json"
                }
            }
        )


        .then(function(response){

            return response.json();

        })


        .then(function(result){

            console.log(
                "AI RESULT:",
                result
            );


            if(!result.success){

                document.getElementById(
                    "suggestRoll"
                ).innerText =
                    "تحلیل انجام نشد";


                document.getElementById(
                    "cutInfo"
                ).innerText =
                    result.message || "خطا";


                return;

            }

// ==========================================
// دریافت نتیجه تحلیل Backend
// ==========================================

console.log(
    "نتیجه تحلیل:",
    result.analysis
);


if(result.analysis){

    let analysis =
        result.analysis;


    // ------------------------------
    // طول
    // ------------------------------

    if(
        analysis.length !== null
    ){

        document.getElementById(
            "length"
        ).value =
            analysis.length;

    }


    // ------------------------------
    // عرض
    // ------------------------------

    if(
        analysis.width !== null
    ){

        document.getElementById(
            "width"
        ).value =
            analysis.width;

    }


    // ------------------------------
    // محاسبه متراژ
    // ------------------------------

    calculateArea();


    // ------------------------------
    // وضعیت
    // ------------------------------

    document.getElementById(
        "suggestRoll"
    ).innerText =
        "پلان شناسایی شد";


    document.getElementById(
        "cutInfo"
    ).innerText =
        "اطلاعات تصویر دریافت شد";

}


        })


        .catch(function(error){

            console.error(
                "IMAGE ANALYSIS ERROR:",
                error
            );


            document.getElementById(
                "suggestRoll"
            ).innerText =
                "خطا در تحلیل";


            document.getElementById(
                "cutInfo"
            ).innerText =
                "ارتباط با سرور برقرار نشد";

        });

    }
);
// ==========================================
// تحلیل نقشه مشتری
// ==========================================

function analyzePlanImage(){

    console.log("شروع تحلیل نقشه مشتری");

    // فعلاً تست اتصال
    // مرحله بعد اینجا تصویر را به Laravel می‌فرستیم

    let length =
        document.getElementById("length");

    let width =
        document.getElementById("width");


    console.log(
        "تصویر آماده تحلیل AI است"
    );

}
// ==========================================
// پاک کردن نقشه
// ==========================================

document
.getElementById("clearBtn")
.addEventListener(
    "click",
    function(){

        // پاک کردن خطوط
        lines = [];

        // پاک کردن اندازه‌ها
        dimensions = [];

        // پاک کردن تصویر نقشه
        planImage = null;

        // اجازه رسم مجدد
        shapeConfirmed = false;
irregularMode = false;
polygonClosed = false;
document.getElementById(
    "finishIrregularBtn"
).style.display = "none";

        // پاک کردن Canvas
        redrawCanvas();

        // پاک کردن طول
        document.getElementById("length").value = "";

        // پاک کردن عرض
        document.getElementById("width").value = "";

        // صفر کردن متراژ
        document.getElementById("area").innerText = "0";

        document.getElementById("hiddenArea").value = "0";

        // پاک کردن پیشنهاد
        document.getElementById("suggestRoll").innerText = "-";

        document.getElementById("cutInfo").innerText = "-";

        // پاک کردن طاقه‌ها
        document.getElementById("rollContainer").innerHTML = "";

        // صفر کردن پوشش
        document.getElementById("rollArea").innerText = "0";

        // پاک کردن تصویر ذخیره‌شده
        document.getElementById("hiddenDrawing").value = "";

        // پاک کردن انتخاب فایل
        document.getElementById("planImageInput").value = "";

    }
);
</script>

</body>
</html>