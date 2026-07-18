@extends('layouts.app')

@section('content')

<style>

/*==================================================
    PREPARE PAGE
==================================================*/

.prepare-wrapper{

 margin-top:-25px;

}


/*==================================================
    STEP BAR
==================================================*/

.steps-bar{

    flex:1;

    display:flex;

    justify-content:center;

    align-items:center;

    gap:70px;

    padding:25px;

    background:#fff5f5;

    border-bottom:1px solid #eee;

       margin-bottom:35px;
       border-radius:0 0 14px 14px;

}


.step{

    text-align:center;

    color:#666;

    font-size:14px;

    font-weight:600;

}

.step-card{

    width:100%;

    max-width:none;

    background:#fff;

    border:0;

    border-radius:0;

    padding:20px;

}
.step-title{

 font-size:24px;

    font-weight:700;

    margin-bottom:15px;

}
.form-select{

    height:56px;

    border-radius:10px;

}
.btn-add{

    height:50px;

    border:1px solid #d91f26;

    color:#d91f26;

    background:#fff;

    border-radius:10px;

    font-weight:700;

}

.btn-add:hover{

    background:#d91f26;

    color:#fff;

}
.price-box{

    border-top:1px solid #eee;

    margin-top:35px;

    padding-top:20px;

    font-size:18px;

}
.step-actions{

    display:flex;

    justify-content:space-between;

    margin-top:40px;

}
.step-circle{

    width:40px;

    height:40px;

    border-radius:50%;

    background:#fff;

    border:1px solid #ddd;

    display:flex;

    align-items:center;

    justify-content:center;

    margin:auto;

    margin-bottom:8px;

}


.step.active{

    color:#d91f26;

}


.step.active .step-circle{

    background:#d91f26;

    border-color:#d91f26;

    color:#fff;

}


/*==================================================
    ADD SPACE
==================================================*/

.add-space{

    width:100%;

    height:72px;

    border:2px dashed #bdbdbd;

    border-radius:12px;

    display:flex;

    align-items:center;

    padding-right:25px;

    cursor:pointer;

    font-size:17px;

    font-weight:700;

    transition:.2s;

}

.add-space:hover{

    background:#fafafa;

    border-color:#d91f26;

}


/*==================================================
    SPACE CARD
==================================================*/

#spaces-container{

    margin-top:20px;

}

.space-card{

    background:#fff;

    border:1px solid #e5e5e5;

    border-radius:12px;

    overflow:hidden;

    margin-top:18px;

    box-shadow:0 2px 8px rgba(0,0,0,.05);

}

.space-header{

    height:64px;

    padding:0 22px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    border-bottom:1px solid #eee;

}

.space-title{

    font-size:18px;

    font-weight:700;

}

.delete-space{

    border:none;

    background:none;

    color:#d91f26;

    font-size:22px;

    cursor:pointer;

}

.space-content{

    padding:22px;

}
/*==================================================
    ROLL LIST
==================================================*/

.roll-list{

    width:100%;

}

.roll-item{

    margin-bottom:18px;

}

/*====================================
    ROLL LIST
====================================*/

.roll-list{

    display:flex;

    flex-direction:column;

    gap:12px;

}



.roll-item{

    width:100%;

}



.roll-row{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:14px;

    align-items:end;

}



.roll-size-box,
.roll-count-box{

    width:100%;

}



.roll-size-box label,
.roll-count-box label{

    display:block;

    margin-bottom:6px;

    font-size:13px;

    font-weight:600;

    color:#666;

}



.roll-size-box select,
.roll-count-box input{

    width:100%;

    height:48px;

    border-radius:8px;

}



.roll-count{

    text-align:center;

}



/* دکمه حذف هر ردیف فعلاً استفاده نمی‌شود */

.remove-roll{

       width:46px;

    height:46px;

    border:none;

    border-radius:8px;

    background:#dc3545;

    color:#fff;

    font-size:20px;

    cursor:pointer;
        display:none !important;


}
.remove-roll:hover{

    background:#bb2d3b;

}

/*====================================
    نوع موکت
====================================*/

.pile-box{

    margin-top:28px;

    padding-top:22px;

    border-top:1px solid #eee;

}

.pile-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;

}

.field-title{

    margin:0;

    font-size:15px;

    font-weight:700;

    color:#444;

}

.pile-options{

    display:flex;

    align-items:center;

    gap:28px;

}

.pile-options label{

    display:flex;

    align-items:center;

    gap:6px;

    margin:0;

    cursor:pointer;

    font-size:14px;

}



/*====================================
    پایین کارت
====================================*/

.space-footer{

    display:grid;

    grid-template-columns: 1fr 1fr 1fr;

    gap:14px;

    margin-top:25px;

    padding-top:20px;

    border-top:1px solid #eee;

}

.footer-box,
.add-roll,
.remove-last-roll{

    
    height:56px;

    border-radius:8px;

    border:1px solid #dc3545;

    background:#fff;

    color:#dc3545;

    font-weight:700;

}

.footer-box{

    border:1px solid #ddd;

    background:#fff;

    gap:8px;

}

.add-roll{

    border:1px solid #d91f26;

    background:#fff;

    color:#d91f26;

}

.add-roll:hover{

    background:#d91f26;

    color:#fff;

}

.remove-last-roll{

    border:1px solid #6c757d;

    background:#fff;

    color:#555;

}

.remove-last-roll:hover{

    background:#dc3545;

    color:#fff;

}

.space-area{

    color:#d91f26;

    font-size:16px;

    font-weight:700;

}

.project-info{

    margin-top:40px;

    background:#fff;

    border:1px solid #e8e8e8;

    border-radius:12px;

    padding:20px;

}

.project-row{

    display:flex;

    justify-content:space-between;

    align-items:center;

}

.install-price{

    margin-top:18px;

    text-align:right;

    font-size:18px;

    font-weight:700;

}

.next-btn{

    margin-top:25px;

    background:#222;

    color:#fff;

    border:none;

    border-radius:10px;

    padding:12px 70px;

    transition:.2s;

}

.next-btn:hover{

    background:#000;

}


/*==================================================
    MODAL
==================================================*/

.modal-content{

    border:none;

    border-radius:14px;

}

.modal-header{

    padding:18px 22px;

    border-bottom:1px solid #eee;

}

.modal-title{

    font-size:18px;

    font-weight:700;

}

.modal-body{

    padding:20px;

}

.modal-footer{

    border-top:1px solid #eee;

    padding:18px;

}

.space-list{

    border:1px solid #ececec;
    border-radius:12px;
    max-height:420px;
    overflow-y:auto;

}
.space-list::-webkit-scrollbar{
    width:6px;
}

.space-list::-webkit-scrollbar-thumb{
    background:#d8d8d8;
    border-radius:20px;
}

.space-list::-webkit-scrollbar-track{
    background:#f7f7f7;
}
.space-item{

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:14px 18px;

    border-bottom:1px solid #efefef;

    cursor:pointer;

    transition:.2s;

}

.space-item:last-child{

    border-bottom:none;

}

.space-item:hover{

    background:#fafafa;

}

.space-info{

    display:flex;

    align-items:center;

    gap:12px;

}

.space-icon{

    font-size:20px;
    color:#d91f26;

}

.space-name{

    font-size:15px;
    font-weight:600;

}

.space-item input{

    width:20px;

    height:20px;

}
.space-search{

    position:relative;

    margin-bottom:15px;

}

.space-search i{

    position:absolute;
    right:15px;
    top:50%;

    color:#999;

}

.space-search input{

    padding-right:42px;
    height:46px;
    border-radius:10px;

}


/*==================================================
    FORM
==================================================*/

.form-control,
.form-select{

    height:46px;

    border-radius:8px;

}

.form-control:focus,
.form-select:focus{

    border-color:#d91f26;

    box-shadow:0 0 0 .15rem rgba(217,31,38,.15);

}
.remove-placeholder{

    visibility:hidden;

    pointer-events:none;

}





/*==================================================
    RESPONSIVE
==================================================*/

@media(max-width:768px){

    .steps-bar{

        gap:20px;

        flex-wrap:wrap;

    }

    .roll-row{

    display:grid;

    grid-template-columns: 1fr 180px;

    gap:14px;

    align-items:end;

    margin-bottom:16px;

    }

   .roll-item:first-child .remove-roll{

    visibility:hidden;

    }

    .space-footer{

           display:flex;
    justify-content:space-between;
    align-items:center;

    margin-top:18px;

    }

    .space-price{

    font-size:15px;
    font-weight:700;

}

.space-footer .btn{

    min-width:120px;
    border-radius:10px;

}
}


/*====================================
    INSTALL HEADER
====================================*/

