<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/session.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/config.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/db-connection.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/auth-token.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers.php";

if (isAuthorized()){
    header("Location: /pages/profile.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/head.html";?>
<body>
<div class="container container_form">
    <h3 class="title">Registration</h3>
    <?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/message.php";?>
    <form action="/src/actions/register.php" method="post" name="form_signup" class="form form_signup" id="form_signup">
        <div class="form__field form__field_name <?php echo addInvalidClass("name");?>">
            <div class="form__input form__input_name">
                <label for="name" class="form__label">Name*</label>
                <input type="text" class="form__input-value" value="<?php echo getOldValue("name");?>" id="name" name="name" autocomplete="off">
            </div>
            <?php showError("name");?>
        </div>
        <div class="form__field form__field_email <?php echo addInvalidClass("email");?>">
            <div class="form__input form__input_email">
                <label for="email" class="form__label">E-mail*</label>
                <input type="text" class="form__input-value" value="<?php echo getOldValue("email");?>" id="email" name="email" autocomplete="off">
            </div>
            <?php showError("email");?>
        </div>
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
        <button type="submit" class="form__button form__button_signup">Sign Up</button>
    </form>
    <div class="redirect">
        <span class="redirect__text">Already have an account?
            <a href="/pages/login.php" class="redirect__link">Log In</a>
        </span>
    </div>
</div>
</body>
</html>
<?php removeResponseSession();?>