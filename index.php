<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/session.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/config.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/auth-token.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/db-connection.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers.php";

if (isAuthorized()){
    header("Location:/pages/profile.php");
} else {
    header("Location:/pages/login.php");
}
exit;