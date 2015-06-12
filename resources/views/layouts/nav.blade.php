<?php
    $nav = [
        'home', 'schedule', 'players', 'courses', 'seasons'
    ];
?>


<nav class="uk-navbar">
    <ul class="uk-navbar-nav">
        @foreach($nav as $item)
            <li><a href="/{{$item}}">{{studly_case($item)}}</a></li>
        @endforeach
    </ul>
</nav>