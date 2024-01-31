<?php
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/session.php";
?>
<!DOCTYPE html>
<html>
<?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/head.html";?>
<body>
    <div class="container">
        <h3 class="title" style="text-decoration-color: #d93025">404</h3>
        <div class="message failure">
            <p class="message-text">
                <?php
                if(isset($_SESSION["response"]["message"]) && !empty($_SESSION["response"]["message"])) {
                    echo $_SESSION["response"]["message"];
                } else{
                    echo "NOT FOUND";
                }
                unset($_SESSION["response"]);
                ?>
            </p>
        </div>
        <div class="redirect">
            <a href="/" class="redirect__link">Home</a>
        </div>
    </div>
</body>
</html>