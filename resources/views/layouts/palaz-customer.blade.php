<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'خدمات نصب پالاز')</title>
    <style>
        *{box-sizing:border-box}
        body{margin:0;background:#fff;color:#222;font-family:tahoma,Arial,sans-serif}
        .palaz-head{border-bottom:1px solid #ececec;background:#fff;position:sticky;top:0;z-index:1000}
        .palaz-head-in{width:min(1240px,calc(100% - 32px));min-height:72px;margin:auto;display:flex;align-items:center;justify-content:space-between;gap:20px}
        .palaz-logo{font-size:28px;font-weight:900;letter-spacing:.08em;color:#c71920;text-decoration:none}
        .palaz-label{font-size:14px;font-weight:700;color:#555}
        .palaz-main{width:min(1240px,calc(100% - 32px));margin:auto;padding:24px 0 44px}
        .palaz-foot{border-top:1px solid #ececec;text-align:center;color:#777;font-size:12px;padding:18px 16px 28px}
        @media(max-width:700px){
            .palaz-head-in,.palaz-main{width:calc(100% - 20px)}
            .palaz-head-in{min-height:62px}
            .palaz-logo{font-size:23px}
            .palaz-label{font-size:12px}
            .palaz-main{padding-top:12px}
        }
    </style>
</head>
<body>
<header class="palaz-head">
    <div class="palaz-head-in">
        <a class="palaz-logo" href="{{ config('services.palaz.url') ?: '#' }}">PALAZ</a>
        <div class="palaz-label">خدمات نصب و اجرا</div>
    </div>
</header>
<main class="palaz-main">@yield('content')</main>
<footer class="palaz-foot">پالاز آنلاین • مسیر خرید تا اجرا، یک تجربه واحد</footer>
@stack('scripts')
</body>
</html>
