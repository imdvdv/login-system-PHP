<?php

function createResetCode (int $userID): string{

    // Create a reset code data to change password
    $codeData = getRandomCodeData (ONE_HOUR);
    $code = $codeData["code"];
    $codeHash = $codeData["codeHash"];
    $codeExpiry = $codeData["codeExpiry"];

    // Check the reset code exists in the database for this user ID
    $mysqli = getMysqli();
    $query = "SELECT * FROM reset_codes WHERE user_id = ? LIMIT 1";
    $values = [$userID];
    $stmt = executeQueryDB($mysqli, $query, $values, "i");

    $result = mysqli_stmt_get_result($stmt);
    $dataDB = mysqli_fetch_assoc($result);

    // If there is already a reset code row for a given user in the database, overwrite it with a new one
//    if ($stmt->rowCount() == 1){
    if ($dataDB){
        $query = "UPDATE reset_codes SET code_hash = ?, code_expiry = ? WHERE user_id = ?";
        $values = [$codeHash, $codeExpiry, $userID];
        $types = "ssi";
    } else {
        $query = "INSERT INTO reset_codes (user_id, code_hash, code_expiry)
            VALUES(?,?,?)";
        $values = [$userID, $codeHash, $codeExpiry];
        $types = "iss";
    }
    executeQueryDB($mysqli, $query, $values, $types);
    return $code;
}

function checkResetCode (string $code): bool {

    if (validateCode($code)){

        // Check the code hash exists in the database
        $codeHash = hash("sha256", $code); // hashing the code
        $mysqli = getMysqli();
        $query = "SELECT * FROM reset_codes WHERE code_hash = ? LIMIT 1";
        $values = [$codeHash];
        $stmt = executeQueryDB($mysqli, $query, $values);
        $result = mysqli_stmt_get_result($stmt);
        $dataDB = mysqli_fetch_assoc($result);

        // if the code hashes match, extract the code data from the database
        if ($dataDB) {
            $codeID = $dataDB["id"];
            $codeExpiryDB = $dataDB["code_expiry"];
            $userID = $dataDB["user_id"];

            // Check code expiration time
            if (strtotime($codeExpiryDB) <= time()) {
                $query = "DELETE FROM reset_codes WHERE id = ? LIMIT 1";
                $values = [$codeID];
                executeQueryDB($mysqli, $query, $values, "i"); // delete expire code data from the database
            } else {

                // Set session with the reset code for using in passwordUpdate function
                $_SESSION["reset"] = [
                    "code" => $code,
                    "user_id" => $userID,
                ];
                session_regenerate_id();
                return true;
            }
        }
    }
    return false;
}