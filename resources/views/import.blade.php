
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/app.css">
        <title>Property Management System</title>

        <!-- Fonts -->
        <!-- bootsrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- mdl -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
        <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
        <!-- Default -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: 000507;
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
            .nologin{
                text-align: center;
                position: absolute;
                right: 500px;
                top: 200px;
            }
            .update-create{
                color: #fff;
                margin-top: 50px;
            }
            .update-create:hover {
                opacity: 1;
            }
            .form-control-file{
                color: black;
            }
            .card-box-title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            margin-top: 13px;
            }
            .card-header {
            height: 40px;
            background: #3c8dbc;
            color: #fff;
            }
            .card-content {
            border: 1px solid #3c8dbc;
            }
            .filename{
                color: #ffffff;
                background: #ffffff;
                font-family: Arial, Helvetica, sans-serif;
            }
        </style>
    </head>
    @can('isAdminOrUser')
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/profile') }}"><i class="fa fa-home">&nbsp;</i>Home</a>
                        <!-- <router-link to="/dashboard" class="nav-link">Home
                        </router-link> -->
                    @else
                        <a href="{{ url('/profile') }}"><i class="fas fa-sign-in-alt">&nbsp;</i>Login</a>
                        <!-- <a href="{{ route('register') }}">Register</a> -->
                        
                            <div class="nologin title">
                                Property Management System
                            </div>
                        
                    @endauth
                </div>
                
                @auth
              
                <!-- 1st -->
            <section class="col-lg-4 connectedSortable">
                <div class="card card-content">
                    <div class="card-header d-flex p-0">
                        <h5 class="card-box-title px-2">
                            <i class="fas fa-upload"></i>
                            Import RPCPPE or ICS
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <div class id style="position: relative; height: 200px;">
                                <form action ="{{route('bulk-import-asset')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <div class="col-sm-12">
                                    <input
                                        type="file"
                                        class="form-control-file"
                                        name="file"
                                        id="file"
                                        aria-describedby="fileHelp"
                                    />
                                    <small
                                        id="fileHelp"
                                        class="filename form-text text-muted"
                                    >Please upload a valid CSV file. File should be formatted on tables</small>
                                </div>
                                <div class="form-group">
                                    <button data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="Please fill up fields"
                                        class="update-create float-right mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
                                        <i class="fas fa-upload">&nbsp;</i>Import RPCPPE/ICS
                                    </button>
                                </div>
                                </form>
                            </div>  
                        </div>
                    </div>
                </div>
            </section>
            <!-- end 1st -->
            @endauth
            @endif
                      
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
    @endcan()
</html>
