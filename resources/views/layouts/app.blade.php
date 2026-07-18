<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM پالاز آنلاین</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <style>
        body{
            margin:0;
            background:#f4f4f4;
            font-family:tahoma;
        }

        /* SIDEBAR */
        .sidebar{
            position:fixed;
            right:0;
            top:0;
            width:260px;
            height:100vh;
            background:#fff;
            border-left:1px solid #ddd;
        }

        .logo{
            text-align:center;
            padding:20px;
        }

        .menu a{
            display:block;
            padding:16px;
            text-decoration:none;
            color:#333;
            border-top:1px solid #eee;
        }

        .menu a:hover{
            background:#f8f8f8;
        }

        .content{
            margin-right:260px;
            padding:25px;
        }

        /* PRODUCT GRID */
        .product-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:12px;
        }

        @media(max-width:768px){
            .product-grid{
                grid-template-columns:repeat(2,1fr);
            }
        }

        .product-card{
            cursor:pointer;
            border-radius:12px;
            overflow:hidden;
            border:1px solid #eee;
            background:#fff;
            transition:.2s;
        }

        .product-card:hover{
            transform:translateY(-4px);
            box-shadow:0 10px 20px rgba(0,0,0,.08);
        }

        .product-card img{
            width:100%;
            height:90px;
            object-fit:cover;
        }

        .product-title{
            text-align:center;
            padding:8px;
            font-size:13px;
            font-weight:600;
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" style="max-width:160px;">
    </div>

    <div class="menu">
        <a href="/dashboard">داشبورد</a>
        <a href="/measurements">اندازه گیری</a>
        <a href="/installations">نصب</a>
        <a href="/repairs">اصلاحیه</a>
        <a href="/customers">مشتریان</a>
    </div>

</div>

<!-- CONTENT -->
<div class="content">
    @yield('content')
</div>

<!-- ================= PRODUCT MODAL ================= -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header">
                <h5 class="fw-bold">انتخاب نوع اندازه‌گیری</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-3">

                <div class="product-grid">

                    <div class="product-card" data-type="carpet">
                        <img src="{{ asset('images/carpet.jpg') }}">
                        <div class="product-title">موکت</div>
                    </div>

                    <div class="product-card" data-type="grass">
                        <img src="{{ asset('images/grass.jpg') }}">
                        <div class="product-title">چمن مصنوعی</div>
                    </div>

                    <div class="product-card" data-type="tile">
                        <img src="{{ asset('images/tile.jpg') }}">
                        <div class="product-title">تایل</div>
                    </div>

                    <div class="product-card" data-type="laminate">
                        <img src="{{ asset('images/laminate.jpg') }}">
                        <div class="product-title">لمینیت</div>
                    </div>

                    <div class="product-card" data-type="wallpaper">
                        <img src="{{ asset('images/wallpaper.jpg') }}">
                        <div class="product-title">کاغذ دیواری</div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll(".product-card").forEach(card => {
    card.addEventListener("click", function () {
        const type = this.dataset.type;

        const input = document.getElementById("measurement_type");
        if (input) input.value = type;

        const modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
        if (modal) modal.hide();

        setTimeout(() => {
            const el = document.getElementById('measurementModal');
            if (el) new bootstrap.Modal(el).show();
        }, 200);
    });
});
</script>

@stack('scripts')

</body>
</html>