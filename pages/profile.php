<?php

include_once __DIR__ . "/../src/config/env.php";
include_once __DIR__ . "/../src/db-connection.php";
include_once __DIR__ . "/../src/auth-token.php";
include_once __DIR__ . "/../src/helpers.php";

if (isAuthorized()){
    if (isset($_SESSION["user"]["name"], $_SESSION["user"]["email"], $_SESSION["user"]["avatar"]) && !empty($_SESSION["user"]["name"]) && !empty($_SESSION["user"]["email"])){
        $userName = $_SESSION["user"]["name"];
        $userEmail = $_SESSION["user"]["email"];
        $userAvatar = $_SESSION["user"]["avatar"];
?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . "/../components/head.html";?>
<body>
    <div class="container container_profile">
        <h3 class="title">Profile editor</h3>
        <?php require_once __DIR__ . "/../components/message.php";?>
        <div class="profile profile_editor">
            <div class="profile__layout">
                <div class="avatar">
                    <div class="avatar__content">
                        <?php showAvatar($userAvatar, 100);?>
                        <?php if($userAvatar){ ?>
                            <ul class="dropdown">
                                <li class="dropdown__option dropdown__option_update">
                                    <form action="/src/actions/delete-avatar.php" class="dropdown__action" method="post">
                                        <button role="button" class="dropdown__button dropdown__button_delete" name="button_delete-avatar">
                                            <i class="fa-solid fa-trash"></i> Delete photo
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        <?php } ?>
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
                                <input type="text" class="form__input-value" id="name" name="name" value="<?php echo getOldValue("name", $userName);?>" autocomplete="off">
                            </div>
                            <?php showError("name");?>
                        </div>
                        <div class="form__field form__field_email <?php echo addInvalidClass("email");?>">
                            <div class="form__input form__input_email">
                                <label for="email" class="form__label">Email</label>
                                <input type="text" class="form__input-value" id="email" name="email" value="<?php echo getOldValue("email", $userEmail);?>" autocomplete="off">
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