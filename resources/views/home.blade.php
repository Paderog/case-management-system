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
        }
        .navbar{
            background: white;
            padding: 20px 60px;
        }
        .navbar-brand{
            font-weight: 700;
        }
        .hero{
            padding: 120px 60px;
            min-height: 650px;
        }
        .hero h1{
            font-size: 80px;
            font-weight: 700;
        }
        .hero span{
            color: #c8a26b;
        }
        .hero p{
            color: #666;
            max-width: 500px;
            font-size: 20px;
        }
        .hero-btn{
            background: #c8a26b;
            border: none;
            padding: 12px 25px;
            color: white;
            border-radius: 8px;
        }
        .hero-img{
            display: flex;
            justify-content: flex-end;
        }
        .call-btn{
            background: #222;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
        }

        .statue{
            height: 670px;
            margin-top: -150px;
            margin-right: -110px;
        }
        .hero .row{
            position: relative;
        }
        html{
            scroll-behavior: smooth;
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

    .info-box{
        border: 3px solid #222;
        padding: 30px;
        margin-bottom: 30px;
        background: #f7f4ef;
    }

    .box-image{
        width: 120px;
    }
    
    </style>
</head>
<body>
    <nav class="navbar d-flex justify-content-between">
        <div class="navbar-brand">
            LEGAL UNIT
        </div>

        <!-- <div>
            <a href="#about" class="me-4">About</a>
            <a href="#services" class="me-4">Services</a>
            <a href="#cases" class="me-4">Cases</a>
            <a href="#practice" class="me-4">Practice</a>
        </div> -->

        <div>
            <a href="{{ route('login')}}" class="call-btn">
                Login
            </a>
        </div>
    </nav>

    <div class="hero container">
    <div class="row align-items-start">

        <div class="col-md-6">
            <h1>
                Unraveling <br>
                Complexities <br>
                <span>Together</span>
            </h1>

            <p>
                Professional Legal Case Management System designed to organize,
                track, and manage cases efficiently
            </p>

            <!-- <a href="{{ route('login')}}" class="hero-btn">Login</a> -->
        </div>

        <div class="col-md-6 hero-img">
            <img src="{{ asset('image/ladyJustice.png')}}" class="statue">
        </div>
    </div>
</div>


<!-- <section class="container py-5">

    <div class="info-box row align-items-center">
        <div class="col-md-8">
            <h1>About us</h1>
            <p>
                The Legal Unit Case Management System is designed to streamline case tracking,
                documentation, and legal workflows to ensure efficient management of legal matter.
            </p>
        </div>

        <div class="col-md-4 text-end">
            <img src="{{ asset('image/ladyStatueJustice.png') }}" class="box-image">
        </div>
    </div>

    <div class="info-box row align-items-center">
        <div class="col-md-8">
            <h1>Services</h1>
            <p>
                Our system helps manage case records, monitor legal activities,
                and organize documentation efficiently.
            </p>
        </div>

        <div class="col-md-4 text-end">
            <img src="{{ asset('image/ladyStatueJustice.png') }}" class="box-image">
        </div>
    </div>

    <div class="info-box row align-items-center">
        <div class="col-md-8">
            <h1>Cases</h1>
            <p>
                Track ongoing cases, monitor their progress, and manage case
                information in a structured system.
            </p>
        </div>

        <div class="col-md-4 text-end">
            <img src="{{ asset('image/ladyStatueJustice.png') }}" class="box-image">
        </div>
    </div>

    <div class="info-box row align-items-center">
        <div class="col-md-8">
            <h1>Practice</h1>
            <p>
                The system supports various legal practices including documentation,
                legal tracking, and administrative case handling.
            </p>
        </div>

        <div class="col-md-4 text-end">
            <img src="{{ asset('image/ladyStatueJustice.png') }}" class="box-image">
        </div>
    </div>

</section>  -->

</body>
</html>