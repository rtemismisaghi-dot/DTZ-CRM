<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>CRM SYSTEM</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

        body{
            margin:0;
            font-family:tahoma;
            background:#f4f6f9;
        }

        /* ===== SIDEBAR ===== */
        .sidebar{
            width:250px;
            height:100vh;
            background:#111827;
            color:#fff;
            position:fixed;
            right:0;
            top:0;
            display:flex;
            flex-direction:column;
        }

        .logo{
            padding:20px;
            font-size:18px;
            font-weight:bold;
            background:#0b1220;
            text-align:center;
            border-bottom:1px solid #222;
        }

        .menu{
            padding:10px;
            overflow-y:auto;
        }

        .menu a{
            display:flex;
            align-items:center;
            gap:10px;
            color:#cbd5e1;
            text-decoration:none;
            padding:12px;
            border-radius:10px;
            margin-bottom:5px;
            transition:0.2s;
            font-size:14px;
        }

        .menu a:hover{
            background:#1f2937;
            color:#fff;
        }

        .menu a.active{
            background:#dc2626;
            color:#fff;
        }

        /* ===== MAIN ===== */
        .main{
            margin-right:250px;
            padding:20px;
        }

        /* ===== TOP BAR ===== */
        .topbar{
            background:#fff;
            padding:15px 20px;
            border-radius:12px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:15px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        .btn-primary{
            background:#dc2626;
            border:none;
            border-radius:10px;
            padding:8px 14px;
        }

        .btn-primary:hover{
            background:#b91c1c;
        }

    </style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <!-- LOGO -->
    <div class="logo">
            <div style="background:#fff; padding:10px; border-radius:10px; display:inline-block;">

<img src="{{ asset('images/logo.png') }}" style="height:45px;">
    </div>

    </div>

    <!-- MENU -->
    <div class="menu">

        <a href="/dashboard">
            <i class="fa fa-home"></i> داشبورد
        </a>

        <a href="/customers">
            <i class="fa fa-users"></i> مشتریان
        </a>

        <a href="/measurements">
            <i class="fa fa-ruler"></i> اندازه‌گیری
        </a>

        <a href="/installations">
            <i class="fa fa-tools"></i> نصب
        </a>

        <a href="/revisions">
            <i class="fa fa-edit"></i> اصلاحیه
        </a>

        <a href="/managers">
            <i class="fa fa-user-shield"></i> مدیر
        </a>

        <a href="/users">
            <i class="fa fa-user"></i> کاربران
        </a>

        <a href="/settings">
            <i class="fa fa-cog"></i> تنظیمات
        </a>

    </div>

</div>

<!-- MAIN -->
<div class="main">

    <!-- TOP BAR -->
    <div class="topbar">

        <h5 class="m-0">@yield('title')</h5>

        <a href="/measurements/create" class="btn btn-danger btn-sm">
    + اندازه‌گیری جدید
</a>

    </div>

    <!-- CONTENT -->
    @yield('content')

</div>

</body>

</html>