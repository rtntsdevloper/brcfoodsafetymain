<?php
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
if (isset($_SERVER['HTTP_COOKIE'])) {

    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);

    foreach ($cookies as $cookie) {

        $parts = explode('=', $cookie);

        $name = trim($parts[0]);

        setcookie($name, '', time() - 1000);

        setcookie($name, '', time() - 1000, '/');
    }
}








?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RTNTS - Web Portal</title>
    <link rel="shortcut icon" href="logo2.png">

    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="dist-assets/css/themes/lite-purple.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
   

    <style>
        @media (min-width: 300px) {
            #hmpage {
                margin: auto;
                width: 50%;
                padding: 2px;
            }
        }

        @media (min-width: 576px) {
            #hmpage {
                margin: auto;
                width: 50%;
                padding: 2px;
            }
        }

        @media (min-width: 768px) {
            #hmpage {
                margin: auto;
                width: 50%;
                padding: 2px;
            }
        }

        @media (min-width: 992px) {
            #hmpage {
                margin: auto;
                width: 50%;
                padding: 2px;
            }
        }

        @media (min-width: 1200px) {
            #hmpage {
                margin: auto;
                width: 100%;
                padding: 2px;
            }
        }

        .fake-fields {
            display: none;
        }

        #password {
            -webkit-text-security: disc;
            /* For Chrome */
        }
    </style>

</head>


<div class="auth-layout-wrap" style="background-image: url(images/newback1.png); background:(76, 175, 80, 0.3)">


    <div class="col-12" id="hmpage" style="margin-top:8px"><img src="images/rtnts.png" width="180"></div>


    <div class="auth-content" style="margin-top:2px">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6">
                    <div class="p-4">
                        <div class=" text-center "><img src="images/1.png" alt="" height="48"></div>

                        <form action="usercheck" name="form1" method="post" id="loginform" >
                            <div class="fake-fields">
                                <input type="text" name="fake_username">
                                <input type="password" name="fake_password">
                            </div>

                            <div class="form-group">
                                <label for="email">Username</label>
                                <input class="form-control form-control-rounded" id="username" name="user" autocomplete="off" type="user">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control form-control-rounded" id="password" name="pwd" type="password" autocomplete="current-password" onKeyUp="RemoveSavedPassword()" readonly onclick="this.removeAttribute('readOnly');">
                            </div>
                            <button class="btn btn-rounded btn-primary btn-block mt-2">Sign In</button>
                        </form>

                    </div>

                    <label for="password" style="font-size:17px; font-weight:bold; float:right; padding:10px">Version: 2.2</label>
                    </br>

                </div>
                <div class="col-md-6 text-center" style="background-size: cover;background-image: url(images/back.jpg)">
                    <div class="pr-3 auth-right">

                        <a class="btn btn-rounded btn-danger btn-email btn-block btn-icon-text" style="color:#FFFFFF"><i class="fa fa-list"></i> Vesion Detail</a>
                        <a class="btn btn-rounded btn-info btn-email btn-block btn-icon-text" style="color:#FFFFFF"><i class="fa fa-key"></i> Forgot Password? </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


