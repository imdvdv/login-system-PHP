<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/session.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/config.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/db-connection.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/auth-token.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers.php";

if (isAuthorized()){
    if (isset($_SESSION["user"]["name"], $_SESSION["user"]["email"]) && !empty($_SESSION["user"]["name"]) && !empty($_SESSION["user"]["email"])){
        $user_name = $_SESSION["user"]["name"];
        $user_email = $_SESSION["user"]["email"];
?>
<!DOCTYPE html>
<html>
<?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/head.html";?>
<body>
    <div class="container container_profile">
        <h3 class="title">Profile editor</h3>
        <?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/message.php";?>
        <div class="profile profile_editor">
            <div class="profile__layout">
                <div class="avatar">
                    <div class="avatar__content">
                        <?php showAvatar($userAvatar, 100);?>
                        <ul class="dropdown">
                            <li class="dropdown__option dropdown__option_update">
                                <button role="button" class="dropdown__button dropdown__button_update-avatar">
                                    <i class="fa-solid fa-pen-to-square"></i> Update photo
                                </button>
                                <?php if($userAvatar){ ?>
                                    <button role="button" class="dropdown__button dropdown__button_delete-avatar">
                                        <i class="fa-solid fa-trash"></i> Delete photo
                                    </button>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="profile__info">
                    <form action="/src/actions/edit-profile.php" method="post" name="form_editor" class="form form_editor" id="form_editor" enctype="multipart/form-data">
                        <div class="form__field form__field_avatar file <?php echo addInvalidClass("avatar");?>">
                            <div class="form__input form__input_avatar">
                                <label for="avatar" class="form__label">Profile photo</label>
                                <input type="file" class="form__input-value custom-file" id="avatar" name="avatar">
                            </div>
                            <?php showError("avatar");?>
                        </div>
                        <div class="form__field form__field_name <?php echo addInvalidClass("name");?>">
                            <div class="form__input form__input_name">
                                <label for="name" class="form__label">Name</label>
                                <input type="text" class="form__input-value" id="name" name="name" value="<?php echo getOldValue("name", $user_name);?>" autocomplete="off">
                            </div>
                            <?php showError("name");?>
                        </div>
                        <div class="form__field form__field_email <?php echo addInvalidClass("email");?>">
                            <div class="form__input form__input_email">
                                <label for="email" class="form__label">Email</label>
                                <input type="text" class="form__input-value" id="email" name="email" value="<?php echo getOldValue("email", $user_email);?>" autocomplete="off">
                            </div>
                            <?php showError("email");?>
                        </div>
                        <button type="submit" class="form__button form__button_editor">Save</button>
                    </form>
                    <form action="/src/actions/access-recovery.php" class="profile__action" method="post">
                        <input hidden type="text" name="email" value="<?=$user_email?>">
                        <button role="button" class="profile__button profile__button_change-password">
                            <i class="fa-solid fa-pen-to-square"></i> Change password
                        </button>
                    </form>
                    <form action="/src/actions/logout.php" class="profile__action" method="post">
                        <button role="button" class="profile__button profile__button_logout" name="button_logout">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                        </button>
                    </form>
                </div>
                <form action="/src/actions/delete-profile.php" method="post" class="profile__action">
                    <button role="button" class="profile__button profile__button_delete" name="profile__button_delete">
                        <i class="fa-solid fa-trash"></i> Delete profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
        removeResponseSession();
    }
} else {
    header("Location: /pages/login.php");
    exit;
} ?>