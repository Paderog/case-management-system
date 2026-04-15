<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<style>
    body{
        margin: 0;
        min-height: 100vh;
        background: linear-gradient(rgba(10,20,40,0.55), rgba(10,20,40,0.35)),
        url("{{ asset('image/deped-logo.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI', sans-serif;
    }

    .login-card{
        width: 380px;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 15px;
        padding: 35px;
        color: white;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }

    .login-title{
        text-align: center;
        font-size: 32px;
        font-weight: 600;
        letter-spacing: 3px;
        color: #d4af37;
        margin-bottom: 25px;
    }

    .form-control{
        background: rgba(255,255,255,0.15);
        border: none;
        color: white;
    }

    .form-control::placeholder{
        color: #ddd;
    }

    .form-control:focus{
        background: rgba(255,255,255,0.2);
        color: white;
        box-shadow: none;
    }

    .login-btn{
        width: 100%;
        background: #d4af37;
        border: none;
        border-radius: 15px;
        padding: 10px;
        font-weight: 600;
        margin-top: 10px;
    }

    .login-btn:hover{
        background: #c49b2a;
    }

    label{
        margin-bottom: 6px;
        display: inline-block;
    }
</style>

<div class="login-card">
    <div class="login-title">
        LEGAL UNIT
    </div>

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="login-btn">
            Login
        </button>
    </form>
</div>
</body>