<?php
    require_once('includes/header.php');
?>
<h1>
<?php
    if(isset($_SESSION["sessionId"])){
        echo "Welcome " . $_SESSION["sessionUname"];
    }else{
        echo "Holla, mudo";
    }
?>
</h1>
<?php
    require_once('includes/footer.php');
?>