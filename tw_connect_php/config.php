<?php
    define('DSN', 'mysql:host=localhost;dbname=');
    define('DB_USER', '');
    define('DB_PASSWORD', '');
    
    define('CONSUMER_KEY', '');
    define('CONSUMER_SECRET', '');
    
    define('API_TOKEN', '-SD5AloKC0zmfRQWEMW0ga1FSgiViOpYNNDxN6H6');
    define('API_TOKEN_SECRET', '');
    
    define('SITE_URL', '');
    
    define('TIME_ZONE', 'Asia/Tokyo');
    
    define('TIME_LINE_COUNT', 10);
    
    error_reporting(E_ALL & ~E_NOTICE);
    
    session_set_cookie_params(0, '/tw_connect_php/');