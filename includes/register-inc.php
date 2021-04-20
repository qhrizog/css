<?php
    if (isset($_POST["submit"])){
        require('database.php');

        $username = $_POST['username'];
        $password = $_POST['password'];
        $ConfirmPass = $_POST['confirmPassword'];

        if (empty($username) || empty($password) || empty($ConfirmPass)){
            header("Location: ../register.php?error=emptyFields&username=$username");
            exit();
        }elseif(!preg_match("/^[a-zA-z0-9]*/",$username)){
            header("Location: ../register.php?error=Invalidusername&username=$username");
            exit();
        }elseif($password !== $ConfirmPass){
            header("Location: ../register.php?error=passwordsdonotmatch&username=$username");
            exit();
        }else{
            $sql ="SELECT username FROM users WHERE username = ?";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../register.php?error=sqlerror");
                exit;
            }else{
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount = mysqli_stmt_num_rows($stmt);

                if ($rowCount == 1){
                    header("Location: ../register.php?error=UsernameTaken!");
                    exit;
                }else{
                    $sql = "INSERT INTO users(username, `password`) VALUES (?,?)";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../register.php?error=sqlerror");
                        exit;
                    }else{
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../register.php?error=sqlerror");
                            exit;
                        }else {
                            //Hash Password
                            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPass);
                            mysqli_stmt_execute($stmt);
                            
                            header("Location: ../register.php?success=registered");
                            exit;
                        }
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
?>