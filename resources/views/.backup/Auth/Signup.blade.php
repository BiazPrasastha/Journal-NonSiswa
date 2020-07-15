<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign Up | Journal</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{'assets/vendor/bootstrap/css/bootstrap.min.css'}}">
    <link href="{{'assets/vendor/fonts/circular-std/style.css'}}" rel="stylesheet">
    <link rel="stylesheet" href="{{'assets/libs/css/style.css'}}">
    <link rel="stylesheet" href="{{'assets/vendor/fonts/fontawesome/css/fontawesome-all.css'}}">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            background-color: #3999FFca;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
</head>

<body>
    <form class="splash-container" method="POST" action="/register-post">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="mb-1">Registrations Form</h3>
                <p>Please enter your user information.</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="name" required=""
                        placeholder="Username" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="email" name="email" required=""
                        placeholder="Email" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="pass1" name="password" type="password" required=""
                        placeholder="Password">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="pass1" name="kelas" type="text" required=""
                        placeholder="Kelas">
                </div>
                <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary" type="submit">Register My Account</button>
                </div>
            </div>
        </div>
    </form>
</body>


</html>
