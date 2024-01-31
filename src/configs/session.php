<?php

ini_set("session.use_strict_mode", 1);
ini_set("session.use_only_cookies", 1);

session_set_cookie_params([
    //"domain" => "localhost",
    "path" => "/",
    "httponly" => true,
    "secure" => true,
    "samesite" => "lax"
]);

session_start();

