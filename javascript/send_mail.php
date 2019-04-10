<?php

    var str = ""
    /*
    This first bit sets the email address that you want the form to be submitted to.
    You will need to change this value to a valid email address that you can access.
    */
    $webmaster_email = "codefirst123@gmail.com";

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$suggestionpage = "suggestion-page.html";
$errorpage = "error-page.html";
$submit = "submit.html";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$firstname = $_REQUEST['firstname'] ;
$lastname = $ REQUEST['lastname'] ;
$emailaddress = $_REQUEST['emailaddress'] ;
$cafetype = $ REQUEST['cafetype'] ;
$cafeinfo = $_REQUEST['cafeinfo'] ;
$msg =
    "First Name: " . $firstname . "\r\n" .
        "Last Name:" . $lastname . "\r\n" .
        "Email: " . $emailaddress . "\r\n" .
        "Cafe Type: " . $cafetype . "\r\n" .
        "Cafe Info: " . $cafeinfo ;

/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
function isInjected($str) {
    $injections = array('(\n+)',
        '(\r+)',
        '(\t+)',
        '(%0A+)',
        '(%0D+)',
        '(%08+)',
        '(%09+)'
        );
    $inject = join('|', $injections);
    $inject = "/$inject/i";
    if(preg_match($inject,$str)) {
        return true;
    }
    else {
        return false;
    }
}

function empty () {}

function join () {}

// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['emailaddress'])) {
    header( "Location: $suggestion-page.html" );
}

// If the form fields are empty, redirect to the error page.
else if (empty($firstname) || empty($lastname) || empty($emailaddress) || empty($cafeinfo) || empty($cafetype)) {
    header( "Location: $error-page" );
}

/*
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
else if ( isInjected($firstname) || isInjected($lastname)|| isInjected($emailaddress) || isInjected($cafetype) || isInjected($cafeinfo) ) {
    header( "Location: $errorpage" );
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {

    mail("$webmaster_email", "Suggestion Form Results", $msg);

    header( "Location: $submit" );
}
    ?>