.install-header{

    height:64px;

    background:#d7262d;

    border-radius:14px 14px 0 0;

    display:flex;

    align-items:center;

    justify-content:center;

    position:relative;

    color:#fff;

    margin-bottom:0;

}

.install-header-title{

    font-size:18px;

    font-weight:700;

    letter-spacing:.3px;

}

.install-back-btn{

    position:absolute;

    right:18px;

    width:40px;

    height:40px;

    border:none;

    border-radius:50%;

    background:transparent;

    color:#fff;

    display:flex;

    align-items:center;

    justify-content:center;

    transition:.2s;

}

.install-back-btn:hover{

    background:rgba(255,255,255,.15);

}

.install-back-btn i{

    font-size:22px;
    

}




.stairs-box{

    background:#fff;

    border:1px solid #eee;

    border-radius:12px;

    padding:20px;

    margin-top:15px;

}


.stairs-box .form-control{

    width:160px !important;

}


.stairs-box label{

    font-size:13px;

    margin-bottom:6px;

}


.stairs-price-box{

    text-align:right;

    background:#fafafa;

    padding:12px;

    border-radius:10px;

    font-size:14px;

}
.install-card{

    background:#fff;
    border-radius:16px;
    padding:25px;
    box-shadow:0 3px 15px rgba(0,0,0,.08);
    margin-bottom:25px;

}


.install-section-title{

    font-weight:bold;
    margin-bottom:25px;

}


/* =====================================================
                    STEP 2 - FLOOR PALAZ STYLE
===================================================== */


/* کارت مرحله */

#step2 .step-card{

    background:transparent;
    border:0;
    box-shadow:none;
    padding:0;

}


/* دو ستون */

#step2 .floor-wrapper{

    display:grid;

    grid-template-columns:48% 52%;

    gap:10px;

    align-items:start;

}


/* ستون ها */

#step2 .right-panel,
#step2 .left-panel{

    width:100%;

    display:flex;

    flex-direction:column;

    align-items:stretch;

    padding-top:32;

}



/* لیست ها */

#step2 #floorList,
#step2 #floorMeters{

    display:flex;

    flex-direction:column;

}



/* ==========================
        ردیف کف
========================== */


#step2 .floor-row{

    display:flex;

    flex-direction:column;

    height:140px;

    margin-bottom:20px;

}



/* ==========================
        ردیف متراژ
========================== */


#step2 .meter-item{

    height:140px;

    margin-bottom:20px;

}



/* عنوان */

#step2 .form-label{

    display:block;

    font-size:13px;

    font-weight:600;

    color:#555;

    margin-bottom:8px;

}



/* ورودی ها */

#step2 .form-select,
#step2 .form-control{


    width:100%;

    height:46px;

    border:1px solid #d9d9d9;

    border-radius:10px;

    box-shadow:none;

    font-size:14px;

}


/* انتخاب کف + حذف */

.floor-select-row{


    display:flex;

    align-items:center;

    gap:10px;


}


.floor-select-row .form-select{

    flex:1;

}


.floor-delete{

    width:46px;

    height:46px;

    flex-shrink:0;

    border:1px solid #ddd;

    background:#fff;

    border-radius:8px;

    color:#d21f26;

}



/* ==========================
        چک باکس
========================== */


#step2 .form-check{

    display:flex;

    align-items:center;

    gap:8px;

    height:30px;

    margin-top:12px;

    padding:0;

}



#step2 .form-check-input{

    margin:0;

}


#step2 .form-check-label,
#step2 .form-check span{

    font-size:13px;

    color:#555;

}



/* ==========================
        دکمه افزودن
========================== */


#step2 .btn-add{


    width:100%;

    height:46px;

    border:1px solid #d21f26;

    background:#fff;

    color:#d21f26;

    border-radius:10px;

    font-weight:600;


}


#step2 .btn-add:hover{


    background:#d21f26;

    color:#fff;


}



/* ==========================
        چسب
========================== */


#step2 #glueList{

    margin-top:25px;

}


/* ==========================
        هزینه
========================== */


#step2 .price-box{

    margin-top:20px;

}


#step2 .price-title{

    font-size:13px;

    color:#777;

    margin-bottom:6px;

}


#step2 .price-value{

    font-size:24px;

    font-weight:700;

    color:#d21f26;

}
.glue-row{

    display:flex;

    align-items:end;

    gap:12px;

}

.glue-select-box{

    flex:1;

}

.glue-number-box{

    width:120px;

}



/* ==========================
        پله
========================== */


#step2 .stairs-area{

    margin-top:35px;

}


#step2 .stairs-radio{

    margin-top:15px;

}


#step2 .stairs-radio label{

    margin-left:25px;

}



/* حذف فاصله بوت استرپ روی کف */

#step2 .floor-row.mt-4,
#step2 .floor-row.mt-3,
#step2 .floor-row.mt-2{

    margin-top:0 !important;

}



/* فاصله بین ردیف های اضافه */

#step2 .floor-row + .floor-row{

    margin-top:20px;

}


#step2 .meter-item + .meter-item{

    margin-top:20px;

}


/* حذف placeholder های قبلی */

.floor-placeholder,
.meter-placeholder{

    display:none !important;

}
.extra-radio{

    display:flex;
    justify-content:center;
    gap:60px;
    margin-top:20px;

}


.radio-card{

    display:flex;
    align-items:center;
    gap:8px;
    cursor:pointer;
    font-size:15px;
    color:#555;

}


.radio-card input{

    display:none;

}


.radio-circle{

    width:18px;
    height:18px;
    border:1px solid #999;
    border-radius:50%;
    display:inline-block;
    position:relative;

}


.radio-card input:checked + .radio-circle{

    border-color:#d91f26;

}


.radio-card input:checked + .radio-circle::after{

    content:"";
    width:10px;
    height:10px;
    background:#d91f26;
    border-radius:50%;
    position:absolute;
    top:3px;
    left:3px;

}
.question-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}


.radio-box{
    display:flex;
    gap:25px;
}


.fish-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
    margin-bottom:15px;
}


.fish-right,
.fish-left{
    width:100%;
}


.add-fish-btn{

    width:50%;
    height:40px;
    border:1px solid red;
    background:white;
    color:red;
    border-radius:8px;

}


.price-row{

    margin-top:15px;
    text-align:right;

}



@media(max-width:768px){

    .fish-row{
        grid-template-columns:1fr;
    }

}
/* ==========================
   PALAZ SPACE MODAL
========================== */

#spaceModal .modal-dialog{

    max-width:520px;


}

#spaceModal .modal-content{

    height:700px;
    border-radius:12px;

}

#spaceModal .modal-header{

    background:#fff;
    border-bottom:1px solid #eee;
    padding:8px 12px;

}

#spaceModal .modal-title{

    font-size:18px;
    font-weight:700;

}

#spaceModal .modal-body{

    padding:20px;

}

#spaceModal .modal-footer{

   padding:0;

}

#addSelectedSpaces{
    width:100%;
    height:38px;
    border-radius:8px;
}
#spaceModal .btn-danger{

    width:100%;
    height:34px;
    border-radius:6px;
    font-size:12px;

}

#spaceModal .btn-secondary{

    display:none;

}
/* ===========================
   Palaz Modal
=========================== */

#spaceModal .modal-dialog{

    max-width:520px;
    width:520px;
    margin:auto;

}

#spaceModal .modal-content{

    border:none;
    border-radius:18px;
    overflow:hidden;

}

#spaceModal .modal-header{

    padding:18px 22px;
    border-bottom:1px solid #eee;

}

#spaceModal .modal-body{

    display:flex;
    flex-direction:column;
    padding:12px;

}

#spaceModal .modal-footer{

    padding:12px;
}
.space-check{
    width:20px;
    height:20px;
    accent-color:#d91f26;
    cursor:pointer;
}
#spaceModal .space-footer{

    display:flex;

    justify-content:center;

    padding:12px;

    border-top:1px solid #eee;

}


#spaceModal #addSelectedSpaces{

    width:100%;

    height:42px;

    border-radius:8px;

    font-weight:700;

}
/*==============================
    STEP 4
==============================*/

.special-list{

    display:flex;
    flex-direction:column;
    gap:15px;

}

.special-item{

    display:flex;

    align-items:center;

    justify-content:flex-start;

    gap:12px;


}

.special-item:last-child{

    border-bottom:none;

}

.special-item span{

    width:120px;

    text-align:right;

}

.special-item input{

    width:18px;

    height:18px;

    margin:0;

    flex-shrink:0;

}
.special-description{

    height:120px;

    resize:none;

}
.upload-box{

    width:100%;
    height:56px;

    border:1px dashed #cfcfcf;

    border-radius:10px;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    background:#fff;

    cursor:pointer;

    transition:.2s;

}

