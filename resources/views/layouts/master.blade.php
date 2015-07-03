<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">

    <title>AGA Tour</title>
    <meta content="">
    <meta content="">
    <meta content="summary" name="twitter:card">
    <meta content="@aga_tour" name="twitter:site">
    <meta content="" name="twitter:title">
    <meta content="" name="twitter:description">
    <meta content="@aga_tour" name="twitter:creator">
    <meta content="" name="twitter:image">
    <meta content="text/html; charset=utf-8" http-equiv="Content-type">
    <meta content="en-us" http-equiv="Content-Language">
    <meta content="EN" name="language">

    <meta content="&copy; Copyright A Golf Association, 2015. All Rights Reserved."name="copyright">
    <meta content="" name="owner">
    <meta content="" name="Reply-To">
    <meta content="public" name="security">
    <meta content="http://www.agatour.us" name="alias">
    <meta content="index, follow" name="robots">
    <meta content="The official site of the AGA Tour" name="description">
    <meta content="logo.jpg">
    <!-- Begin Common Stylesheets -->
    <!--<link href="http://www.usopen.com/usg/css/reset.css" media="screen" rel="stylesheet" type=
    "text/css">
    <link href="http://www.usopen.com/usg/css/global.css" media="screen" rel="stylesheet" type=
    "text/css">
    <link href="http://www.usopen.com/usg/css/usga.css" media="screen" rel="stylesheet" type=
    "text/css"><!-- End Common Stylesheets -->

    {!! HTML::style('css/uikit.almost-flat.min.css') !!}
    {!! HTML::style('css/custom/style.css') !!}
    {!! HTML::style('css/custom/player.css') !!}
    {!! HTML::script('http://code.jquery.com/jquery-2.1.4.min.js') !!}
    {!! HTML::script('js/uikit.min.js') !!}
</head>

<body>
    @include('layouts.header')

    <div class="uk-container uk-container-center uk-margin-top uk-margin-bottom">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                @yield('content')
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-wrapper">
            <div class="footer centered">
                Copyright 2015 A Golf Association. All Rights Reserved.
            </div>
        </div>
    </footer>
</body>
</html>
