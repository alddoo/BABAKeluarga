<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff9e9;
            font-family: 'Montserrat', sans-serif;
        }

        .card {
            width: 380px;
            padding: 40px;
            background: #ffffff;
            border-radius: 25px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            text-align: center;
            border: 3px solid #f7cc1d;
        }

        /* Pengaturan Logo */
        .login-logo {
            width: 150px;
            height: auto;
            margin-bottom: -10px; /* Menarik logo lebih dekat ke judul */
        }

        .card h2 {
            margin-top: 0px;
            margin-bottom: 20px;
            color: #3A1309;
            font-weight: 700;
            font-style: italic; /* Meniru gaya <i> pada contoh pertama */
        }

        form {
            text-align: left;
        }

        label {
            font-weight: 600;
            color: #3A1309;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 12px;
            border: 2px solid #f7cc1d;
            outline: none;
            background: #fff9e9;
            font-size: 15px;
            color: #3A1309;
            box-sizing: border-box;
            transition: 0.3s;
            font-family: 'Montserrat', sans-serif;
        }

        input:focus {
            background: #fff4c6;
            border-color: #e2b30f;
        }

        button {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: none;
            background: #f7cc1d;
            color: #3A1309;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.25s;
            font-family: 'Montserrat', sans-serif;
            margin-top: 10px;
        }

        button:hover {
            background: #ffd447;
            transform: scale(1.02);
        }

        .error-message {
            margin-top: 15px;
            color: white;
            background: #d9534f;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="card">
    <img src="{{ asset('img/image.png') }}" alt="Logo" class="login-logo">

    <h2>Login</h2>
    
     <form method="POST" action="{{ route('login.process') }}" autocomplete="off">
            @csrf
            
            <div class="input-group">
                <label>Username</label>
                <input class="input" name="username" placeholder="Masukkan username" value="{{ old('username') }}">
                @error('username') 
                    <div class="err">{{ $message }}</div> 
                @enderror
            </div>

            <div class="input-group">
                <label>Password</label>
                <input class="input" type="password" name="password" placeholder="Masukkan password">
                @error('password') 
                    <div class="err">{{ $message }}</div> 
                @enderror
            </div>

            <button type="submit" class="btn">Masuk</button>
        </form>
</div>

</body>
</html>