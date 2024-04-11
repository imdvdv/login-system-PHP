<?php

include_once __DIR__ . "/../config/env.php";
include_once __DIR__ . "/../helpers.php";
include_once __DIR__ . "/../avatar-update.php";
include_once __DIR__ . "/../db-connection.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST") {

    if (isUserSessionActive() && (isset($_POST["name"], $_POST["email"]) || isset($_FILES["avatar"]))) {

        $userID = $_SESSION["user"]["id"];

        // Avatar image validation if the file was added to the form
        if (isset($_FILES["avatar"]) && $_FILES["avatar"]["size"] > 0) {
            $avatar = $_FILES["avatar"];
            if (validateFile("avatar", $avatar)){
                avatarUpdate($userID, $avatar);
            }
        }

        // Username validation if it has been edited in the form
        if (($_POST["name"] !== $_SESSION["user"]["name"])){
            $name = trim(removeExtraSpaces($_POST["name"]));
            if (validateField("name", $name)){

                // Update user data in the database
                $mysqli = getMysqli();
                $query = "UPDATE users SET name = ? WHERE id = ?";
                $values = [$name, $userID];
                executeQueryDB($mysqli, $query, $values, "si");

                $_SESSION["user"]["name"] = $name;
            } else {
                setOldValue("name", $name);
            }
        }
        // User email validation if it has been edited in the form
        if (($_POST["email"] !== $_SESSION["user"]["email"])){
            $email = trim($_POST["email"]);
            if(validateField("email", $email)){

                // Update user data in the database
                $mysqli = getMysqli();
                $query = "UPDATE users SET email = ? WHERE id = ?";
                $values = [$email, $userID];
                executeQueryDB($mysqli, $query, $values, "si");

                $_SESSION["user"]["email"] = $email;
            } else {
                setOldValue("email", $email);
            }
        }
    }
    header("Location: /pages/profile.php");
    exit;
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    exit;
}
