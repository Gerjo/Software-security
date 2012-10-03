<?php

date_default_timezone_set("America/New_York");
error_reporting(-1);
ini_set("session.save_path", $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR  . ".." . DIRECTORY_SEPARATOR . "tmp/");

return false;

$direct = array('php', 'gif', 'png', 'jpg', 'css', 'js', 'xml', 'ico', 'swf', 'class', 'db');
$info   = pathinfo($_SERVER["PHP_SELF"]);

if(isset($info["extension"]) && in_array($info["extension"], $direct)) {
    return false; // serve the requested resource as-is.
}

print "ehhh?";
