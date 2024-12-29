<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Login Sistem Bahan Baku</title>
    <style>
        .logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 360px; /* Sesuaikan ukuran logo */
            height: auto;
        }

        /* Menyempurnakan penempatan card login di tengah */
        .login-card {
            width: 100%;
            max-width: 400px; /* Ukuran maksimal card */
        }
    </style>
</head>

<body class="bg-light" style="height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card login-card">
            <div class="card-body">
                <!-- Logo -->
                <img src="images/LogoPerusahaanTeksSamping.png" alt="Logo" class="logo">
                <h3 class="text-center mt-3">Login Sistem Bahan Baku</h3>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">email</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3 d-grid">
                        <button name="submit" type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-kA09DDfh0DzPb22/sFTZHHk7l0NRT9V1rsZy5otzH9bsGv9AomXy/USJ3Se4nV4Xm" crossorigin="anonymous"></script>

</body>

</html>