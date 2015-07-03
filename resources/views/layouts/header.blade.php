<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:300,400,500,700,800' rel='stylesheet' type='text/css'>
<style>
    .master-header {
        border-bottom: 1px #ffffff solid;
    }

    .header {
        background: url("http://www.usopen.com//images/misc/masthead_bkg_2560x102.jpg") repeat center top transparent;
        height: 68px;
    }

    .header .logo img {
        height: 46px;
        float: left;
        margin-top: 10px;
        margin-left: 20px;
    }

    .header .logo span {
        margin-top: 26px;
        font-weight: 700;
        font-size: 20px;
    }

    .header .details {
        float: left;
        margin-top: 26px;
        width: 268px;
        font-family: 'Alegreya Sans', sans-serif;
        font-weight: 700;
        font-size: 12px;
        line-height: 1.4em;
        text-align: center;
        color: #003865;
        text-transform: uppercase;
    }
</style>

<style>
    .nav {
        background: #003865;
    }

    nav.uk-navbar {
        background: #003865;
    }

    nav.uk-navbar ul li a {
        text-shadow: none;
        font-weight: 500;
        color: #ffffff;
        text-transform: uppercase;
        font-family: "Alegreya Sans", sans-serif;
    }
</style>

<div class="master-header" data-uk-sticky>
    <div class="header">
        <div class="uk-container uk-container-center">
            <div class="uk-grid">
                <div class="uk-width-1-3 logo">
                    {!! HTML::image('img/logo.png') !!} <span style="color:#2D5290">AGA</span><span style="color:#A51801">TOUR</span>
                </div>
                <div class="uk-width-1-3 details">
                    Parkville Classic, Parkville<br>
                    1st Feb 2016
                </div>
                <div class="uk-width-1-3">
                    &nbsp;
                </div>
            </div>
        </div>
    </div>

    @include('layouts.nav')
</div>