.upload-box:hover{

    border-color:#d91f26;

}

.upload-text{

    font-size:15px;

    font-weight:700;

    color:#222;

}

.upload-icon{

    color:#d91f26;

    font-size:20px;

}
.special-bottom-row{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:20px;

    margin-top:25px;

}


.upload-box{

    height:46px;

    border:1px dashed #bdbdbd;

    border-radius:10px;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    cursor:pointer;

}
.special-preview{

    display:flex;

    flex-wrap:wrap;

    gap:10px;

    margin-top:15px;

}


.preview-item{

    position:relative;

    width:90px;

    height:90px;

}


.preview-item img{

    width:100%;

    height:100%;

    object-fit:cover;

    border-radius:10px;

}


.preview-remove{

    position:absolute;

    top:-6px;

    left:-6px;

    width:22px;

    height:22px;

    border:none;

    border-radius:50%;

    background:#d91f26;

    color:#fff;

    font-size:14px;

}
/* ==========================================
   STEP 5 CLEAN VERSION
========================================== */


#step5 .step-card{
    border:none;
    background:transparent;
    box-shadow:none;
}


/* ردیف اصلی */

#step5 .step5-section{

    width:100%;

    margin-bottom:20px;

}


/* سوال + جواب */

#step5 .step5-row{

    display:flex;

    align-items:center;

    width:100%;

}


#step5 .step5-title{

    width:35%;

}


#step5 .step5-action{

    width:65%;

    display:flex;

    justify-content:center;

    align-items:center;

    gap:35px;

}



/* خط جدا کننده */

#step5 .step-divider{

    width:100%;

    border:0;

    border-top:1px solid #e5e5e5;

    margin:25px 0;

}



/* چک باکس */

#step5 .checkbox-card{

    display:flex;

    align-items:center;

    gap:10px;

    cursor:pointer;

}


#step5 .checkbox-card input{

    display:none;

}


#step5 .checkbox-card span{

    width:18px;

    height:18px;

    border:2px solid #999;

    border-radius:4px;

}


#step5 .checkbox-card input:checked + span{

    background:#198754;

    border-color:#198754;

}



/* رادیو */

#step5 .radio-card{

    display:flex;

    align-items:center;

    gap:8px;

    cursor:pointer;

}



#step5 .radio-card input{

    display:none;

}


#step5 .radio-circle{

    width:18px;

    height:18px;

    border:2px solid #999;

    border-radius:50%;

}


#step5 .radio-card input:checked + .radio-circle{

    border-color:#198754;

    position:relative;

}


#step5 .radio-card input:checked + .radio-circle:after{

    content:"";

    width:10px;

    height:10px;

    background:#198754;

    border-radius:50%;

    position:absolute;

    top:2px;

    right:2px;

}



/* باکس تعداد طبقات */

#step5 .floating-box{

    position:relative;

    width:220px;

    margin:0 auto;

}


#step5 .floating-box input{

    height:55px;

    border-radius:12px;

}



#step5 .floating-box label{

    position:absolute;

    top:-10px;

    right:12px;

    background:white;

    padding:0 8px;

    font-size:12px;

}


/* قیمت ها */

#step5 .item-price,
#step5 .worker-price-text{

    color:#666;

    font-size:14px;

}



/* آسانسور */

#step5 .elevator-type-box{

    opacity:.5;

    pointer-events:none;

}


#step5 .elevator-type-box.active{

    opacity:1;

    pointer-events:auto;

}



#step5 .elevator-type-box .step5-action{

    gap:35px;

}



/* تمیزی محل */

#step5 .clean-place-row{

    display:flex;

    justify-content:space-between;

    align-items:center;

}


#step5 .clean-place-row .extra-radio{

    display:flex;

    gap:35px;

}



/* کارگر */

#step5 #workerBox{

    margin-top:15px;

}


#step5 .worker-box{

    display:flex;

    flex-direction:column;

    gap:10px;

}


#step5 .worker-input{

    width:260px;

}



/* لوکیشن */

#step5 #locationSection{

    width:100%;

}


#step5 #locationSection .vertical-radio{

    flex-direction:row;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:40px;

}


#step5 .location-radio{

    display:flex;

    flex-direction:column;

    gap:15px;

}



/* نقشه */

#step5 .map-box{

    height:300px;

    width:100%;

    border:1px solid #ddd;

    border-radius:12px;

    background:#f8f8f8;

    display:flex;

    align-items:center;

    justify-content:center;

}



/* ورودی ها */

#step5 .form-control{

    border-radius:10px;

    height:50px;

}



/* دکمه ها */

#step5 .step-actions{

    display:flex;

    justify-content:space-between;

    margin-top:30px;

}
#step6 .review-card{

    background:#fff;

    border-radius:12px;

    padding:20px;

    margin-bottom:20px;

    border:1px solid #eee;

}


#step6 .review-card h5{

    border-bottom:1px solid #eee;

    padding-bottom:12px;

    margin-bottom:15px;

}


#step6 .review-row{

    display:flex;

    justify-content:space-between;

    padding:10px 0;

}


#step6 .review-actions{

    display:flex;

    justify-content:center;

    gap:15px;

    margin-top:30px;

}
/* دکمه های مرحله بازبینی */

#step6 .review-actions{

    display:flex;

    justify-content:center;

    align-items:center;

    gap:15px;

    margin-top:35px;

}


#step6 .review-btn{

    width:170px;

    height:48px;

    border-radius:10px;

    font-size:15px;

    cursor:pointer;

    border:1px solid #ddd;

}


#step6 .review-btn.secondary{

    background:#fff;

    color:#555;

}


#step6 .review-btn.dark{

    background:#333;

    color:#fff;

    border-color:#333;

}


#step6 .review-btn.primary{

    background:#198754;

    color:#fff;

    border-color:#198754;

}
/* =========================
   STEP 6 REVIEW
========================= */


#step6{

    max-width:900px;

    margin:30px auto;

}



.review-header-top{

    display:flex;
    justify-content:space-between;
    align-items:flex-start;

    padding-bottom:18px;
    margin-bottom:25px;

    border-bottom:2px solid #ddd;

}


.review-right{

    width:220px;

}

.review-logo{

    width:120px;
    display:block;
    margin-bottom:10px;

}
.install-code{

    font-size:14px;

}


.review-logo img{

    width:120px;

}



.review-header-info{

    text-align:right;

    line-height:2;

    font-size:14px;

}




.review-section{

    background:#fff;

    border-radius:10px;

    padding:20px;

    margin-bottom:15px;

    border:1px solid #eee;

}



.review-title{

    font-weight:bold;

    border-bottom:1px solid #eee;

    padding-bottom:10px;

    margin-bottom:10px;

}



.review-row{

    display:flex;

    justify-content:space-between;

    padding:8px 0;

}



.total-row{

    font-weight:bold;

    font-size:16px;

}



.review-footer{

    display:flex;

    justify-content:center;

    gap:15px;

    margin:30px 0;

}



.review-btn{

    min-width:120px;

    padding:10px 25px;

    border-radius:8px;

    border:1px solid #333;

    background:#fff;

}



.review-btn.dark{

    background:#222;

    color:#fff;

}



.review-btn.success{

    background:#222;

    color:#fff;

}
</style>
<div class="container-fluid">

<div class="prepare-wrapper">

{{-- Header نصب --}}
<div class="install-header">

    <button
        type="button"
        class="install-back-btn"
        onclick="prevStep()">

        <i class="bi bi-arrow-right"></i>

    </button>

    <div class="install-header-title">

        آماده سازی نصب

    </div>

</div>

{{-- مراحل نصب --}}

<div class="steps-header">



    <div class="steps-bar">

        <div class="step active">

            <div class="step-circle">
                1
            </div>

            فضا و ابعاد

        </div>

        <div class="step">

            <div class="step-circle">
                2
            </div>

            کف و چسب

        </div>

        <div class="step">

            <div class="step-circle">
                3
            </div>

            کارهای جانبی

        </div>

        <div class="step">

            <div class="step-circle">
                4
            </div>

            موارد خاص

        </div>

        <div class="step">

            <div class="step-circle">
                5
            </div>

            محل نصب

        </div>

        <div class="step">

            <div class="step-circle">
                6
            </div>

            بازبینی

        </div>

    </div> {{-- steps-bar --}}

</div> {{-- steps-header --}}

<div id="step1">

{{-- افزودن فضا --}}
<button
    type="button"
    class="add-space"
    data-bs-toggle="modal"
    data-bs-target="#spaceModal">

    + افزودن فضا

