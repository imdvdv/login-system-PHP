<div class="avatar">
    <?php
    if($_SESSION["user"]["avatar"]){ ?>
        <div class="avatar__content">
            <img class="avatar__image" src="<?=$_SESSION["user"]["avatar"]?>" width="100px" height="100px" alt="avatar">
            <ul class="drop-menu">
                <li class="drop-menu__option drop-menu__option_delete">
                    <form action="/src/actions/delete-avatar.php" class="drop-menu__action" method="post">
                        <button role="button" class="drop-menu__button drop-menu__button_delete" name="button_delete-avatar">
                            <i class="fa-solid fa-trash"></i> Delete photo
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <?php
    } else{ ?>
        <i class="avatar__image fa-solid fa-circle-user" style="font-size: 100px"></i>
    <?php } ?>
</div>

