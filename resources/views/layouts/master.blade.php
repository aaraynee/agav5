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
        <style>

.pre_footer { height: 70px; }
.pre_footer .wrapper { text-align: center; line-height: 62px; }
.pre_footer .wrapper ul li { list-style: none; display: inline-block; margin-left: 20px; }
.pre_footer .wrapper ul li:first-child { margin-left: 0; }
            
            
            
            footer .links {
                height: 70px;
                background: #F1F1F1;
            }
            
            footer .links .wrapper {
                line-height: 62px;
                text-align: center;
            }
            
            footer .links .wrapper ul {
                display: block;
                list-style-type: disc;
            }
            
            footer .links .wrapper ul li {
                list-style: none;
                display: inline-block;
                margin-left: 20px;
            }
            
            footer .links .wrapper ul li:first-child { 
                margin-left: 0; 
            }
            
            footer .links ul li a {
                text-transform: uppercase;
                color: #003865;
                text-decoration: none;
            }
            
            .copyright {
                height: 90px;
                background: #d8d8d8;
            }
            .copyright p {
                text-align: center;
                color: #59595b;
                font-size: 14px;
                padding-top: 30px;
            }
        </style>
        
        <footer>
            <div class="links">
                <div class="uk-container uk-container-center">
                    <div class="uk-grid">
                        <div class="uk-width-1-1">            
                            <div class="wrapper">
                                <ul>
                                    <li><a href="/courses">Courses</a></li>
                                    <li><a href="/contact">Contact Us</a></li>
                                </ul>
                            </div>    
                        </div>               
                    </div>
                </div> 
            </div>    
            <div class="copyright">
                <div class="uk-container uk-container-center">
                    <div class="uk-grid">
                        <div class="uk-width-1-1">            
                            <p>Copyright 2015 A Golf Association. All Rights Reserved.</p>
                        </div>               
                    </div>
                </div> 
            </div>   
        </footer>
    </body>
</html>