</button>


<!-- Modal انتخاب فضا -->
<div class="modal fade" id="spaceModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">


            <div class="modal-header">

                <h5 class="modal-title">
                    انتخاب فضا
                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>



            <div class="modal-body">


                <div class="space-search mb-3">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="spaceSearch"
                        class="form-control"
                        placeholder="جستجو">

                </div>



                <div class="space-list">


                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-house-door space-icon"></i>

                            <span class="space-name">
                                پذیرایی
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="پذیرایی">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-house space-icon"></i>

                            <span class="space-name">
                                هال
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="هال">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-bed space-icon"></i>

                            <span class="space-name">
                                اتاق خواب
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="اتاق خواب">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-stars space-icon"></i>

                            <span class="space-name">
                                اتاق خواب مستر
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="اتاق خواب مستر">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-cup-hot space-icon"></i>

                            <span class="space-name">
                                آشپزخانه
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="آشپزخانه">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-door-open space-icon"></i>

                            <span class="space-name">
                                راهرو
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="راهرو">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-ladder space-icon"></i>

                            <span class="space-name">
                                راه پله
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="راه پله">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-box-seam space-icon"></i>

                            <span class="space-name">
                                انباری
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="انباری">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-sun space-icon"></i>

                            <span class="space-name">
                                بالکن
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="بالکن">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-droplet space-icon"></i>

                            <span class="space-name">
                                حمام
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="حمام">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-building space-icon"></i>

                            <span class="space-name">
                                سرویس بهداشتی
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="سرویس بهداشتی">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-briefcase space-icon"></i>

                            <span class="space-name">
                                دفتر کار
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="دفتر کار">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-people space-icon"></i>

                            <span class="space-name">
                                سالن اجتماعات
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="سالن اجتماعات">

                    </label>



                    <label class="space-item">

                        <div class="space-info">

                            <i class="bi bi-three-dots space-icon"></i>

                            <span class="space-name">
                                سایر
                            </span>

                        </div>


                        <input
                            type="checkbox"
                            class="space-check"
                            name="space"
                            value="سایر">

                    </label>


                </div>


            </div>
            <!-- پایان modal-body -->


            <div class="modal-footer">


                <button
                    type="button"
                    class="btn btn-danger"
                    id="addSelectedSpaces">

                    افزودن

                </button>


            </div>
            <!-- پایان modal-footer -->


        </div>
        <!-- پایان modal-content -->


    </div>
    <!-- پایان modal-dialog -->


</div>
<!-- پایان modal -->



{{-- لیست فضاهای انتخاب شده --}}
<div id="spaces-container">

</div>
<div id="bottom-add-space"></div>

{{-- اطلاعات پروژه --}}

<div class="project-info">

    <div class="project-row">

        <span>
            متراژ کل پروژه
        </span>


        <b id="total-area">
            0 متر مربع
        </b>

    </div>


    <div class="text-danger mt-2">

        حداقل نصب 30 متر مربع

    </div>


</div>



{{-- هزینه نصب --}}

<div class="install-price">

    هزینه نصب :

    <b id="install-price">

        0 ریال

    </b>

</div>

</div> {{-- پایان step1 --}}

<div class="mt-4 text-start">


    <button
        type="button"
        class="next-btn"
        onclick="nextStep()">

        بعدی

    </button>


</div>


<div id="step2" class="d-none">

    <div class="step-card">

        <div class="floor-wrapper">

            {{-- ================= ستون راست ================= --}}
            <div class="right-panel">
        {{-- ================= کف ================= --}}

        <div id="floorList">

            <div class="floor-row" data-index="0">

                <label class="form-label">
                    نوع کف
                </label>

                <select
                    class="form-select floor-type"
                    name="floors[0][type]">

                    <option>
                        عادی (سنگ، سرامیک، لمینت، پارکت، موزاییک)
                    </option>

                    <option>
                        سیمان
                    </option>

                    <option>
                        موکت
                    </option>

                </select>


                <label class="form-check">

                    <input
                        type="checkbox"
                        class="form-check-input normal-floor">

                    <span>
                        کف به طور کامل عادی است
                    </span>

                </label>

            </div>

        </div>


        <button
            id="addFloor"
            type="button"
            class="btn-add mt-3">

            افزودن کف

        </button>


     {{-- ================= چسب ================= --}}

<div id="glueList">

    <div class="glue-item">

        <label class="form-label">
            نوع سطح
        </label>

        <select class="form-select">

            <option>
                صاف
            </option>

            <option>
                ناهموار
            </option>

        </select>

        <div class="glue-row">

            <div class="glue-select-box">

                <label class="form-label mt-3">
                    نوع چسب
                </label>

                <select class="form-select glue-type">

                    <option value="none">
                        بدون چسب
                    </option>

                    <option value="edge">
                        دور چسب
                    </option>

                    <option value="full">
                        تمام چسب
                    </option>

                    <option value="double_25">
                        چسب دوطرف 25 متری
                    </option>

                    <option value="water_soluble">
                        چسب حلال آب
                    </option>

                </select>

            </div>


            <div class="glue-number-box d-none">

                <label class="form-label mt-3">
                    تعداد
                </label>

                <input
                    type="number"
                    class="form-control glue-count"
                    value="1"
                    min="1">

            </div>

        </div>

    </div>

</div>
<button
    type="button"
    id="addGlue"
    class="btn-add mt-3">

    افزودن چسب

</button>
<div class="price-box mt-4">

    <div class="price-title">
        هزینه چسب
    </div>

    <div
        id="gluePrice"
        class="price-value">

        0 ریال

    </div>

</div>
{{-- ================= پله ================= --}}

<div class="stairs-area mt-5">

    <label class="form-label fw-bold">
        آیا پله دارد؟
    </label>

<div class="extra-radio mt-3">


    <label class="radio-card">

        <input
            type="radio"
           name="has_stairs"
            value="0"
            checked>

        <span class="radio-circle"></span>

        خیر

    </label>



    <label class="radio-card">

        <input
            type="radio"
           name="has_stairs"
            value="1">

        <span class="radio-circle"></span>

        بله

    </label>


</div>


    <div
        id="stairsBox"
        class="d-none mt-4">


        <div class="mb-3">

            <label class="form-label">
                تعداد پله صاف
            </label>

            <input
                type="number"
                class="form-control"
                value="0">

        </div>


        <div class="mb-3">

            <label class="form-label">
                تعداد پله لبه‌دار
            </label>

            <input
                type="number"
                class="form-control"
                value="0">

        </div>


        <div class="mb-3">

            <label class="form-label">
                تعداد پله گردان
            </label>

            <input
                type="number"
                class="form-control"
                value="0">

        </div>


    </div>

</div>
 
{{-- ================= هزینه کف و چسب ================= --}}

<div class="price-box mt-5">

    <div class="price-title">
        هزینه کف و چسب
    </div>

    <div
        id="floorPrice"
        class="price-value">

        0 ریال

    </div>

</div>


</div>
{{-- پایان right-panel --}}




    {{-- ================= ستون چپ ================= --}}

    <div class="left-panel">


        <div id="floorMeters">


            <div
                class="meter-item"
                data-index="0">


                <label class="form-label">

                    متراژ دقیق کف

                </label>


                <input
                    type="number"
                    class="form-control floor-meter"
                    name="floors[0][meter]"
                    value="0">


            </div>


        </div>


    </div>
    {{-- پایان left-panel --}}



</div>
{{-- پایان floor-wrapper --}}


<div class="step-actions mt-5">

    <button
        type="button"
        class="btn btn-outline-secondary"
        onclick="prevStep()">

        قبلی

    </button>

    <button
        type="button"
        class="next-btn"
        onclick="nextStep()">

        بعدی

    </button>

</div>

</div>

</div>
<div id="step3" class="d-none">

    <div class="step-card">


        <div class="fish-section">


            <div class="question-row">

                <label>
                    نیاز به گرده ماهی دارد؟
                </label>


                <div class="radio-box">

                    <label>
                        <input 
                            type="radio"
                            name="fish_need"
                            value="yes"
                            checked
                            onchange="toggleFish(true)">
                        بله
                    </label>


                    <label>
                        <input 
                            type="radio"
                            name="fish_need"
                            value="no"
                            onchange="toggleFish(false)">
                        خیر
                    </label>

                </div>

            </div>



            <div id="fishFields">


                <div id="fishList">


                    <div class="fish-row">


                        <div class="fish-right">

                            <label>
                                نوع گرده ماهی
                            </label>

                            <select class="form-control">

                                <option>
                                    طلایی
                                </option>

                                <option>
                                    نقره‌ای
                                </option>

                                <option>
                                    چوبی
                                </option>

                                <option>
                                    سایر
                                </option>

                            </select>

                        </div>



                        <div class="fish-left">

                            <label>
                                طول شاخه گرده ماهی
                            </label>

                            <input 
