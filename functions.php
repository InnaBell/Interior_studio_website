<?php

// Arrays schön anzeigen
function dd($value) {
    echo "<pre>";
        var_dump($value);
        echo "</pre>";
    die();
}

// URL-kontrolieren
function urlIs($url) {
    $currentUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return $currentUrl === $url;
}

