<?php
    require_once("database.php");

    if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        //$password = password_hash($_POST["password"],PASSWORD_DEFAULT);
        $password = $_POST["password"];

        if (empty($username) || empty($password)) {
            header("Location: ../login.php?error=emptyfields");
            exit;    
        }
        //$sql = "SELECT * FROM users WHERE username = ? AND `password` = ?";
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../login.php?error=sqlerror");
            exit;    
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            //if ($rowCount == 0) {
            if  ($row = mysqli_fetch_assoc($result)){
                $passCheck = password_verify($password, $row["password"]);
                if ($passCheck){
                    //Grant Access
                    session_start();
                    $_SESSION["sessionUname"] = $row["username"];
                    $_SESSION["sessionId"] = $row["id"];
                    header("Location: ../index.php?login=success");
                    exit;            
                }else{
                    header("Location: ../login.php?error=InvalidPassword");
                    exit;            
                }
            }else{
                header("Location: ../login.php?error=usernotfound");
                exit;
            }
            exit;
        }
    }else {
        header("Location: ../login.php?error=unauthorized");
        exit;
    }
?>