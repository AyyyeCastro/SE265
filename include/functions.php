<?php
# POST request
function isPostRequest() {
    return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
}

# GET request
function isGetRequest() 
{
    return (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET' && !empty($_GET) );
}

# Checks if session has already been started. 
# False activity -> start it. True -> started logged In session.
function isUserLoggedIn()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
    if (array_key_exists('isLoggedIn', $_SESSION) && ($_SESSION['isLoggedIn'])){
        if(array_key_exists('userID', $_SESSION)){
            return $_SESSION['userID'];
        }
    }
    return false;
}

?>