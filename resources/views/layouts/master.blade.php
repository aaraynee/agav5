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

    {!! HTML::style('css/uikit.almost-flat.css') !!}
    {!! HTML::style('css/custom/style.css') !!}
    {!! HTML::style('css/custom/player.css') !!}
    {!! HTML::style('css/custom/flag-icon.min.css') !!}
    {!! HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css') !!}

    {!! HTML::script('http://code.jquery.com/jquery-2.1.4.min.js') !!}
    {!! HTML::script('js/uikit.min.js') !!}
</head>

<body>

    @include('layouts.header')

    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-margin-large-top uk-margin-large-bottom">
            <div class="uk-width-1-1">
                @yield('content')
            </div>
        </div>
    </div>

    <style>

        .sponsors {
            text-align: center;
            height: 160px;
            background: #ffffff;
        }

        .footer-links {
            height: 70px;
            line-height: 62px;
            text-align: center;
            margin: 0 auto;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links ul li {
            display: inline-block;
            float: left;
            padding: 0px 20px;
        }

        .footer-links ul li a {
            color: #003865;
            text-decoration: none;
            text-transform: uppercase;
        }

        .copyright {
            height: 90px;
            background: #d8d8d8;
        }

        .copyright .info {
            text-align: center;
            color: #59595b;
            font-size: 14px;
            padding-top: 30px;
        }

    </style>

    <div class="sponsors">
        <div class="uk-container uk-container-center">
            <div class="uk-grid">
                <div class="uk-width-1-3">
                    {!! HTML::image('img/sponsors/rpgc.png') !!}
                </div>
                <div class="uk-width-1-3">
                    {!! HTML::image('img/sponsors/confidence.png') !!}
                </div>
                <div class="uk-width-1-3">
                </div>
            </div>
        </div>
    </div>

    <div class="uk-container uk-container-center">
        <div class="uk-grid">
            <div class="uk-width-1-1 footer-links">
                <ul>
                    <li><a href="">About</a></li>
                    <li><a href="">Contact</a></li>
                    <li><a href="">Privacy</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="copyright">
        <div class="uk-container uk-container-center">
            <div class="uk-grid">
                <div class="uk-width-1-1 info">
                    Copyright 2015 A Golf Association. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>

</body>
</html>
