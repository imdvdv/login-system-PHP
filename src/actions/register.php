<?php

include_once __DIR__ . "/../config/env.php";
include_once __DIR__ . "/../helpers.php";
include_once __DIR__ . "/../db-connection.php";

$method = $_SERVER["REQUEST_METHOD"];

// The action creates a new row in the users table, writing his values to the database if they were specified correctly
if ($method === "POST"){
    if (isset($_POST["name"], $_POST["email"], $_POST["password"], $_POST["confirm-password"])) {

        $name = trim(removeExtraSpaces($_POST["name"]));
        $email = trim($_POST["email"]);
        $passwords = [
            "password" => trim($_POST["password"]),
            "confirm-password" => trim($_POST["confirm-password"])
        ];

        validateField("name", $name);
        if (validateFields($passwords)){
            if ($passwords["password"] !== $passwords["confirm-password"]){
                $_SESSION["response"]["errors"]["confirm-password"] = "passwords must match";
            }
        }
        if (validateField("email", $email)) {
            $mysqli = getMysqli();

            // Check the email exists in the database
            $query = "SELECT email FROM users WHERE email = ? LIMIT 1";
            $values = [$email];
            $stmt = executeQueryDB($mysqli, $query, $values);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {

                $_SESSION["response"]["errors"]["email"] = "this email already exists";

            } elseif (!isset($_SESSION["response"]["errors"])) {

                // Write user data to the database
                $passwordHash = password_hash($passwords["password"], PASSWORD_DEFAULT);
                $query = "INSERT INTO users (name, email, password_hash)
                VALUES(?,?,?)";
                $values = [$name, $email, $passwordHash];
                executeQueryDB($mysqli, $query, $values);

                $_SESSION["response"]["status"] = "success";
                $_SESSION["response"]["message"] = "Your account has been successfully created";

                header("Location: /pages/signup.php");
                exit;
            }
        }
        setOldValue("name", $name);
        setOldValue("email", $email);
        setOldValues($passwords);
        $_SESSION["response"]["status"] = "failure";
        $_SESSION["response"]["message"] = "Form error";
        header("Location: /pages/signup.php");
        exit;
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    exit;
}

