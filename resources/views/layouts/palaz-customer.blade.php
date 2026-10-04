<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'خدمات نصب پالاز')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root{
            --palaz-red:#d91f26;
            --palaz-dark:#171717;
            --palaz-soft:#f7f7f7;
        }

        *{box-sizing:border-box;}

        body{
            margin:0;
            background:#fff;
            color:#222;
            font-family:tahoma, Arial, sans-serif;
        }

        .palaz-customer-header{
            position:sticky;
            top:0;
            z-index:1000;
            background:rgba(255,255,255,.96);
            backdrop-filter:blur(12px);
            border-bottom:1px solid #ececec;
        }

        .palaz-customer-header-inner{
            width:min(1240px, calc(100% - 32px));
            min-height:76px;
            margin:0 auto;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
        }

        .palaz-brand{
            display:flex;
            align-items:center;
            gap:14px;
            text-decoration:none;
            color:inherit;
        }

        .palaz-brand img{
            width:132px;
            max-height:46px;
            object-fit:contain;
        }

        .palaz-service-label{
            display:flex;
            align-items:center;
            gap:8px;
            color:#555;
            font-size:14px;
            font-weight:700;
        }

        .palaz-service-label i{
            color:var(--palaz-red);
            font-size:18px;
        }

        .palaz-customer-main{
            width:min(1240px, calc(100% - 32px));
            margin:0 auto;
            padding:24px 0 48px;
        }

        .palaz-customer-footer{
            border-top:1px solid #ececec;
            margin-top:20px;
            padding:18px 16px 28px;
            text-align:center;
            color:#777;
            font-size:12px;
        }

        @media(max-width:768px){
            .palaz-customer-header-inner{
                min-height:64px;
                width:min(100% - 20px, 1240px);
            }

            .palaz-brand img{
                width:112px;
            }

            .palaz-service-label{
                font-size:12px;
            }

            .palaz-customer-main{
                width:min(100% - 20px, 1240px);
                padding-top:12px;
            }
        }
    </style>

    @stack('head')
</head>
<body class="palaz-customer-layout">

<header class="palaz-customer-header">
    <div class="palaz-customer-header-inner">
        <a href="{{ config('services.palaz.url') ?: '#' }}" class="palaz-brand" aria-label="پالاز آنلاین">
            <img src="{{ asset('images/logo.png') }}" alt="پالاز">
        </a>

        <div class="palaz-service-label">
            <i class="bi bi-tools"></i>
            <span>خدمات نصب پالاز</span>
        </div>
    </div>
</header>

<main class="palaz-customer-main">
    @yield('content')
</main>

<footer class="palaz-customer-footer">
    پالاز آنلاین • مسیر خرید تا اجرا، یک تجربه واحد
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
