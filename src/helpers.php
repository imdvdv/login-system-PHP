<?php

// The function replaces multiple spaces in a string with one
function removeExtraSpaces (string $str): string {
    return preg_replace("/\s+/", " ", $str);
}

function validateField (string $key, string $value, array $params = VALIDATION_PARAMS["fields"]): bool{
    if (empty($value)) {
        $_SESSION["response"]["errors"][$key] = "field is required";
        return false;
    } else if (!preg_match($params[$key]["pattern"], $value)){
        $_SESSION["response"]["errors"][$key] = $params[$key]["error"];
        return false;
    }
    return true;
}

function validateFields (array $fields, array $params = VALIDATION_PARAMS["fields"]): bool{
    $result = true;
    foreach ($fields as $key => $value) {
        if (!validateField($key, $value, $params)) {
            $result = false;
        }
    }
    return $result;
}

function validateFile (string $key, array $file, array $params = VALIDATION_PARAMS["files"]): bool {
        if (!in_array($file["type"], $params[$key]["requirements"]["types"])) {
            $_SESSION["response"]["errors"][$key] = $params[$key]["errors"]["types"];
            return false;
        } else if ($params[$key]["requirements"]["size"] < $file["size"] / 1000000) {
            $_SESSION["response"]["errors"][$key] = $params[$key]["errors"]["size"];
            return false;
        }
    return true;
}

function validateCode (string $code, $params = VALIDATION_PARAMS["code"]) :bool{
    preg_match($params["pattern"], $code) ? $isValid = true : $isValid = false;
    return $isValid;
}

function isUserSessionActive (): bool{
    if (isset($_SESSION["user"]["id"], $_SESSION["user"]["name"], $_SESSION["user"]["email"])
        && !empty($_SESSION["user"]["id"]) && !empty($_SESSION["user"]["name"]) && !empty($_SESSION["user"]["email"])) {
        return true;
    }
    return false;
}

function isAuthorized (): bool {
    if (isUserSessionActive()) {
        return true;
    } elseif (isset($_COOKIE["token"]) && !empty($_COOKIE["token"])){
        $token = $_COOKIE["token"];
        return authByToken($token);
    }
    return false;
}

// For creating user auth token and password reset code
function getRandomCodeData ($expirationDate = null): array{
    $code = bin2hex(random_bytes(16));
    $codeHash = hash("sha256", $code);
    $codeData =  [
        "code" => $code,
        "codeHash" => $codeHash,
    ];
    if ($expirationDate) {
        $codeExpiry = date("Y-m-d H:i:s", time() + $expirationDate); // set expiration time for code
        $codeData["codeExpiry"] = $codeExpiry;
    }
    return $codeData;
}

function fileUpload (array $file, string $extendedPath = null) :string|false {
    // Upload path initialization
    $relativeUploadPath = "/uploads"; // default uploads path
    $absoluteUploadPath = "{$_SERVER["DOCUMENT_ROOT"]}/uploads";

    if ($extendedPath !== null){
        $relativeUploadPath = "$relativeUploadPath/$extendedPath"; // add extended path to default path if it passed
        $absoluteUploadPath = "$absoluteUploadPath/$extendedPath";
    }
    // Check the uploads directory exist and make it if it's not
    if (!is_dir($relativeUploadPath)){
        mkdir($relativeUploadPath, 0777, true);
    }
    // Prepare the file data
    $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $fileName = date("Y-m-d_H-i-s") . "_" . bin2hex(random_bytes(5)) . ".$fileExtension";
    $relativeFilePath = "$relativeUploadPath/$fileName";
    $absoluteFilePath = "$absoluteUploadPath/$fileName";

    // If the file was successfully uploaded to the server the function will return its path, otherwise will return false
    if (move_uploaded_file($file["tmp_name"], $absoluteFilePath)){
        return $relativeFilePath ;
    }
    return false;
}

//  The function to delete user data from the database and his files from uploads
function deleteUser (int $userID) :void {
    $mysqli = getMysqli();
    $values = [$userID];
    $types = "i";

    // Delete data from the authorization tokens table for a given user ID
    $query = "DELETE FROM auth_tokens WHERE user_id = ?";
    executeQueryDB($mysqli, $query, $values, $types);

    // Delete data from the reset codes table for a given user ID
    $query = "DELETE FROM reset_codes WHERE user_id = ?";
    executeQueryDB($mysqli, $query, $values, $types);

    // Delete data from the users table for a given user ID
    $query = "DELETE FROM users WHERE id = ? LIMIT 1";
    executeQueryDB($mysqli, $query, $values, $types);
}

function setOldValue(string $key, mixed $value): void {
    $_SESSION["response"]["old_values"][$key] = $value;
}

function setOldValues(array $fields): void {
    foreach ($fields as $key => $value) {
        setOldValue($key, $value);
    }
}

function getOldValue(string $key, $defaultValue = "") {
    $value = $_SESSION["response"]["old_values"][$key] ?? $defaultValue;
    unset($_SESSION["response"]["old_values"][$key]);
    return $value;
}

function addInvalidClass(string $key) {
    return isset($_SESSION["response"]["errors"][$key]) ? "invalid" : "";
}

function showError (string $fieldKey): void {
    if(isset($_SESSION["response"]["errors"][$fieldKey]) && !empty($_SESSION["response"]["errors"][$fieldKey])) {?>
        <div class="form__error">
            <i class="form__error-icon fa-solid fa-circle-exclamation"></i>
            <span class="form__error-text "><?php echo $_SESSION["response"]["errors"][$fieldKey];?></span>
        </div>
        <?php
        unset($_SESSION["response"]["errors"][$fieldKey]);
    }
}

function removeResponseSession(): void {
    if (isset($_SESSION["response"])){
        unset($_SESSION["response"]);
    }
}


