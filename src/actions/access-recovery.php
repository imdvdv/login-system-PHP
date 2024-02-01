<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/session.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/config.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/reset-code.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/db-connection.php";

$method = $_SERVER["REQUEST_METHOD"];

// The action checks the existence of an email in the database and sends a link to the password change page to this address
if ($method === "POST"){

    if (isset($_POST["email"])) {
        $email = trim($_POST["email"]);

        if (validateField("email", $email)) {

            // Prepare a positive response (report successful sending even if the email address was not found in the database)
            $_SESSION["response"]["status"] = "success";
            $_SESSION["response"]["message"] = "An email with instructions was sent to the specified address";

            // Query the database for a row with the matching email
            $mysqli = getMysqli();
            $query = "SELECT id FROM users WHERE email = ? LIMIT 1";
            $values = [$email];
            $stmt = executeQueryDB($mysqli, $query, $values);
            $result = mysqli_stmt_get_result($stmt);
            $dataDB = mysqli_fetch_assoc($result);

            // Extract user data from the database if the email was found
            if ($dataDB){
                $userID = $dataDB["id"];
                $code = createResetCode($userID); // create reset code for given user

                // Generate and send an email with a link to the password change page using the built-in mail function
                $to = $email;
                $subject = "Password recovery";
                $message = 'To reset a password and create new - <a href="http://{YOUR HOST}/pages/change-password.php?code='.$code.'">click here</a>. </br>Reset your password in a hour.';
                $headers = "From: YOUR SENDER EMAIL ADDRESS\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                if (!mail($to, $subject, $message, $headers)){

                    // Prepare a negative response in case the mail function does not generate the letter
                    $_SESSION["response"]["status"] = "failure";
                    $_SESSION["response"]["message"] = "The email could not be sent due to technical reasons. Please try again later";
                }
            }
        } else {
            setOldValue("email", $email);
            $_SESSION["response"]["status"] = "failure";
            $_SESSION["response"]["message"] = "Form error";
        }
    }
    header("Location: {$_SERVER['HTTP_REFERER']}"); // redirect to recovery page
    exit;
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    exit;
}