type="number"
class="form-control fish-length"
min="1"
step="1"
oninput="calculateFish()">

                        </div>


                    </div>



                    <div class="fish-row">


                        <div class="fish-right">

                            <label>
                                تعداد شاخه گرده ماهی
                            </label>

                           <input 
type="number"
class="form-control fish-count"
min="1"
step="1"
oninput="calculateFish()">

                        </div>



                        <div class="fish-left">

                            <label>
                                متراژ کل گرده ماهی
                            </label>

                            <input 
                             class="form-control fish-total"
                             value="0 متر طول"
                             readonly>

                        </div>


                    </div>


                </div>



               <button
    type="button"
    id="addFish"
    class="add-fish-btn">

    افزودن گرده ماهی جدید

</button>


                <div class="price-row">

                    مبلغ:
                    <span>
                        0 ریال
                    </span>

                </div>


            </div>


        </div>



        <hr>



        <!-- بخش دوم بعداً اضافه می‌شود -->
        <div class="cut-section">

            <div class="question-row">

                <label>
                    پریز کف خواب دارد؟
                </label>


                <div class="radio-box">

                   <label>

    <input
        type="radio"
        name="cut_floor"
        value="yes"
        onchange="toggleCut(true)">

    بله

</label>

<label>

    <input
        type="radio"
        name="cut_floor"
        value="no"
        checked
        onchange="toggleCut(false)">

    خیر

</label>

                </div>

            </div>

        </div>


 <!-- اینجا قرار بده -->
<div id="cutFields" class="d-none mt-3">

    <div class="fish-row">

        <div class="fish-right">

            <label>
                تعداد پریز کف خواب
            </label>

            <input
                type="number"
                class="form-control"
                value="0"
                min="0">

        </div>

        <div class="fish-left">

        </div>

    </div>

    <div class="price-row">

        مبلغ:
        <span>0 ریال</span>

    </div>

</div>

</div>
        <div class="step-actions">

            <button
                type="button"
                class="btn btn-outline-secondary"
                onclick="prevStep()">

                قبلی

            </button>


            <button
                type="button"
                class="next-btn"
                onclick="nextStep()">

                بعدی

            </button>

        </div>


    </div>

</div>
<div id="step4" class="d-none">

    <div class="step-card">

        <div class="special-section">

            <label class="form-label fw-bold">
                موارد خاص نصب
            </label>

            <div class="special-list">

                <label class="special-item">
                    <span>برشکاری خاص</span>
                    <input type="checkbox" class="form-check-input">
                </label>

                <label class="special-item">
                    <span>میز بیلیارد</span>
                    <input type="checkbox" class="form-check-input">
                </label>

                <label class="special-item">
                    <span>میز جزیره</span>
                    <input type="checkbox" class="form-check-input">
                </label>

                <label class="special-item">
                    <span>نصب دیواری</span>
                    <input type="checkbox" class="form-check-input">
                </label>

            </div>

        </div>
<div class="mt-4">

    <label class="form-label">
        توضیحات
    </label>

<textarea
    class="form-control special-description"
    rows="3"
    placeholder="توضیحات مربوط به موارد خاص را وارد کنید..."></textarea>

</div>

<div class="special-bottom-row">

    <div>

        <label class="form-label">
            تصاویر
        </label>

        <label
            for="specialImages"
            class="upload-box">

            <span class="upload-text">
                افزودن عکس
            </span>

            <i class="bi bi-plus-lg upload-icon"></i>

        </label>

        <input
            type="file"
            id="specialImages"
            name="special_images[]"
            accept="image/*"
            multiple
            hidden>

    </div>
<div id="specialPreview" class="special-preview"></div>

    <div>

        <label class="form-label">
            مبلغ پیشنهادی
        </label>

        <input
            type="number"
            class="form-control"
            placeholder="0">

    </div>

</div>

<div class="step-actions">

    <button
        type="button"
        class="btn btn-outline-secondary"
        onclick="prevStep()">

        قبلی

    </button>

    <button
        type="button"
        class="next-btn"
        onclick="nextStep()">

        بعدی

    </button>

</div>
    </div>

</div>
<div id="step5" class="d-none">

    <div class="step-card">

        <div class="install-location-section">

            <label class="form-label fw-bold">
                محل نصب
            </label>


{{-- ========================================= --}}
{{-- حمل به طبقات --}}
{{-- ========================================= --}}

<div class="step5-section">

    <div class="step5-row">

        <div class="step5-title">

            <label class="checkbox-card">

                <input
                    type="checkbox"
                    id="hasFloorCarry">

                <span></span>

                آیا حمل به طبقات دارد؟

            </label>

            <div class="item-price mt-2">

                هزینه حمل طبقات :

                <b id="floorCarryPrice">

                    0 ریال

                </b>

            </div>

        </div>

        <div class="step5-action">

            <div class="floating-box">

                <input
                    type="number"
                    id="floorCount"
                    class="form-control"
                    value="0"
                    min="0"
                    disabled>

                <label>

                    تعداد طبقات

                </label>

            </div>

        </div>

    </div>

</div>


<hr class="step-divider">


{{-- ========================================= --}}
{{-- آسانسور --}}
{{-- ========================================= --}}

<div class="step5-section">

    <div class="step5-row">

        <div class="step5-title">

            <label class="checkbox-card">

                <input
                    type="checkbox"
                    id="hasElevator">

                <span></span>

                آیا آسانسور دارد؟

            </label>

        </div>

        <div
            class="step5-action"
            id="elevatorTypeBox">

            <label class="radio-card">

                <input
                    type="radio"
                    name="elevatorType"
                    value="person"
                    disabled>

                <span class="radio-circle"></span>

                آسانسور نفربر

            </label>

            <label class="radio-card">

                <input
                    type="radio"
                    name="elevatorType"
                    value="cargo"
                    disabled>

                <span class="radio-circle"></span>

                آسانسور باربر

            </label>

        </div>

    </div>

</div>


<hr class="step-divider">


{{-- ========================================= --}}
{{-- تمیزی محل --}}
{{-- ========================================= --}}

<div class="step5-section">

    <div class="step5-row">

        <div class="step5-title">

            آیا محل نصب بدون اثاث و تمیز است؟

        </div>

        <div class="step5-action">

            <label class="radio-card">

                <input
                    type="radio"
                    name="cleanPlace"
                    value="yes">

                <span class="radio-circle"></span>

                بله

            </label>

            <label class="radio-card">

                <input
                    type="radio"
                    name="cleanPlace"
                    value="no">

                <span class="radio-circle"></span>

                خیر

            </label>

        </div>

    </div>


    <div
        id="workerBox"
        class="worker-section d-none">

        <div class="floating-box">

            <input
                type="number"
                class="form-control worker-input"
                value="1">

            <label>

                تعداد کارگر

            </label>

        </div>

        <div class="item-price mt-3">

            هزینه کارگر :

            <b id="workerPrice">

                0 ریال

            </b>

        </div>

    </div>

</div>


<hr class="step-divider">


{{-- ========================================= --}}
{{-- نیاز به حمل --}}
{{-- ========================================= --}}

<div class="step5-section">

    <div class="step5-row">

        <div class="step5-title">

            آیا نیاز به حمل دارد؟

        </div>

        <div class="step5-action">

            <label class="radio-card">

                <input
                    type="radio"
                    name="needCarry"
                    value="yes">

                <span class="radio-circle"></span>

                بله

            </label>

            <label class="radio-card">

                <input
                    type="radio"
                    name="needCarry"
                    value="no"
                    checked>

                <span class="radio-circle"></span>

                خیر

            </label>

        </div>

    </div>

</div>


<hr class="step-divider">
{{-- ========================================= --}}
{{-- لوکیشن --}}
{{-- ========================================= --}}

<div class="step5-section">

    <div class="step5-row">

        <div class="step5-title">

            <label class="checkbox-card">

                <input
                    type="checkbox"
                    id="locationBox">

                <span></span>

                وارد کردن لوکیشن

            </label>

        </div>

        <div class="step5-action">

        </div>

    </div>

</div>


