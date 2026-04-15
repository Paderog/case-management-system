<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: #f7f4ef;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }

        .navbar{
            background: white;
            padding: 20px 60px;
        }

        .navbar-brand{
            font-weight: 700;
        }

        .hero{
            padding: 40px 60px;
        }

        .hero-img{
            background-image: url('{{ asset("image/deped-3.jpg") }}');
            background-size: 65%;
            background-position: center;
            background-repeat: no-repeat;
            min-height: calc(100vh - 120px);
            width: 100%;
            border-radius: 12px;
        }

        .call-btn{
            background: #222;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
        }

        .navbar a{
            text-decoration: none;
            color: #c8a26b;
            font-weight: 500;
            margin: 0 15px;
            font-size: 20px;
        }

        .navbar a:hover{
            color: #444;
        }

        html{
            scroll-behavior: smooth;
        }
        .navbar-brand{
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .deped-logo{
            width: 55px;
            height: 55px;
            object-fit: contain;
        }

        .brand-text{
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-title{
            font-size: 22px;
            font-weight: 700;
            color: #000;
        }

        .brand-subtitle{
            font-size: 14px;
            font-weight: 600;
            color: #444;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <nav class="navbar d-flex justify-content-between align-items-center">
        <div class="navbar-brand d-flex align-items-center">
            <img src="{{ asset('image/deped-2.png') }}" alt="DepEd Logo" class="deped-logo">

            <div class="brand-text">
                <div class="brand-title">Department of Education</div>
                <div class="brand-subtitle">SCHOOLS DIVISION OF BUKIDNON</div>
            </div>
        </div>

        <div>
            <a href="{{ route('login')}}" class="call-btn">Login</a>
        </div>
    </nav>

    <div class="hero container-fluid">
        <div class="row">
            <div class="col-md-12 hero-img"></div>
        </div>
    </div>
</body>
</html>