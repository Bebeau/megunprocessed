<?php

$numb = $_GET["numb"];

// Check to see if submission has email, and send autoresponder if it does.
if( !empty($_POST['emailaddress_'.$numb]) && isset($_GET["ajax"]) ) {

    $firstname = isset( $_POST['firstname_'.$numb] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['firstname_'.$numb] ) : "";
    $lastname = isset( $_POST['lastname_'.$numb] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['lastname_'.$numb] ) : "";
    $emailaddress = filter_var($_POST['emailaddress_'.$numb], FILTER_SANITIZE_EMAIL);

    // aweber api integration goes here

    $success = "Success";

} else {
    $success = "E";
}
echo $success;

?>
