<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:300,400,500,700,800' rel='stylesheet' type='text/css'>
<style>
    .header {
        background: url("http://www.usopen.com//images/misc/masthead_bkg_2560x102.jpg") repeat center top transparent;
        height: 122px;
    }

    .header .logo img {
        height: 100px;
        margin: 10px auto;
    }

    .header .logo {
        text-align: center;

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

    <div class="header">
        <div class="uk-container uk-container-center">
            <div class="uk-grid">
                <div class="uk-width-1-3">
                    &nbsp;
                </div>
                <div class="uk-width-1-3 logo">
                    {!! HTML::image('img/logo.png') !!}
                </div>
                <div class="uk-width-1-3 details">
                    Parkville Classic, Parkville<br>
                    1st Feb 2016
                </div>
            </div>
        </div>
    </div>

    @include('layouts.nav')
</div>
