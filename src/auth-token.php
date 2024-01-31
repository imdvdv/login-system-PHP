<?php

function createAuthToken (int $userID): string {

    // Create user auth token data
    $tokenData = getRandomCodeData (ONE_WEEK);
    $token = $tokenData["code"];
    $tokenHash = $tokenData["codeHash"];
    $tokenExpiry = $tokenData["codeExpiry"];

    // Write token values to the database
    $mysqli = getMysqli();
    $query = "INSERT INTO auth_tokens (user_id, token_hash, token_expiry)
                    VALUES(?,?,?)";
    $values = [$userID, $tokenHash, $tokenExpiry];
    executeQueryDB($mysqli, $query, $values, "iss");

    return $token;
}

// User authentication and authorization function using a token from cookie
function authByToken (string $token): bool {

    if (validateCode($token)) {
        $mysqli = getMysqli();

        // Query the database for a row with matching token hash if it exists
        $tokenHash = hash("sha256", $token);
        $query = "SELECT * FROM auth_tokens WHERE token_hash = ? LIMIT 1";
        $values = [$tokenHash];
        $stmt = executeQueryDB($mysqli, $query, $values);
        $result = mysqli_stmt_get_result($stmt);
        $dataDB = mysqli_fetch_assoc($result);

        // Extract token data from the database if the token hash was found
        if ($dataDB) {
            $userID = $dataDB["user_id"];
            $tokenID = $dataDB["id"];
            $tokenExpiry = $dataDB["token_expiry"];

            // Check the token expiration time
            if (strtotime($tokenExpiry) <= time()) {
                $query = "DELETE FROM auth_tokens WHERE id = ?";
                $values = [$tokenID];
                executeQueryDB($mysqli, $query, $values, "i"); // delete an expired token from the database
            } else {

                // Update auth token data
                $newTokenData = getRandomCodeData(ONE_WEEK);
                $newToken = $newTokenData["code"];
                $newTokenHash = $newTokenData["codeHash"];
                $newTokenExpiry = $newTokenData["codeExpiry"];
                $query = "UPDATE auth_tokens SET token_hash = ?, token_expiry = ? WHERE id = ?";
                $values = [$newTokenHash, $newTokenExpiry, $tokenID];
                executeQueryDB($mysqli, $query, $values, "ssi");

                setcookie("token", $newToken, time() + ONE_WEEK, "/", "", true, true);// refresh the token cookie

                // Query the database for a row with the matching user ID
                $query = "SELECT * FROM users WHERE id = ? LIMIT 1";
                $values = [$userID];
                $stmt = executeQueryDB($mysqli, $query, $values, "i");
                $result = mysqli_stmt_get_result($stmt);
                $dataDB = mysqli_fetch_assoc($result);

                // Extract user data from the database if ID was found
                if ($dataDB) {

                    // Set sessions with user data
                    $_SESSION["user"] = [
                        "id" => $userID,
                        "name" => $dataDB["name"],
                        "email" => $dataDB["email"],
                        "avatar" => $dataDB["avatar_path"],
                    ];
                    session_regenerate_id();
                    return true;
                }
            }
        }
    }
    setcookie("token", "", time() - ONE_WEEK, "/"); // remove the token cookie
    return false;
}