<?php

include_once __DIR__ . "/../config/env.php";
include_once __DIR__ . "/../db-connection.php";
include_once __DIR__ . "/../auth-token.php";
include_once __DIR__ . "/../avatar-update.php";
include_once __DIR__ . "/../helpers.php";

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