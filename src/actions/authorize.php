<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/session.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/config.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/db-connection.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/auth-token.php";

$method = $_SERVER["REQUEST_METHOD"];

// The action for user authentication and authorization using a password
if ($method === "POST"){
    if (isset($_POST["email"], $_POST["password"])) {

        $email = $_POST["email"];
        $password = $_POST["password"];

        validateField("email", $email);
        if (empty($password)){
            $_SESSION["response"]["errors"]["password"] = "field is required";
        }
        if (!isset($_SESSION["response"]["errors"])){

            // Query the database for a row with matching the email
            $mysqli = getMysqli();
            $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
            $values = [$email];
            $stmt = executeQueryDB($mysqli, $query, $values);
            $result = mysqli_stmt_get_result($stmt);
            $dataDB = mysqli_fetch_assoc($result);

            // Extract user data from the database if the email was found
            if ($dataDB) {
                $emailDB = $dataDB["email"];
                $passwordDB = $dataDB["password_hash"];
                $nameDB = $dataDB["name"];
                $avatarDB = $dataDB["avatar_path"];
                $userID = $dataDB["id"];

                // Verification of the input password and the password from the database
                if (password_verify($password, $passwordDB)) {

                    // If checkbox "remember me" was clicked set cookie with the auth token for a week
                    if (isset($_POST["remember"]) && $_POST["remember"] == "on"){
                        $token = createAuthToken ($userID);
                        setcookie("token", $token, time() + ONE_WEEK, "/", "", true, true);
                    }

                    // Set sessions with user data
                    $_SESSION["user"] = [
                        "id" => $userID,
                        "name" => $nameDB,
                        "email" => $emailDB,
                        "avatar" => $avatarDB,
                    ];
                    session_regenerate_id(); // refresh session id for security
                    $_SESSION["response"]["status"] = "success";
                    header("Location: /pages/profile.php"); // redirect to profile
                    exit;
                }
                $_SESSION["response"]["message"] = "Incorrect email or password";
            }
        }
        setOldValue("email", $email);
        setOldValue("password", $password);
        $_SESSION["response"]["status"] = "failure";
    }
    header("Location: /pages/login.php"); // redirect to login page
    exit;
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    exit;
}
