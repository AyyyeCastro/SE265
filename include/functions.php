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
    # Check session staus and start session if not running
    if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}

    # Check if isLoggedIn is set, then check its status
    return (array_key_exists('isLoggedIn', $_SESSION) && ($_SESSION['isLoggedIn']));
}

?>