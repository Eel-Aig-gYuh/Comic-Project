<?php
    session_start();

    require_once ('./database/connect_database.php');

    if(isset($_SESSION['user_id'])) {
        header("Location: ./login.php");
        die();
    }
    if(isset($_POST['username']) && isset($_POST['password'])) {
        $sql = "select * from login where username = '".$_POST['username']."' and password = '".$_POST['password']."' LIMIT 1";
        $ketqua = EXECUTE_RESULT($sql);

        if(count($ketqua) == 0) {
            echo "Mật khẩu không chính xác";
            header("Location: ./login.php");
            die();
        }
        
        $_SESSION['user_id'] = $ketqua[0]['id_user'];

        if($ketqua[0]['id_user'] == 1) {
            header("Location: ./login.php");
            die();
        }
    }
    else {
        header("Location: ./");
        die();
    }

    header("Location: ./");
    die();

?>