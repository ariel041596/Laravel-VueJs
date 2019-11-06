
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Property Management System</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/profile') }}">Home</a>
                        <!-- <router-link to="/dashboard" class="nav-link">Home
                        </router-link> -->
                    @else
                        <a href="{{ url('/profile') }}">Login</a>
                        <!-- <a href="{{ route('register') }}">Register</a> -->
                    @endauth
                </div>
            @endif

            <div class="content">
               <div class="box-body">
                <form action ="{{route('bulk-import-asset')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                    <div class="form-group">
                        <label for="file"> Select a file to import </label>
                        <input type="file" name="file" id="file" class="form-control">  
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">
                            <i class="fas fa-upload"></i>Upload
                        </button>
                    </div>
                </form>
               </div>
            </div>
                        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
            <div class="content">
            <div class="container-fluid">
            <!-- Router -->
                <router-view></router-view>
            <!-- Vue Progressbar -->
            <vue-progress-bar></vue-progress-bar>
            </div>
            </div>
            </div>
            <!-- /.content-wrapper -->
        </div>
    </body>
</html>
