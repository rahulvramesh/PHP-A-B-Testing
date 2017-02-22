<?php
/**
 * Module For A/B Testing
 * Author: rahulvramesh
 */

//Enable Error Logging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

//Set Variables
$cookieName = "VALENTINEAB";
$folderName = "tmp";
$host  = $_SERVER['HTTP_HOST'];

//Added AB Testing Pages Here [Limit - 2]
$pages = array(
    1 => "file.php",
    2 => "file2.php"
);

//Check Cookie Set
if(!isset($_COOKIE[$cookieName])) {

    //Get Value From File
    $last = file_get_contents($folderName."/".$cookieName.".txt");

    if($last == 1) {
        $cookieValue = 2;
    }
    else {
        $cookieValue = 1;
    }

    //Set Cookie
    setcookie($cookieName, $cookieValue, time() + (86400 * 30), "/"); // 86400 = 1 day

    //Set File
    file_put_contents($folderName."/".$cookieName.".txt", $cookieValue);

    //Include / Redirect Page
    header("Location: http://$host/$pages[$cookieValue]");

} else {
    
    //Get Value From Cookie
    $pageId = $_COOKIE[$cookieName];

    //Redirect
    header("Location: http://$host/$pages[$pageId]");
}

?>