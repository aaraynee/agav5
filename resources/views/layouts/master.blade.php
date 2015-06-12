<!-- Stored in resources/views/layouts/master.blade.php -->

<html>
    <head>
        <title>@yield('title')</title>
        {!! HTML::style('css/uikit.almost-flat.min.css') !!}
        {!! HTML::style('css/custom/style.css') !!}
        {!! HTML::script('http://code.jquery.com/jquery-2.1.4.min.js') !!}
        {!! HTML::script('js/uikit.min.js') !!}
        
    </head>
    <body>
        @include('layouts.nav')
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-margin-top uk-margin-bottom uk-hidden-small">
                 <div class="uk-width-1-1 page-content">            
                    @yield('content')
                </div>               
            </div>
        </div>        
    </body>
</html>