<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/session.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/config.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/db-connection.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/auth-token.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/avatar-update.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers.php";

//  The action to delete user data from the database and his files from the uploads directory
$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST"){
    if (isAuthorized()) {
        $userID = $_SESSION["user"]["id"];
        avatarUpdate($userID); // delete user avatar file from the uploads directory
    }
    header("Location: /pages/profile.php");
    exit;
}