<div id="locationSection" class="step5-location">

    <div class="step5-section mt-3">

        <div class="step5-row">

            <div class="step5-title">

            </div>

            <div class="step5-action vertical-radio">

                <label class="radio-card">

                    <input
                        type="radio"
                        id="locationStaff"
                        name="locationType"
                        value="staff"
                        checked>

                    <span class="radio-circle"></span>

                    توسط پرسنل

                </label>

                <label class="radio-card">

                    <input
                        type="radio"
                        id="locationSms"
                        name="locationType"
                        value="sms">

                    <span class="radio-circle"></span>

                    ارسال مجدد SMS

                </label>

            </div>

        </div>

    </div>


    <div id="staffLocationSection">

        <div class="step5-section">

            <label class="form-label">

                جستجوی شهر

            </label>

            <input
                class="form-control"
                placeholder="نام شهر">

        </div>


        <div class="step5-section mt-3">

            <label class="form-label">

                جستجوی محله

            </label>

            <input
                class="form-control"
                placeholder="نام محله">

        </div>


        <div class="step5-section mt-3">

            <div class="map-box">

                نقشه

            </div>

        </div>


        <div class="step5-section mt-3">

            <label class="form-label">

                هزینه ایاب و ذهاب

            </label>

            <input
                class="form-control"
                value="0 ریال"
                readonly>

        </div>


        <div class="step5-section mt-3">

            <label class="form-label">

                آدرس پستی انتخاب شده

            </label>

            <textarea
                class="form-control"
                rows="4"></textarea>

        </div>


        <div class="step5-section mt-3">

            <div class="row">

                <div class="col-md-4">

                    <input
                        class="form-control"
                        placeholder="پلاک">

                </div>

                <div class="col-md-4">

                    <input
                        class="form-control"
                        placeholder="واحد">

                </div>

                <div class="col-md-4">

                    <input
                        class="form-control"
                        placeholder="کد پستی">

                </div>

            </div>

        </div>

    </div>


    <div
        id="smsLocationSection"
        class="d-none mt-4">

        <button
            type="button"
            class="btn btn-primary">

            ارسال مجدد لینک لوکیشن

        </button>

    </div>

</div>


<hr class="step-divider">


<div class="step5-section">

    <label class="form-label">

        هزینه نهایی محل نصب

    </label>

    <input
        class="form-control"
        value="0 ریال"
        readonly>

</div>
</div>  {{-- پایان step5 --}}

{{-- ========================================= --}}
{{-- نماینده --}}
{{-- ========================================= --}}

<div class="step5-section mt-4">

    <label class="checkbox-card">

        <input
            type="checkbox"
            id="agentBox">

        <span></span>

        نماینده من جهت توضیحات در محل نصب

    </label>


    <div
        id="agentSection"
        class="row mt-3 d-none">


        <div class="col-md-6">

            <input
                class="form-control"
                placeholder="نام نماینده">

        </div>


        <div class="col-md-6">

            <input
                class="form-control"
                placeholder="شماره نماینده">

        </div>


    </div>

</div>



<div class="step-actions mt-4">


    <button
        type="button"
        class="btn btn-outline-secondary"
        onclick="prevStep()">

        قبلی

    </button>


    <button
        type="button"
        class="next-btn"
        onclick="nextStep()">

        بعدی

    </button>


</div>

</div>   {{-- پایان step-card --}}

</div>   {{-- پایان step5 --}}


<div id="step6" class="d-none">


<div class="review-header-top">

    {{-- سمت راست --}}
    <div class="review-right">

        <img src="{{ asset('images/logo.png') }}" class="review-logo">

        <div class="install-code">
            کد نصب موکت :
            <b>PLZ...</b>
        </div>

    </div>


    {{-- وسط --}}
    <div class="review-center">

        خلاصه اطلاعات نصب

    </div>


    {{-- سمت چپ --}}
    <div class="review-left">

        <div>

            تاریخ چاپ :
            <b>-</b>

            &nbsp;&nbsp;

            ساعت :
            <b>-</b>

        </div>

        <div>

            شعبه :
            <b>-</b>

            |

            شماره مشتری :
            <b>-</b>

        </div>

    </div>

</div>


    {{-- محل نصب --}}
    <div class="review-section">


        <div class="review-title">
            محل نصب
        </div>



        <div class="review-row">
            <span>حمل به طبقات</span>
            <b>-</b>
        </div>


        <div class="review-row">
            <span>آسانسور</span>
            <b>-</b>
        </div>


        <div class="review-row">
            <span>تمیزی محل</span>
            <b>-</b>
        </div>


        <div class="review-row">
            <span>نماینده</span>
            <b>-</b>
        </div>


    </div>





    {{-- فضاهای نصب --}}
    <div class="review-section">


        <div class="review-title">
            فضاهای نصب
        </div>



        <div id="reviewSpaces">


            هنوز اطلاعاتی ثبت نشده


        </div>


    </div>





    {{-- هزینه --}}
    <div class="review-section">


        <div class="review-title">
            جمع هزینه
        </div>



        <div class="review-row">
            <span>هزینه نصب</span>
            <b>0 ریال</b>
        </div>


        <div class="review-row">
            <span>هزینه کف و چسب</span>
            <b>0 ریال</b>
        </div>


        <div class="review-row">
            <span>کارهای جانبی</span>
            <b>0 ریال</b>
        </div>


        <div class="review-row total-row">

            <span>
                هزینه نهایی نصب
            </span>

            <b>
                0 ریال
            </b>

        </div>


    </div>





    {{-- دکمه ها --}}
    <div class="review-footer">


        <button class="review-btn">
            پرینت خلاصه
        </button>


        <button class="review-btn">
            پرینت قوانین
        </button>


        <button class="review-btn dark">
            ذخیره
        </button>


        <button class="review-btn success">
            تایید نهایی
        </button>


    </div>



</div>
<script>
    // ======================================
// محاسبه گرده ماهی
// ======================================

function calculateFish(){

    let length = parseInt(
        document.querySelector('.fish-length').value
    ) || 0;


    let count = parseInt(
        document.querySelector('.fish-count').value
    ) || 0;


    let total = length * count;


    document.querySelector('.fish-total').value =
        total + " متر طول";

}



// ======================================
// مدیریت کف و متراژ کف (مطابق پالاز)
// ======================================

let floorIndex = 1;

function getGluePrice(type){

    // بعداً از تنظیمات CRM خوانده می‌شود
    return 0;

}

function calculateGluePrice(){

    let total = 0;

    document.querySelectorAll('#glueList .glue-item').forEach(function(item){

        let type = item.querySelector('.glue-type').value;

        let count = 1;

        let countInput = item.querySelector('.glue-count');

        if(
            countInput &&
            !countInput.closest('.glue-number-box').classList.contains('d-none')
        ){
            count = parseInt(countInput.value) || 1;
        }

        total += getGluePrice(type) * count;

    });

    document.getElementById('gluePrice').innerHTML =
        total.toLocaleString() + ' ریال';

}
// ===============================
// نمایش و مخفی کردن گرده ماهی
// ===============================

