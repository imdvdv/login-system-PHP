<?php

include_once __DIR__ . "/../config/env.php";
include_once __DIR__ . "/../db-connection.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST"){

    // Remove user auth token from cookies and from the database if it exists
    if (isset($_COOKIE["token"]) && !empty($_COOKIE["token"])) {
        $token = $_COOKIE["token"];
        $tokenHash = hash("sha256", $token); // token hashing

        // Delete a row with the matching token hash from the database
        $mysqli = getMysqli();
        $query = "DELETE FROM auth_tokens WHERE token_hash = ? LIMIT 1";
        $values = [$tokenHash];
        executeQueryDB($mysqli, $query, $values);

        setcookie("token", "", time() - ONE_HOUR, "/"); // clear token cookie
    }

    // Clear current user session
    setcookie("PHPSESSID", "", time() - ONE_HOUR, "/");
    session_unset();
    session_destroy();

    header("Location: /pages/login.php");
    exit;

} else {
    header("HTTP/1.1 405 Method Not Allowed");
    exit;
}

