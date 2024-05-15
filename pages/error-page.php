<?php
include_once __DIR__ . "/../src/config/env.php";
?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . "/../components/head.html";?>
<body>
    <div class="container">
        <h3 class="title" style="text-decoration-color: #d93025">Error</h3>
        <div class="message show failure">
            <p class="message-text">
                <?php
                if(isset($_SESSION["response"]["message"]) && !empty($_SESSION["response"]["message"])) {
                    echo $_SESSION["response"]["message"];
                } else{
                    echo "Something went wrong. Please try again later.";
                }
                unset($_SESSION["response"]);
                ?>
            </p>
        </div>
        <div class="redirect">
            <a href="/pages/profile.php" class="redirect__link">Home</a>
        </div>
    </div>
</body>
</html>