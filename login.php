<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
<link rel="icon" href="docs/tlogo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: url(docs/bg1.png);
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .login-title {
            color: #D34673;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .profile-circle {
            background-color: #fcd462;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-circle img {
            width: 80px;
            height: auto;
        }

        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            margin-bottom: 1.5rem;
            border: 1px solid #eee;
        }

        .form-control:focus {
            border-color: #fcd462;
            box-shadow: 0 0 0 0.25rem rgba(252, 212, 98, 0.25);
        }

        .login-btn {
            background-color: #D34673;
            color: white;
            font-weight: 600;
            border-radius: 25px;
            padding: 12px;
            width: 100%;
            border: none;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .login-btn:hover {
            background-color: #c04a5a;
            transform: translateY(-2px);
        }

        .forgot-password {
            color: #6c757d;
            text-align: center;
            display: block;
            margin-top: 1rem;
            text-decoration: none;
        }

        .forgot-password:hover {
            color: #D34673;
        }

        .login-footer {
            text-align: center;
            margin-top: 2rem;
            color: #6c757d;
        }

        .accent-bar {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background-color: #D34673;
        }
    </style>
</head>

<body>


    <div class="login-container">
        <div class="login-card">
            <div class="accent-bar"></div>
            <div class="login-header">
                <div class="profile-circle">
                    <img src="docs/rlogo.png" alt="Login Icon">
                </div>
                <h2 class="login-title">Welcome Back</h2>
            </div>

            <form  action="usercheck" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control"  placeholder="Username" name="user" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control"  placeholder="Password" name="pwd" required>
                </div>
                <button type="submit" class="btn login-btn" name="submit">Login</button>
                <a href="#" class="forgot-password">Forgot password?</a>
            </form>

            <!-- <div class="login-footer">
                Don't have an account? <a href="#" style="color: #d85c6c; font-weight: 600;">Sign up</a>
            </div> -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>