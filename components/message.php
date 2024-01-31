<?php

    if(isset($_SESSION["response"]["message"]) && !empty($_SESSION["response"]["message"])) {
        ?>
        <div class="message <?php echo $_SESSION["response"]["status"] ?? "" ;?>">
            <p class="message-text"><?php echo $_SESSION["response"]["message"];?></p>
        </div>
        <?php
        unset($_SESSION["response"]["message"], $_SESSION["response"]["status"]);
    }?>