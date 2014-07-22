<?php
    
    require_once('config.php');
    require_once('TwistOAuth.php');
    
    @session_start();

    function redirect_to_main_page() {
        $url = SITE_URL.'index.php';
        header("Location: $url");
        header('Content-Type: text/plain; charset=utf-8');
        exit("Redirecting to $url ...");
    }
    
    if(isset($_SESSION['logined'])) {
        redirect_to_main_page();
    }
    
    try {
    	
        if(!isset($_SESSION['to'])) {
            
            $_SESSION['to'] = new TwistOAuth(CONSUMER_KEY, CONSUMER_SECRET);
            $_SESSION['to'] = $_SESSION['to']->renewWithRequestToken();
            
            header("Location: {$_SESSION['to']->getAuthenticateUrl()}");
            header("Content-Type: text/plain; charset=utf-8");
            exit("Redirecting to {$_SESSION['to']->getAuthenticateUrl()} ...");
                
        } else {

            $_SESSION['to'] = $_SESSION['to']->renewWithAccessToken(filter_input(INPUT_GET, 'oauth_verifier'));
            $_SESSION['logined'] = true;
            
            session_regenerate_id(TRUE);
            
            redirect_to_main_page();
            
        }
        
    } catch(TwistException $e) {
        
        $_SESSION = [];
        
        header('Content-Type: text/plain; charset=utf-8', TRUE, $e->getCode() > 0 ? $e->getCode() : 500);
        exit($e->getMessage());
    
    }