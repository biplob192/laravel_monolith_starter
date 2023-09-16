<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MY APP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

</head>

<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card bg-white">
                        <div class="card-body p-5">
                            <form class="mb-3 mt-md-4" action="{{route('auth.login')}}" method="post">
                                @csrf
                                <h2 class="fw-bold mb-2 text-uppercase ">Brand</h2>
                                <p class=" mb-5">Please enter your login and password!</p>
                                <div class="mb-3">
                                    <label for="email" class="form-label ">Email address</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label ">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="*******">
                                </div>
                                <p class="small"><a class="text-primary" href="forget-password.html">Forgot password?</a></p>
                                <div class="d-grid">
                                    <button class="btn btn-outline-dark" type="submit">Login</button>
                                </div>
                            </form>
                            <div>
                                <p class="text-center">Don't have an account? <a href="{{route('auth.register')}}" class="text-primary fw-bold">Sign Up</a></p>
                            </div>

                            <div class="d-grid">
                                {{-- <button class="btn btn-primary" type="">Login with Google</button> --}}
                                <a href="{{ route('auth.google') }}" class="btn btn-block btn-danger">
                                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>