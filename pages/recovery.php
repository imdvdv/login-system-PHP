<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/session.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/config.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/db-connection.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/auth-token.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers.php";

if (isAuthorized()){
    header("Location:{$_SERVER["DOCUMENT_ROOT"]}/pages/profile.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/head.html";?>
<body>
<div class="container container_form">
    <h3 class="title">Access recovery</h3>
    <?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/message.php";?>
    <form action="/src/actions/access-recovery.php" method="post" name="form_login" class="form form_login" id="form_login">
        <div class="form__field form__field_email <?php echo addInvalidClass("email");?>">
            <div class="form__input form__input_email">
                <label for="email" class="form__label">E-mail*</label>
                <input type="text" class="form__input-value" value="<?php echo getOldValue("email");?>" id="email" name="email" autocomplete="off">
            </div>
            <?php showError("email");?>
        </div>
        <div class="form__options">
            <a href="/pages/login.php" class="form__link">I have a password</a>
        </div>
        <button type="submit" class="form__button form__button_recovery" name="button_recovery">Send Instructions</button>
    </form>
    <div class="redirect">
        <span class="redirect__text">Don't have an account?
            <a href="/pages/signup.php" class="redirect__link">Sign Up</a>
        </span>
    </div>
</div>
</body>
</html>
<?php removeResponseSession();?>