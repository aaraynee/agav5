<?php
    $nav = [
        'home', 'schedule', 'players', 'courses', 'grilldcup', 'rankings', 'blog'
    ];
?>

<div class="nav" data-uk-sticky>
    <div class="uk-container uk-container-center">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <nav class="uk-navbar">
                    <ul class="uk-navbar-nav">
                        @foreach($nav as $item)
                            <li><a href="/{{($item != 'home') ? $item : ''}}">{{studly_case($item)}}</a></li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
