<?php

// SESSION config
ini_set("session.use_strict_mode", 1);
ini_set("session.use_only_cookies", 1);

session_set_cookie_params([
    "path" => "/",
    "httponly" => true,
]);
session_start();

// Connecting to the database
const DB_HOST = "yourDbHost", 
DB_NAME = "yourDbName",
DB_USERNAME = "yourDbUserName", 
DB_PASSWORD = "yourDbPassword",
DB_PORT = "3306";

// Constants of time
const ONE_WEEK = 604800,
    ONE_HOUR = 3600;

const VALIDATION_PARAMS = [
    // Parameters for input fields
    "fields" => [
        "name" => [
            "pattern" => "/^([A-Za-z\s]{2,30}|[А-ЯЁа-яё\s]{2,30})$/",
            "error" => "name must be at least 2 characters and contain only letters",
        ],
        "email" => [
            "pattern" => "/^[^ ]+@[^ ]+\.[a-z]{2,3}$/",
            "error" => "enter a valid email address",
        ],
        "password" => [
            "pattern" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/",
            "error" => "password must be at least 6 character with number, small and capital letter",
        ],
        "confirm-password" => [
            "pattern" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/",
            "error" => "password must be at least 6 character with number, small and capital letter",
        ],
    ],
    // Parameters for attached files
    "files" => [
        "avatar" => [
            "requirements" => [
                "types" => ["image/jpeg", "image/jpg", "image/png"],
                "size" => 1 // MB
            ],
            "errors" => [
                "types" => "invalid file type",
                "size" => "the file should not exceed 1 MB",
            ],
        ],
    ],
    // Parameters for generated random code using for reset code or auth token checking
    "code" => [
        "pattern" => "/^(?=.*[a-z])(?=.*\d).{32}$/",
        "error" => "code is invalid"
    ]
];
