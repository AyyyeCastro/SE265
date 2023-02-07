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

    #--- Important note ---#
        # $_SESSION['userID'] = $userDatabase->getUserId($userName);
        # Needs to be set at login.php, to also set the userID variable.
        # Otherwise, it isUserLoggedIn() will always return false, and u can't login.
}

?>

<!-- Jabascript functions -->
<script>
    // work in progress.

    // Confirm a deletion click.
    function confirmDelete() {
        const message = confirm("Do you want to permanently delete this?");
        if(message){
            alert("Your selection has been permanently deleted.");
        }
        else{
            alert("Nothing has been deleted.");
            e.preventDefault();
        }
    }

    // Confirm a Cancel click.
    function confirmCancel() {
        const message = confirm("Are you sure you want to cancel your work?");
        if(message){
            alert("Redirecting You Back...");
        }
        else{
            alert("Nothing has been canceled.");
        }
    }    



</script>