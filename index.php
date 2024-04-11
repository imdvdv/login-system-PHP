<?php

include_once __DIR__ . "/src/config/env.php";
include_once __DIR__ . "/src/auth-token.php";
include_once __DIR__ . "/src/db-connection.php";
include_once __DIR__ . "/src/helpers.php";

if (isAuthorized()){
    header("Location:/pages/profile.php");
} else {
    header("Location:/pages/login.php");
}
exit;