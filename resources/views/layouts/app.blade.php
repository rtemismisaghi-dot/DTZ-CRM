<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRM پالاز آنلاین</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            margin:0;
            background:#f4f4f4;
            font-family:tahoma;
        }

        /* Sidebar */

        .sidebar{

            position:fixed;
            top:0;
            right:0;
            width:260px;
            height:100vh;
            background:#fff;
            border-left:1px solid #e5e5e5;
            overflow-y:auto;
            z-index:1000;

        }

        .logo{

            text-align:center;
            padding:20px;

        }

        .menu>a{

            display:block;
            padding:15px 18px;
            color:#333;
            text-decoration:none;
            border-top:1px solid #eee;

        }

        .menu>a:hover{

            background:#f8f8f8;

        }

        .menu>a.active{

    background:#fff5f5;
    border-right:4px solid #d91f26;
    color:#d91f26;
    font-weight:700;

}


.menu>a.active i{

    color:#d91f26;

}
        .menu>a i{

            margin-left:8px;

        }

        #settingsMenu{

            background:#fafafa;

        }

        #settingsMenu a{

            display:block;
            padding:10px 38px;
            color:#666;
            text-decoration:none;
            border-top:1px solid #eee;
            font-size:14px;

        }

        #settingsMenu a:hover{

            background:#f2f2f2;

        }

        .content{

            margin-right:260px;
            min-height:100vh;
            padding:25px;

        }

    </style>

</head>

<body>

<div class="sidebar">

    <div class="logo">

        <img src="{{ asset('images/logo.png') }}"
             style="max-width:160px">

    </div>

    <div class="menu">

      <a href="{{ route('dashboard') }}"
   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            داشبورد
        </a>

        <a href="{{ route('measurements.index') }}"
   class="{{ request()->routeIs('measurements.*') ? 'active' : '' }}">
            <i class="bi bi-rulers"></i>
            اندازه گیری
        </a>

        <a href="{{ route('installations.index') }}"
   class="{{ request()->routeIs('installations.*') ? 'active' : '' }}">
            <i class="bi bi-tools"></i>
            نصب
        </a>

       <a href="#"
   class="{{ request()->routeIs('revisions.*') ? 'active' : '' }}">

    <i class="bi bi-arrow-repeat"></i>
    اصلاحیه

</a>

        <a href="{{ route('customers.index') }}"
   class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            مشتریان
        </a>

        

      <a href="/admin/users">
    <i class="bi bi-person-gear"></i>
    کاربران
</a>

<a data-bs-toggle="collapse"
   href="#settingsMenu"
   class="{{ request()->is('admin/settings*') ? 'active' : '' }}">

    <i class="bi bi-gear"></i>
    تنظیمات

</a>

        <div class="collapse" id="settingsMenu">

            <a href="/admin/settings">
                عمومی
            </a>

            <a href="#">
                قوانین و مقررات
            </a>

            <a href="#">
                عدم پذیرش مسئولیت نصب
            </a>

            <a href="#">
                چمن مصنوعی
            </a>

            <a href="#">
                لمینت
            </a>

            <a href="#">
                موکت
            </a>

            <a href="#">
                موکت تایل
            </a>

            <a href="#">
                کاغذ دیواری
            </a>

        </div>

    </div>

</div>

<div class="content">

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>

</html>