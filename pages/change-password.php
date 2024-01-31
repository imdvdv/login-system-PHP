<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/session.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/config.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/db-connection.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/reset-code.php";

if (isset($_GET["code"]) && !empty($_GET["code"]) && checkResetCode($_GET["code"])) {
?>
<!DOCTYPE html>
<html>
<?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/head.html";?>
<body>
<div class="container container_form">
    <h3 class="title">Create a new password</h3>
    <?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/message.php";?>
    <form action="/src/actions/password-update.php" method="post" class="form form_change" name="form_change" id="form_change">
        <div class="form__field form__field_password <?php echo addInvalidClass("password");?>">
            <div class="form__input form__input_password">
                <label for="password" class="form__label">Password*</label>
                <input type="password" class="form__input-value" value="<?php echo getOldValue("password");?>" id="password" name="password" autocomplete="off">
            </div>
            <?php showError("password");?>
        </div>
        <div class="form__field form__field_confirm-password <?php echo addInvalidClass("confirm-password");?>">
            <div class="form__input form__input_confirm-password">
                <label for="confirm-password" class="form__label">Confirm password*</label>
                <input type="password" class="form__input-value" value="<?php echo getOldValue("confirm-password");?>" id="confirm-password" name="confirm-password" autocomplete="off">
            </div>
            <?php showError("confirm-password");?>
        </div>
        <button type="submit" class="form__button form__button_change" name="button_change">Change</button>
    </form>
    <div class="redirect">
        <a href="/pages/profile.php" class="redirect__link">Home</a>
    </div>
</div>
</body>
</html>
<?php
    removeResponseSession();
} else {
    $_SESSION["response"]["message"] = "Link is incorrect or expire";
    header("Location: /pages/404.php");
    exit;
} ?>