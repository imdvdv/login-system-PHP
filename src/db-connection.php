<?php

function getMysqli(): mysqli {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
        mysqli_set_charset($mysqli,'utf8mb4');
        mysqli_options($mysqli,MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
        return $mysqli;
    } catch (mysqli_sql_exception $e) {
        http_response_code(500);
        die("Connection failed: ". $e->getMessage());
    }
}

function executeQueryDB (mysqli $mysqli, string $query, array $values, string $types = ""): mysqli_stmt {
    try {
        $types = $types ?: str_repeat("s", count($values));
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, $types, ...$values);
        mysqli_stmt_execute($stmt);
        return $stmt;
    } catch(mysqli_sql_exception $e){
        http_response_code(500);
        die("Connection failed: ". $e->getMessage());
    }
}