function toggleFish(show){

    let box = document.getElementById('fishFields');

    if(!box) return;

    if(show){
        box.classList.remove('d-none');
    }else{
        box.classList.add('d-none');
    }

}
function toggleCut(show){

    const box = document.getElementById('cutFields');

    if(!box) return;

    if(show){
        box.classList.remove('d-none');
    }else{
        box.classList.add('d-none');
    }

}
document.addEventListener('DOMContentLoaded', function () {


const addFloorBtn = document.getElementById('addFloor');

if(addFloorBtn){

    addFloorBtn.addEventListener('click', function(){


        let floorList = document.getElementById('floorList');

       



        // ======================
        // ساخت کف جدید
        // ======================

        let floor = document.createElement('div');

floor.className = 'floor-row';
        floor.dataset.index = floorIndex;


      floor.innerHTML = `

<label class="form-label">
    نوع کف
</label>

<div class="floor-select-row">

    <select
        class="form-select floor-type"
        name="floors[${floorIndex}][type]">

        <option value="normal">
            عادی (سنگ، سرامیک، لمینت، پارکت، موزاییک)
        </option>

        <option value="cement">
            سیمان
        </option>

        <option value="moquette">
            موکت
        </option>

    </select>


    <button
        type="button"
        class="floor-delete">

        <i class="bi bi-trash"></i>

    </button>


</div>


<div class="form-check">

    <input
        type="checkbox"
        class="form-check-input normal-floor"
        name="floors[${floorIndex}][normal]"
        value="1"
        checked>

    <label class="form-check-label">
        کف به طور کامل عادی است
    </label>

</div>

<div class="floor-placeholder"></div>

`;


        floorList.appendChild(floor);



        // ======================
        // ساخت متراژ متناظر
        // ======================


let meter = document.createElement('div');

meter.className = 'meter-item';
meter.dataset.index = floorIndex;

meter.innerHTML = `
<div class="meter-placeholder"></div>

<label class="form-label">
    متراژ دقیق کف
</label>

<input
    type="number"
    class="form-control floor-meter"
    name="floors[${floorIndex}][meter]"
    value="0">
`;

document.getElementById('floorMeters').appendChild(meter);



        floorIndex++;


    });

}



// ======================================
// نمایش یا مخفی کردن متراژ
// ======================================

document.addEventListener('change', function(e){

    if(e.target.classList.contains('normal-floor')){

        let row = e.target.closest('.floor-row');

        let meterBox = row.querySelector('.meter-box');


        if(meterBox){

            meterBox.classList.toggle(
                'd-none',
                e.target.checked
            );

        }

    }

});
// ======================================
// حذف کف
// ======================================


document.addEventListener('click', function(e){


    let btn = e.target.closest('.floor-delete');


    if(!btn) return;



    let floor =
        btn.closest('.floor-row');



    let index =
        floor.dataset.index;



    let meter =
        document.querySelector(
            `.meter-item[data-index="${index}"]`
        );



    floor.remove();



    if(meter){

        meter.remove();

    }


});
    // ==========================
    // گزینه‌های ابعاد طاقه
    // ==========================

    let rollOptions = `
        <option value="0">انتخاب ابعاد طاقه</option>
    `;

    for(let i=1;i<=15;i++){

        rollOptions += `
            <option value="3x${i}">
                3 × ${i}
            </option>
        `;

    }

    for(let i=1;i<=15;i++){

        rollOptions += `
            <option value="4x${i}">
                4 × ${i}
            </option>
        `;

    }


   //=====================================
// افزودن فضا (نسخه تمیز)
//=====================================

const addSpaceBtn = document.getElementById('addSelectedSpaces');

if(addSpaceBtn){

    addSpaceBtn.addEventListener('click', function(e){
        console.log('STEP 1');

        e.preventDefault();


        let selected = document.querySelector('.space-check:checked');
        console.log('STEP 2', selected);


        if(!selected){

            alert('لطفاً یک فضا انتخاب کنید');

            return;

        }


        let name = selected.value;


        let container = document.getElementById('spaces-container');
        console.log('STEP 3', container);


        // جلوگیری از تکرار
        if(container.querySelector('[data-space="'+name+'"]')){

            selected.checked = false;

            return;

        }


        let card = document.createElement('div');


        card.className = 'space-card';

        card.dataset.space = name;


        card.innerHTML = `

<div class="space-header">

    <div class="space-title">
        ${name}
    </div>


    <button
        type="button"
        class="delete-space">

        <i class="bi bi-trash"></i>

    </button>

</div>


<div class="space-content">


<div class="roll-list">


<div class="roll-item">


<div class="roll-row">


<div class="roll-size-box">

<label>ابعاد طاقه</label>

<select class="form-select roll-size">

${rollOptions}

</select>

</div>



<div class="roll-count-box">

<label>تعداد طاقه اول</label>

<input
type="number"
class="form-control roll-count"
value="1"
min="1">

</div>


</div>


</div>


</div>



<div class="pile-box">

<div class="pile-header">

<div class="field-title">
انتخاب نوع موکت این فضا
</div>


<div class="pile-options">

<label>
<input type="radio" name="pile_${name}" checked>
پرز کوتاه
</label>


<label>
<input type="radio" name="pile_${name}">
پرز بلند
</label>


</div>


</div>

</div>



<div class="space-footer">


<button
type="button"
class="add-roll">

افزودن طاقه

</button>



<button
type="button"
class="remove-last-roll">

حذف طاقه

</button>



<div class="footer-box">

<span>
متراژ کل
</span>


<b class="space-area">
0 متر مربع
</b>


</div>


</div>


</div>

`;


        container.appendChild(card);
        console.log('STEP 4');

let bottomAdd = document.getElementById('bottom-add-space');

bottomAdd.innerHTML = `

<button
type="button"
class="add-space"
data-bs-toggle="modal"
data-bs-target="#spaceModal">

+ افزودن فضا

</button>

`;

        // پاک کردن تیک
        selected.checked = false;



        // بستن مودال
        let modalElement = document.getElementById('spaceModal');


        if(modalElement){

            let modal = bootstrap.Modal.getOrCreateInstance(modalElement);

            modal.hide();

        }

setTimeout(function(){

    selected.checked = false;

},300);

        calculateTotal();


    });


}
// فقط یک فضای قابل انتخاب در مودال
document.addEventListener('change', function(e){

    if(e.target.classList.contains('space-check')){

        document.querySelectorAll('.space-check').forEach(function(item){

            if(item !== e.target){

                item.checked = false;

            }

        });

    }

});

//=====================================
// افزودن طاقه
//=====================================

document.addEventListener('click', function (e) {

    const btn = e.target.closest('.add-roll');

    if (!btn) return;

    const list = btn
        .closest('.space-card')
        .querySelector('.roll-list');

    const count = list.querySelectorAll('.roll-item').length + 1;
    const names = [
    "",
    "اول",
    "دوم",
    "سوم",
    "چهارم",
    "پنجم",
    "ششم",
    "هفتم",
    "هشتم",
    "نهم",
    "دهم",
    "یازدهم",
    "دوازدهم",
    "سیزدهم",
    "چهاردهم",
    "پانزدهم"
];

const title = names[count] ?? count;

    const item = document.createElement('div');

item.className = 'roll-item';

item.innerHTML = `

<div class="roll-row">

    <div class="roll-size-box">

        <label>ابعاد طاقه</label>

        <select class="form-select roll-size">
            ${rollOptions}
        </select>

    </div>


    <div class="roll-count-box">

        <label>تعداد طاقه ${title}</label>

        <input
            type="number"
            class="form-control roll-count"
            value="1"
            min="1">

    </div>

</div>

`;

list.appendChild(item);

calculateTotal();

});

// حذف آخرین طاقه

document.addEventListener('click',function(e){

    let btn = e.target.closest('.remove-last-roll');

    if(!btn) return;


    let list = btn
        .closest('.space-card')
        .querySelector('.roll-list');


    let items = list.querySelectorAll('.roll-item');


    // حداقل یک طاقه باقی بماند

    if(items.length <= 1){

        return;

    }


    items[items.length - 1].remove();


    calculateTotal();


});





//=====================================
// حذف فضا
//=====================================

document.addEventListener('click',function(e){

    let btn = e.target.closest('.delete-space');

    if(!btn) return;

    btn.closest('.space-card').remove();

    calculateTotal();

});




//=====================================
// تغییر ابعاد و تعداد
//=====================================

document.addEventListener('input',function(e){

    if(
        e.target.classList.contains('roll-size') ||
        e.target.classList.contains('roll-count')
    ){

        calculateTotal();

    }

});




//=====================================
// محاسبه متراژ
//=====================================

function calculateTotal(){

    let total = 0;

    document.querySelectorAll('.space-card').forEach(card=>{

        let area = 0;

        card.querySelectorAll('.roll-item').forEach(item=>{

            let select = item.querySelector('.roll-size');

            if(select.value=="0") return;

            let count =
                parseInt(item.querySelector('.roll-count').value) || 1;

            let data = select.value.split('x');

            let width  = parseInt(data[0]);

            let length = parseInt(data[1]);

            area += width * length * count;

        });

        card.querySelector('.space-area').innerHTML =
            area + ' متر مربع';

        total += area;

    });

    document.getElementById('total-area').innerHTML =
        total + ' متر مربع';

    const pricePerMeter = 385000;

    document.getElementById('install-price').innerHTML =
        (total * pricePerMeter).toLocaleString() + ' ریال';

}


let currentStep = 1;

function showStep(step){

    document.querySelectorAll('[id^="step"]').forEach(el=>{
        el.classList.add('d-none');
    });

    document.getElementById('step' + step).classList.remove('d-none');

    document.querySelectorAll('.steps-bar .step').forEach((item,index)=>{
        item.classList.remove('active');

        if(index + 1 == step){
            item.classList.add('active');
        }
    });

    if(step == 6){
        loadReviewSpaces();
    }

    currentStep = step;
}


function nextStep(){

    if(currentStep < 6){
        showStep(currentStep + 1);
    }

}
function prevStep(){

    if(currentStep>1){
        showStep(currentStep-1);
    }

}
window.nextStep = nextStep;
window.prevStep = prevStep;
document.querySelectorAll('input[name="has_stairs"]').forEach(radio => {

    radio.addEventListener('change', function () {

        let box = document.getElementById('stairsBox');

        if(this.value === '1'){

            box.classList.remove('d-none');

        }else{

            box.classList.add('d-none');

        }

    });

});
// ======================================
// نمایش متراژ کف با تیک عادی بودن
// ======================================

document.addEventListener('change', function(e){

    if(e.target.classList.contains('normal-floor')){


        let floor = e.target.closest('.floor-row');


        if(!floor) return;


        let index = floor.dataset.index;


        let meter = document.querySelector(
            '.meter-item[data-index="'+index+'"]'
        );


        if(meter){

            if(e.target.checked){

meter.style.visibility = 'hidden';
            }else{

meter.style.visibility = 'visible';            }

        }


    }

});
document.addEventListener('change', function(e){


    if(e.target.classList.contains('glue-type')){


        let row = e.target.closest('.glue-row');

        let box = row.querySelector('.glue-number-box');


        if(
            e.target.value === 'double_25' ||
            e.target.value === 'water_soluble'
        ){

            box.classList.remove('d-none');

        }else{
            

            box.classList.add('d-none');

        }
calculateGluePrice();

    }


});
// ======================================
// افزودن چسب
// ======================================

const addGlueBtn = document.getElementById('addGlue');

if(addGlueBtn){

    addGlueBtn.addEventListener('click', function(){

        let item = document.createElement('div');

        item.className = 'glue-item mt-4';

item.innerHTML = `

<div class="glue-row">

    <div class="glue-select-box">

        <label class="form-label mt-3">
            نوع چسب
        </label>

        <select class="form-select glue-type">

            <option value="none">بدون چسب</option>
            <option value="edge">دور چسب</option>
            <option value="full">تمام چسب</option>
            <option value="double_25">چسب دوطرف 25 متری</option>
            <option value="water_soluble">چسب حلال آب</option>

        </select>

    </div>
<button
    type="button"
    class="floor-delete glue-delete">

    <i class="bi bi-trash"></i>

</button>
    <div class="glue-number-box d-none">

        <label class="form-label mt-3">
            تعداد
        </label>

        <input
            type="number"
            class="form-control glue-count"
            value="1"
            min="1">

    </div>

</div>

`;

        document.getElementById('glueList').appendChild(item);

    });
    calculateGluePrice();

}
// ======================================
// حذف چسب
// ======================================

document.addEventListener('click', function(e){

    let btn = e.target.closest('.glue-delete');

    if(!btn) return;

    let item = btn.closest('.glue-item');

    // حداقل یک چسب باقی بماند
    if(document.querySelectorAll('#glueList .glue-item').length <= 1){
        return;
    }

    item.remove();

});

function toggleCut(status){

    let box = document.getElementById('cutFields');

    if(!box) return;

    if(status){

        box.style.display = 'block';

    }else{

        box.style.display = 'none';

    }

}
// ======================================
// افزودن گرده ماهی
// ======================================

const addFishBtn = document.getElementById('addFish');

if(addFishBtn){

    addFishBtn.addEventListener('click', function(){

        let row = document.createElement('div');

        row.className = 'fish-item mt-4';

        row.innerHTML = `

<div class="fish-row">

    <div class="fish-right">

        <label>
            نوع گرده ماهی
        </label>

        <select class="form-control">

            <option>طلایی</option>
            <option>نقره‌ای</option>
            <option>چوبی</option>
            <option>سایر</option>

        </select>

    </div>

    <div class="fish-left">

        <label>
            طول شاخه گرده ماهی
        </label>

        <input
            type="number"
            class="form-control fish-length"
            min="1"
            value="0"
            oninput="calculateFish()">

    </div>

</div>

<div class="fish-row mt-3">

    <div class="fish-right">

        <label>
            تعداد شاخه گرده ماهی
        </label>

        <input
            type="number"
            class="form-control fish-count"
            min="1"
            value="0"
            oninput="calculateFish()">

    </div>

    <div class="fish-left">

        <label>
            متراژ کل گرده ماهی
        </label>

        <input
            class="form-control fish-total"
            value="0 متر طول"
            readonly>

    </div>

</div>

<button
    type="button"
    class="floor-delete fish-delete mt-3">

    <i class="bi bi-trash"></i>

</button>

`;

        document.getElementById('fishList').appendChild(row);

    });

}
// ======================================
// حذف گرده ماهی
// ======================================

document.addEventListener('click', function(e){

    let btn = e.target.closest('.fish-delete');

    if(!btn) return;

    btn.closest('.fish-item').remove();

    calculateFish();

});
});   // پایان DOMContentLoaded
// فقط یک فضا قابل انتخاب باشد
document.addEventListener('change', function(e){

    if(e.target.matches('.space-check')){

        if(e.target.checked){

            document.querySelectorAll('.space-check').forEach(function(item){

                if(item !== e.target){

                    item.checked = false;

                }

            });

        }

    }

});
const specialImages = document.getElementById('specialImages');
const specialPreview = document.getElementById('specialPreview');


