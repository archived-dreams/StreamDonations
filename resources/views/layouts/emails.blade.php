<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', $title)</title>
    <style>
        @import url(http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,800,700,600);
        body, html {
          background-color: #59438c;
          font-family: 'Nunito', sans-serif;
          color: #4f5f6f;
        }

        .container {
          min-width: 100px;
          max-width: 480px;
          width: 100%;
          margin: 0px auto;
        }

        .box {
          background-color: #fff;
          border-radius: 3px;
          padding: 30px;
          box-shadow: 0 10px 15px rgba(55,71,79,.1);
          margin-bottom: 10px;
          text-align: center;
        }

        .logo {
          width: 160px;
          height: auto;
          margin: 0px;
        }

        h3 {
          font-size: 1.75rem;
          margin-bottom: 0.5rem;
          font-family: inherit;
          font-weight: 500;
          line-height: 1.1;
          color: #4f5f6f;
        }

        .text {
          display: block;
          text-align: left;
          color: #000;
        }

        .copyright {
          margin-top: 20px;
          color: white;
          text-shadow: 1px 1px 2px rgba(55,71,79,.1);
          display: block;
          text-align: center;
        }
    </style>
</head>
<body style="background-color: #59438c; font-family: 'Nunito', sans-serif; color: #4f5f6f;">
    <br><br>
    <div class="container" style="min-width: 100px; max-width: 480px; width: 100%; margin: 0px auto;">
        <div class="box" style="background-color: #fff; border-radius: 3px; padding: 30px; box-shadow: 0 10px 15px rgba(55,71,79,.1); margin-bottom: 10px; text-align: center;">
            <img src="{{ asset('assets/img/logo-clean.png') }}" class="logo" style="width: 160px; height: auto; margin: 0px;">
            <h3 style="font-size: 1.75rem; margin-bottom: 0.5rem; font-family: inherit; font-weight: 500; line-height: 1.1; color: #4f5f6f;">@yield('title', $title)</h3>
            <div class="text" style="display: block; text-align: left; color: #000;">
                @yield('content')
            </div>
        </div>
        <div class="copyright" style="margin-top: 20px; color: white; text-shadow: 1px 1px 2px rgba(55,71,79,.1); display: block; text-align: center;">
            © {{ date('Y') }} {{ config('app.title') }}
        </div>
    </div>
    <br><br>
</body>
</html>





