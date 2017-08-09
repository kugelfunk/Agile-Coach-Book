<!doctype html>
<html lang="de-DE">

<head>
    <meta charset="UTF-8">
    <title>Turbine Kreuzberg - Agile Coach Book</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="/css/normalize.css" rel="stylesheet" type="text/css">
    <link href="/css/webflow.css" rel="stylesheet" type="text/css">
    <link href="/css/agile-coach-book.css" rel="stylesheet" type="text/css">
    @yield('styles')
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
    <script type="text/javascript">WebFont.load({
        google: {
          families: ["Ubuntu:300,300italic,400,400italic,500,500italic,700,700italic", "Varela Round:400"]
        }
      });</script>
    <!-- [if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"
            type="text/javascript"></script><![endif] -->
    <script type="text/javascript">!function (o, c) {
        var n = c.documentElement, t = " w-mod-";
        n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
      }(window, document);
    </script>
    <link href="https://y7v4p6k4.ssl.hwcdn.net/placeholder/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="https://daks2k3a4ib2z.cloudfront.net/img/webclip.png" rel="apple-touch-icon">
</head>
<body>
<header class="header">
    @include('partials.navbar')
</header>
<main>
    @yield('content')
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/webflow.js"></script>
<!-- [if lte IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
@yield('body_javascripts')
</body>
</html>