if(specialImages){

    specialImages.addEventListener('change', function(){

        specialPreview.innerHTML = '';

        Array.from(this.files).forEach(file=>{

            let reader = new FileReader();


            reader.onload=function(e){

                let div=document.createElement('div');

                div.className='preview-item';


                div.innerHTML=`

                    <img src="${e.target.result}">

                    <button 
                    type="button"
                    class="preview-remove">
                    ×
                    </button>

                `;


                specialPreview.appendChild(div);

            }


            reader.readAsDataURL(file);

        });


    });

}
const floorCheck = document.getElementById('hasFloorCarry');
const floorInput = document.getElementById('floorCount');

if(floorCheck && floorInput){

    floorCheck.addEventListener('change', function(){

        if(this.checked){

            floorInput.disabled = false;
            floorInput.value = 1;

        }else{

            floorInput.disabled = true;
            floorInput.value = 0;

        }

    });

}
// =============================
// آسانسور روشن و خاموش
// =============================

const elevatorCheck = document.getElementById('hasElevator');
const elevatorBox = document.getElementById('elevatorTypeBox');

const elevatorRadios = document.querySelectorAll(
    'input[name="elevatorType"]'
);


if(elevatorCheck && elevatorBox){

    elevatorCheck.addEventListener('change', function(){

        if(this.checked){

            elevatorBox.classList.add('active');

            elevatorRadios.forEach(function(radio){

                radio.disabled = false;

            });


        }else{

            elevatorBox.classList.remove('active');

            elevatorRadios.forEach(function(radio){

                radio.disabled = true;

                radio.checked = false;

            });

        }

    });

}
const cleanYes = document.querySelector('input[name="cleanPlace"][value="yes"]');
const cleanNo = document.querySelector('input[name="cleanPlace"][value="no"]');
const workerBox = document.getElementById('workerBox');


if(cleanYes && cleanNo && workerBox){


    cleanNo.addEventListener('change', function(){

        workerBox.classList.remove('d-none');

    });



    cleanYes.addEventListener('change', function(){

        workerBox.classList.add('d-none');

    });


}
// =============================
// فعال و غیرفعال کردن لوکیشن
// =============================

const locationBox = document.getElementById('locationBox');
const locationSection = document.getElementById('locationSection');

if (locationBox && locationSection) {

    function toggleLocation() {

        const disabled = !locationBox.checked;

        locationSection.querySelectorAll('input, select, button').forEach(function (el) {
            el.disabled = disabled;
        });

        locationSection.style.opacity = disabled ? '0.5' : '1';
        locationSection.style.pointerEvents = disabled ? 'none' : 'auto';
    }

    toggleLocation(); // هنگام بارگذاری صفحه

    locationBox.addEventListener('change', toggleLocation);
}
// ======================================
// نماینده محل نصب
// ======================================

const agentBox = document.getElementById('agentBox');
const agentSection = document.getElementById('agentSection');


if(agentBox && agentSection){

    agentBox.addEventListener('change', function(){

        if(this.checked){

            agentSection.classList.remove('d-none');

        }else{

            agentSection.classList.add('d-none');

        }

    });

}
function loadReviewSpaces(){

    console.log('LOAD REVIEW');

    let html = '';
    console.log('space count:', document.querySelectorAll('.space-card').length);

    document.querySelectorAll('.space-card').forEach(function(card){

        let name = card.querySelector('.space-title').innerText;
        console.log('space:', name);

        let area = card.querySelector('.space-area').innerText;

        html += `

        <div class="review-space">

            <div class="review-row">
                <span>فضا</span>
                <b>${name}</b>
            </div>

            <div class="review-row">
                <span>متراژ</span>
                <b>${area}</b>
            </div>

        </div>

        `;

    });

    if(html === ''){

        html = 'هنوز اطلاعاتی ثبت نشده';

    }
console.log('HTML =', html);
    document.getElementById('reviewSpaces').innerHTML = html;

}
</script>


@endsection
