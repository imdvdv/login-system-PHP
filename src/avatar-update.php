<?php

function avatarUpdate (int $userID, array $file = null): void {

    // If the function was not passed a file, it deletes the current profile image if it exists
    if ($file !== null){
        $avatarPath = fileUpload($file, "avatars");
        if (!$avatarPath) {
            die("avatar upload error");
        }
    } else {
        $avatarPath = null;
    }

    // Delete the avatar file from the uploads directory if it exists
    $mysqli = getMysqli();
    $query = "SELECT avatar_path FROM users WHERE id = ? LIMIT 1";
    $values = [$userID];
    $stmt = executeQueryDB($mysqli, $query, $values, "i");
    $result = mysqli_stmt_get_result($stmt);
    $dataDB = mysqli_fetch_assoc($result); // extract user avatar path from the database

    if ($dataDB){
        $avatarPathDB = $dataDB["avatar_path"];

        if ($avatarPathDB) {
            unlink("{$_SERVER["DOCUMENT_ROOT"]}$avatarPathDB"); // delete avatar file
        }
    }

    // Update avatar path in the users table for a given user ID
    $query = "UPDATE users SET avatar_path = ? WHERE id = ?";
    $values = [$avatarPath, $userID];
    executeQueryDB($mysqli, $query, $values, "si");

    $_SESSION["user"]["avatar"] = $avatarPath;

}