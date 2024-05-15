<?php

include_once __DIR__ . "/../config/env.php";
include_once __DIR__ . "/../helpers.php";
include_once __DIR__ . "/../reset-code.php";
include_once __DIR__ . "/../db-connection.php";

$method = $_SERVER["REQUEST_METHOD"];

// User password update action. Preliminarily compares the user's reset code with the value from the database
if ($method === "POST"){

    if (isset($_POST["password"], $_POST["confirm-password"], $_SESSION["reset"]["code"]) && !empty($_SESSION["reset"]["code"])) {
        if (checkResetCode($_SESSION["reset"]["code"])){

            $fields = [
                "password" => trim($_POST["password"]),
                "confirm-password" => trim($_POST["confirm-password"])
            ];

            if (isset($_SESSION["reset"]["user_id"]) && !empty($_SESSION["reset"]["user_id"])) {

                $userID = $_SESSION["reset"]["user_id"];

                if (validateFields($fields)) {
                    if ($fields["password"] === $fields["confirm-password"]){
                        $mysqli = getMysqli();

                        // Update the password hash in the database
                        $passwordHash = password_hash($fields["password"], PASSWORD_DEFAULT);
                        $query = "UPDATE users SET password_hash = ? WHERE id = ?";
                        $values = [$passwordHash, $userID];
                        executeQueryDB($mysqli, $query, $values, "si");

                        // Delete all active sessions and their tokens except the current one if it exists
                        if (isset($_COOKIE["token"]) && !empty($_COOKIE["token"])) {
                            $token = $_COOKIE["token"];
                            $tokenHash = hash("sha256", $token);
                            $query = "DELETE FROM auth_tokens WHERE user_id = ? AND NOT token_hash = ?";
                            $values = [$userID, $tokenHash];
                            executeQueryDB($mysqli, $query, $values, "is");
                        } else {
                            $query = "DELETE FROM auth_tokens WHERE user_id = ?";
                            $values = [$userID];
                            executeQueryDB($mysqli, $query, $values, "i");
                        }

                        // Delete data from the reset_codes table for the current user ID
                        $query = "DELETE FROM reset_codes WHERE user_id = ?";
                        $values = [$userID];
                        executeQueryDB($mysqli, $query, $values, "i");

                        $_SESSION["response"]["status"] = "success";
                        $_SESSION["response"]["message"] = "Your password has been successfully changed!";
                        unset($_SESSION["reset"]);
                        header("Location: /");
                        exit;
                    } else {
                        setOldValues($fields);
                        $_SESSION["response"]["message"] = "Form error";
                        $_SESSION["response"]["errors"]["confirm-password"] = "passwords must match";
                    }
                } else {
                    setOldValues($fields);
                    $_SESSION["response"]["message"] = "Form error";
                }
            }
        } else {
            $_SESSION["response"]["status"] = "failure";
            openErrorPage(404, "Link is incorrect or expire");
            exit;
        }
    }
    $_SESSION["response"]["status"] = "failure";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    exit;
}
